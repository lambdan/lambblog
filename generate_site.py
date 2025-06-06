#!/usr/bin/env python
# -*- coding: utf-8 -*-
import markdown2
from bs4 import BeautifulSoup
from slugify import slugify
from dateutil import parser as date_parser
import os, shutil, sys, hashlib, time, requests, re
from datetime import datetime
from PIL import Image
from email import utils
from curses import ascii
from collections import Counter
from argparse import ArgumentParser
from tqdm import tqdm
import PyRSS2Gen
import boto3
import pytz

script_run_time = datetime.now()

########################### Settings ################################
SITE_TITLE = 'djs scribbles'
SITE_TITLE_SUFFIX = ' - ' + SITE_TITLE # at the end of every <title>

CSS_FILE = 'css-oled-2022.css' # should be in the root of ./includes/

AUTHOR_NAME = 'djs'
AUTHOR_EMAIL = 'david@lambdan.se' # these are in the footer
SITE_STARTED_YEAR = 2012 # used for (c) in the footer

POSTS_DIR = './posts/'
INCLUDE_FOLDER = './includes/'
OTHER_PAGES_FOLDER = './pages/'
VALID_POST_EXTENSIONS = ['.txt', '.text.', '.md', '.markdown']

STATS_WHITELISTED_CHARACTERS = set('abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ åäö ÅÄÖ')
#####################################################################

# handle arguments
parser = ArgumentParser()
parser.add_argument("--output-folder", '-o', action='store', dest='folder', help='generated website appears here (default: ./_output/')
parser.add_argument("--timezone", '-tz', action='store', dest='timezone', help='set timezone for dates (default: Europe/Stockholm)', default='Europe/Stockholm')
parser.add_argument("--s3-bucket", '-b', required=True, action='store', dest='s3bucket', help='S3 bucket to upload images')
parser.add_argument("--s3-region", '-r', required=True, action='store', dest='s3region', help='S3 region to use (eg eu-north-1)')
parser.add_argument("--root-url", '-url', action='store', dest='url', help='root url of website (example: https://lambdan.se/blog/)', required=True)
parser.add_argument('--verbose', '-v', action="store_true", dest='verbose', help="print alot of info", default=False)
parser.add_argument('--skip-confirm', '-y', action="store_true", dest='skip_confrm', help="skip confirmation", default=False)
parsed = parser.parse_args()

# if no folder is specified, use ./_output/
SITE_ROOT = parsed.folder if parsed.folder else './_output/'  

S3_BUCKET = parsed.s3bucket
S3_REGION = parsed.s3region
TIMEZONE = pytz.timezone(parsed.timezone)
SITE_ROOT_URL = parsed.url
# TODO: make sure they are valid
print ("Output folder:", SITE_ROOT)
print ("URL Root:", SITE_ROOT_URL)
if not parsed.skip_confrm:
	yn = input("Continue? y/N ").lower()
	if yn != "y":
		print ("exiting...")
		sys.exit(1)

CSS_URL = SITE_ROOT_URL + CSS_FILE

BOTO3_SESSION = boto3.Session(
	region_name=S3_REGION
)
BOTO3_S3_CLIENT = BOTO3_SESSION.client('s3')
S3_EXISTING_KEYS = {}

def s3_list_all_keys(bucket_name, prefix='') -> set:
    keys = []
    paginator = BOTO3_S3_CLIENT.get_paginator('list_objects_v2')
    page_iterator = paginator.paginate(Bucket=bucket_name, Prefix=prefix)

    for page in page_iterator:
        if 'Contents' in page:
            keys.extend(obj['Key'] for obj in page['Contents'])

    return set(keys)  # use set for fast lookup

def s3_file_exists(bucket, key) -> bool:
	# check if a file exists in S3 bucket
	if bucket not in S3_EXISTING_KEYS:
		# fetch all keys in the bucket if not already done
		S3_EXISTING_KEYS[bucket] = s3_list_all_keys(bucket)
	return key in S3_EXISTING_KEYS[bucket]

def md5str(text: str) -> str:
	# returns md5 hash of a string
	return hashlib.md5(text.encode('utf8')).hexdigest().lower()

def getImageExtension(url: str) -> str:
	# returns .ext
	ext = os.path.splitext(url)[1].lower()
	if ext in ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg']:
		return ext
	if ext == '.jpeg':
		return '.jpg'
	if url.endswith(':orig'):
		return getImageExtension(url[:-5]) # remove :orig and try again
	if url.endswith(':large'):
		return getImageExtension(url[:-7])
	if ext == ".jpg_large":
		return '.jpg'
	if "format=jpg" in url:
		return '.jpg'
	if "format=png" in url:
		return '.png'
	if ext == ".jp": # idk wtf this is 
		return '.jpg'
	raise Exception("Unknown image extension in URL: " + url)

def contentTypeOfFile(filepath: str) -> str:
	if filepath.lower().endswith('.jpg') or filepath.lower().endswith('.jpeg'):
		return 'image/jpeg'
	elif filepath.lower().endswith('.png'):
		return 'image/png'
	elif filepath.lower().endswith('.gif'):
		return 'image/gif'
	elif filepath.lower().endswith('.webp'):
		return 'image/webp'
	elif filepath.lower().endswith('.svg'):
		return 'image/svg+xml'
	else:
		raise Exception("Unknown file extension for content type: " + filepath)

def mirrorImage(sourceUrl) -> str:
	ext = getImageExtension(sourceUrl)
	dest_filename = md5str(sourceUrl) + ext
	final_url = f"https://{S3_BUCKET}.s3.{S3_REGION}.amazonaws.com/{dest_filename}"
	if s3_file_exists(S3_BUCKET, dest_filename):
		return final_url
	print("Mirroring image:", sourceUrl, "to", final_url)
	download = requests.get(sourceUrl, stream=True)
	if download.status_code != 200:
		raise Exception("Failed to download image: " + sourceUrl + " --- Status code: " + str(download.status_code))
	# save to S3
	BOTO3_S3_CLIENT.upload_fileobj(
		download.raw,
		S3_BUCKET,
		dest_filename,
		ExtraArgs={
			'ContentType': contentTypeOfFile(dest_filename),
			'ACL': 'public-read' 
		}
	)
	return final_url


def saveHTML(code, filepath) -> bool:
	try:
		soup = BeautifulSoup(code, 'html.parser')
		f = open(filepath, 'w', encoding="utf8")
		f.write(str(soup))
		f.close()
		return os.path.isfile(filepath)
	except Exception as e:
		print ("saveHTML error:", filepath)
		print (e)
		return False

def xml_clean(text) -> str: # https://stackoverflow.com/a/20819845
	return str(''.join(ascii.isprint(c) and c or '' for c in text))

def generateHeader(page_title, css_class):
	output = '<html>'
	output += '<head>'
	output += '<link rel="stylesheet" type="text/css" href="' + CSS_URL + '">'
	output += '<link rel="apple-touch-icon" sizes="180x180" href="' + SITE_ROOT_URL + 'apple-touch-icon.png?v=rMlK32YJeL">'
	output += '<link rel="icon" type="image/png" sizes="32x32" href="' + SITE_ROOT_URL + 'favicon-32x32.png?v=rMlK32YJeL">'
	output += '<link rel="icon" type="image/png" sizes="16x16" href="' + SITE_ROOT_URL + 'favicon-16x16.png?v=rMlK32YJeL">'
	#output += '<link rel="manifest" href="' + SITE_ROOT_URL + 'manifest.json?v=rMlK32YJeL">'
	output += '<link rel="mask-icon" href="' + SITE_ROOT_URL + 'safari-pinned-tab.svg?v=rMlK32YJeL" color="#ff0f00">'
	output += '<link rel="shortcut icon" href="' + SITE_ROOT_URL + 'favicon.ico?v=rMlK32YJeL">'
	#output += '<meta name="msapplication-config" content="' + SITE_ROOT_URL + 'browserconfig.xml?v=rMlK32YJeL">'
	output += '<link rel="alternate" type="application/rss+xml" title="RSS" href="' + SITE_ROOT_URL + 'rss.xml" />'

        # font
	output += '<link rel="preconnect" href="https://fonts.googleapis.com">'
	output += '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
	output += '<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">'
        # end font

	output += '<title>' + page_title.strip() + SITE_TITLE_SUFFIX + '</title>' # strip() to remove newline
	output += '<meta charset="utf-8">'
	output += '<meta name="viewport" content="width=device-width, initial-scale=1">'
	output += '</head>'
	output += '<body>'
	output += '<div class="navigation">'
	output += '<p>'
	output += '<a href="' + SITE_ROOT_URL + '" class="logo">' + SITE_TITLE + '</a>'
	output += '<br>'
	output += '<a href="' + SITE_ROOT_URL + 'archive">Archive</a> • '
	output += '<a href="' + SITE_ROOT_URL + 'stats">Stats</a> • '
	#output += '<a href="' + SITE_ROOT_URL + 'misc">Misc</a> • '
	output += '<a href="' + SITE_ROOT_URL + 'about">About</a> '
	output += '</p>'
	output += '</div>'
	output += '<div class="' + css_class + '">'
	return output

def generateFooter():
	output = '<footer>'
	output += '<a href="mailto:' + AUTHOR_EMAIL + '">' + AUTHOR_EMAIL + '</a><br>'
	#output += 'See the <a href="https://lambdan.se/blog/about">about page</a> for feeds and more ways to contact me<br>'
	output += '©' + str(SITE_STARTED_YEAR) + '-' + str(datetime.now().year) + ' ' + AUTHOR_NAME + '<br>'
	#output += '<br><small>Generated ' + script_run_time.strftime('%Y-%m-%d %H:%M') + ' by <a href="https://github.com/lambdan/lambblog">lambblog</a></small>'
	output += '</footer></body></html>'
	return output

input_files = []
posts = []
processed_posts = 0

print("Searching for posts in", POSTS_DIR, "...")
for dirpath, dirnames, files in os.walk(POSTS_DIR):
	for file in files:
		fullpath = os.path.join(dirpath, file)
		if os.path.splitext(file)[1] in VALID_POST_EXTENSIONS:
			input_files.append(fullpath)
		else:
			print("(Skipping",dirpath,file,"because it doesnt have a supported file extension)")

print("Found", len(input_files), "posts")

print("Processing posts...")
pbar = tqdm(total=len(input_files))
for post in input_files: # post is fullpath to the text file
	if parsed.verbose: print("Processing:", post)

	f = open(post, 'r', encoding="utf8")
	date = date_parser.parse(f.readline().rstrip()) # first line, date
	assert date.tzinfo is not None, "Date must have timezone info"
	date = date.astimezone(TIMEZONE)
	title = f.readline().rstrip() # 2nd line, title
	title = title[2:].rstrip()
	third_line = f.readline() # 3rd line, possibly a link
	body_text = f.read()
	f.close()

	slug_title = slugify(title)
	if parsed.verbose: print('Title:', title)
	if parsed.verbose: print('Slug title:', slug_title)

	# create folder for post
	post_url = str(date.year) + "/" + "%02d" % date.month + "/" +  "%02d" % date.day + "/" + str(slug_title)
	post_root = os.path.join(SITE_ROOT, post_url)
	if not os.path.isdir(post_root): os.makedirs(post_root)
	if parsed.verbose: print('Post root folder:', post_root)

	# copy original text file to post root so it can be viewed by adding .text to post URL
	shutil.copy(post, os.path.join(post_root, '.text'))

	# header
	html_output = generateHeader(title, "article")

	# blog post header
	if third_line.lower().startswith("http"): # detect linked post
		isLinked = third_line.rstrip()
		html_output += '<h1 class="article_title_linked"><a href="' + third_line + '">' + title + '</a></h1>'
	else:
		isLinked = False
		html_output += '<h1 class="article_title">' + title + '</h1>'
	if parsed.verbose: print('Linked post:', isLinked)

	#html_output += '<h2 class="article_date">' + date.strftime('%a %d %b %Y, %H:%M') + '</h2>'
	# show time zone in hover
	html_output += f'<h2 class="article_date" title="{date.tzinfo}"><a href="{post_url}">{date.strftime("%a %d %b %Y, %H:%M")}</a></h2>'

	# body text
	markdown_body = markdown2.markdown(body_text, extras=["strike", "tables"])

	# find images and mirror/thumbnail them
	soup = BeautifulSoup(markdown_body, "html.parser")
	images = soup.find_all('img') # https://stackoverflow.com/a/47166709
	image_urls = []
	if len(images) > 0:
		for image in images:
			imgurl = image['src']
			mirrored = mirrorImage(imgurl)

			# TODO make thumbnail?

			image['src'] = mirrored # TODO replace with thumbnail
			image_urls.append(image['src']) # this will be used for front page
			link_to_fullres = soup.new_tag('a', href=mirrored) # make the thumb clickable to get fullres
			image.wrap(link_to_fullres)

	html_output += str(soup)

	html_output += '</div>'
	# footer
	# previous/next navigation should probably be here?
	html_output += generateFooter()

	stub = markdown2.markdown(body_text, extras=["tables"]).split("\n")[0]

	if saveHTML(html_output, os.path.join(post_root, 'index.html')):
		#print ("success: wrote", title.strip(), "to", post_root)
		posts.append({'title': title.strip(), 'linked': isLinked, 'slug': slugify(title.strip()), 'full_url': SITE_ROOT_URL + post_url, 'textfile': post, 'words': len(body_text.split()), 'chars': len(body_text), 'date': date, 'path': post_url, 'stub': stub, 'body': str(soup), 'images': image_urls})
	else:
		print ("ERROR: writing post html seems to have failed")
		sys.exit(1)

	# write stats page
	html_output = generateHeader(title + ' - Stats', "normal")
	html_output += '<h1>Stats for <u><a href="' + SITE_ROOT_URL + post_url + '">' + title + '</a></u></h1>'
	html_output += '<p>'
	html_output += str(len(body_text.split())) + ' words 📝<br>'
	html_output += str(len(body_text)) + ' characters 🖊️<br>'
	html_output += str(len(image_urls)) + ' images 🖼️<br>'
	html_output += '</p>' # how many images
	# filter out so we only get whitelisted characters (STATS_WHITELISTED_CHARACTERS) to avoid counting symbols and dashes etc.
	stats_body_text = ''.join(filter(STATS_WHITELISTED_CHARACTERS.__contains__,body_text)) # https://stackoverflow.com/a/21564666
	count = Counter(stats_body_text.lower().split()) # also make it lowercase so for example "The" and "the" aren't separated

	html_output += '<h2>Words Used More Than Once:</h2>'
	html_output += '<p>' #               10
	for word, value in count.most_common(len(count)): # i tried listing all words but it stops working properly for some reason, around 2080 words
		if value > 1:
			html_output += '"' + str(word) + '" is used <i>' + str(value) + ' times</i><br>'
	html_output += '</p>'

	html_output += '</div>'
	html_output += generateFooter()
	if not saveHTML(html_output, os.path.join(post_root, 'stats.html')):
		print ("ERROR: saving stats page failed", post_root)
		sys.exit(1)

	processed_posts += 1
	posts_left = len(input_files) - processed_posts
	if parsed.verbose: print("OK,", posts_left, "left...\n")
	pbar.update(1)

pbar.close()

####################################

if len(input_files) == processed_posts:
	print ("Success! Made", processed_posts, "posts from", len(input_files), "input files")
else:
	print ("ERROR: not every post seems to have been processed")
	print ("Expected posts:", len(input_files))
	print ("Processed posts:", processed_posts)
	print ("Exiting...")
	sys.exit(1)

newlist = sorted(posts, key=lambda k: k['date'], reverse=True) # sort by dates, reverse to get newest on top
posts = newlist # extremely ugly code but whatever

print ("Generating main RSS feed...")
# First generate RSS feed where linked posts links back to our site
rss_items = [] # First generate the posts RSS items...
for p in posts[:20]: # only use 20 newest posts
	item = PyRSS2Gen.RSSItem(
		title = xml_clean(p['title']),
		link = p['full_url'],
		description = xml_clean(p['body']),
		pubDate = p['date']
		)
	rss_items.append(item)

rss = PyRSS2Gen.RSS2( # ...then create the main RSS feed and include those items
	title = SITE_TITLE,
	link = SITE_ROOT_URL,
	description = SITE_TITLE + ' RSS feed',
	lastBuildDate = script_run_time,
	items = rss_items)

rss.write_xml(open(os.path.join(SITE_ROOT,'rss.xml'), 'w'))

print ("Generating alternate RSS feed...")
# Generate RSS feed where linked posts links to their links
rss_items = [] # First generate the posts RSS items...
for p in posts[:20]: # only use 20 newest posts
	if p['linked']:
		linkURL = p['linked']
	else:
		linkURL = p['full_url']
	item = PyRSS2Gen.RSSItem(
		title = xml_clean(p['title']),
		link = linkURL,
		description = xml_clean(p['body']),
		pubDate = p['date']
		)
	rss_items.append(item)

rss = PyRSS2Gen.RSS2( # ...then create the main RSS feed and include those items
	title = SITE_TITLE + ' (Alternate)',
	link = SITE_ROOT_URL,
	description = SITE_TITLE + ' Alternate RSS feed (linked posts link to their targets)',
	lastBuildDate = script_run_time,
	items = rss_items)

rss.write_xml(open(os.path.join(SITE_ROOT,'rss_follow_links.xml'), 'w'))

print ("Generating RSS feed without linked posts...")
rss_items = [] # First generate the posts RSS items...
for p in posts[:20]: # only use 20 newest posts
	if p['linked']:
		continue
	item = PyRSS2Gen.RSSItem(
		title = xml_clean(p['title']),
		link = p['full_url'],
		description = xml_clean(p['body']),
		pubDate = p['date']
		)
	rss_items.append(item)

rss = PyRSS2Gen.RSS2( # ...then create the main RSS feed and include those items
	title = SITE_TITLE + ' (Originals)',
	link = SITE_ROOT_URL,
	description = SITE_TITLE + ' Originals RSS feed (linked posts not included)',
	lastBuildDate = script_run_time,
	items = rss_items)

rss.write_xml(open(os.path.join(SITE_ROOT,'rss_originals.xml'), 'w'))


print ("Writing front page...")
html_output = generateHeader("Blog", "normal")
for p in posts[:10]:
	if p['linked']: # linked post? is either False or an URL
		html_output += '<h1 class="article_title_linked"><a href="' + p['linked'] + '">' + p['title'] + '</a></h1>'
	else:
		html_output += '<h1 class="article_title"><a href="' + p['full_url'] + '">' + p['title'] + '</a></h1>'

	html_output += '<h2 class="article_date"><a href="' + p['full_url'] + '">' + p['date'].strftime('%a %d %b %Y, %H:%M') + '</a></h2>'

	html_output += p['stub']

	if len(p['images']) > 0: # add first image from post, clicking it links to article
		html_output += '<a href="' + p['full_url'] + '">'
		html_output += '<img src="' + p['images'][0] + '">' # 0 to get first image (the top one)
		html_output += '</a>'

	html_output += '<br><br>'


html_output += '</div>'

html_output += '<div class="article"><center><p>Go to the <a href="archive">archive</a> to see all posts</p></center></div>' # add article div to get colored link

html_output += generateFooter()
if not saveHTML(html_output, os.path.join(SITE_ROOT, 'index.html')):
	print ("error saving front page")

print ("Writing archive...")
html_output = generateHeader("Blog Archive", "normal")
#html_output += '<p>Hint: use your web browsers\' search function to find what you\'re looking for.</p>'
yr = 0
mo = 0
for p in posts:
	if yr != p['date'].year:
		html_output += '<h1 class="article_title"><u><a href="' + str(p['date'].year) +'">' + str(p['date'].year) + '</a></u></h1>'
		yr = p['date'].year
	if mo != p['date'].month:
		html_output += '<h2><a href="' + str(p['date'].year) + '/' + "%02d" % p['date'].month +'">' + p['date'].strftime('%B') + '</a></h2>'
		mo = p['date'].month
	html_output += '<li><a href="' + p['path'] + '">' + p['title'] + '</a></li>'
html_output += "</div>"
html_output += generateFooter()
saveHTML(html_output, os.path.join(SITE_ROOT, 'archive.html'))

print ("Making indexes for every year...")
years = []
mo = 0
for p in posts:
	y = p['date'].year
	years.append(y)
for yr in years:
	html_output = generateHeader(str(yr), "normal")
	html_output += '<h1 class="article_title">' + str(yr) + '</h1>'
	for p in posts:
		y = p['date'].year
		if y == yr:
			if mo != p['date'].month:
				html_output += '<h2><a href="' + "%02d" % p['date'].month +'">' + p['date'].strftime('%B') + '</a></h2>'
				mo = p['date'].month
			url = "%02d" % p['date'].month + '/' + "%02d" % p['date'].day + '/' + p['slug']
			html_output += '<li><a href="' + url + '">'
			html_output += p['title']
			html_output += '</a></li>'
	html_output += '</div>'
	html_output += generateFooter()
	saveHTML(html_output, os.path.join(SITE_ROOT, str(yr), 'index.html'))

print ("Making indexes for every month...")
months = []
for p in posts:
	y = p['date'].year
	m = p['date'].month
	months.append(str(y) + '-' + "%02d" % m) # ex 2019-04
for month in months:
	print_month = datetime.strptime(month, '%Y-%m').strftime('%B %Y') # ex April 2019
	html_output = generateHeader(print_month, 'normal')
	html_output += '<h1>' + print_month + '</h1>'
	html_output += '<ul>'
	for p in posts:
		y = str(p['date'].year)
		m = str("%02d" % p['date'].month)
		if y == month.split('-')[0] and m == month.split('-')[1]:
			#print y, m, p['title']
			url = "%02d" % p['date'].day + '/' + p['slug']
			html_output += '<li><a href="' + url + '">'
			html_output += p['title']
			html_output += '</a></li>'
	html_output += '</ul></div>'
	html_output += generateFooter()
	saveHTML(html_output, os.path.join(SITE_ROOT, month.split('-')[0], month.split('-')[1], 'index.html'))

print ("Making indexes for every day...") # for those url modifying geeks
days = []
for p in posts:
	y = p['date'].year
	m = p['date'].month
	d = p['date'].day
	days.append(str(y) + '-' + "%02d" % m + '-' + "%02d" % d) # ex 2019-04-20
for day in days:
	print_day = datetime.strptime(day, '%Y-%m-%d').strftime('%d %B %Y') # 20 April 2019
	html_output = generateHeader(print_day, 'normal')
	html_output += '<h1>' + print_day + '</h1>'
	html_output += '<ul>'
	for p in posts:
		y = str(p['date'].year)
		m = str("%02d" % p['date'].month)
		d = str("%02d" % p['date'].day)
		if y == day.split('-')[0] and m == day.split('-')[1] and d == day.split('-')[2]:
			url = p['slug']
			html_output += '<li><a href="' + url + '">'
			html_output += p['title']
			html_output += '</a></li>'
	html_output += '</ul></div>'
	html_output += generateFooter()
	saveHTML(html_output, os.path.join(SITE_ROOT, day.split('-')[0], day.split('-')[1], day.split('-')[2], 'index.html'))

print ("Creating other pages:")
pages = os.listdir(OTHER_PAGES_FOLDER)
for page in pages:
	if not page.lower().endswith('html'):
		if parsed.verbose: print ("(ignoring",page,"because its not a html file)")
		continue
	path = os.path.join(OTHER_PAGES_FOLDER, page)
	f = open(path,'r')
	title = f.readline() # title is the first line
	html_output = generateHeader(title, "article")
	html_output += f.read() # ... then read the rest of the file
	f.close()
	html_output += '</div>'
	html_output += generateFooter()

	if saveHTML(html_output, os.path.join(SITE_ROOT, page)):
		print ("\t", page)
	else:
		print ("\t", page, "= failed")
		sys.exit(1)

print ("Creating stats page...")
total_words = 0
total_chars = 0
total_images = 0
for p in posts:
	total_words += p['words']
	total_chars += p['chars']
	total_images += len(p['images'])
total_posts = len(posts)

# hide some useful debug info in the html as a comment
html_output = '<!---'
html_output += 'lambblog super hidden secret debug info: '
html_output += 'Generated ' + script_run_time.strftime('%Y-%m-%d %H:%M') + ", python sys.version: "
html_output += sys.version
html_output += '--->'
# and then make the actual stats page
html_output += generateHeader('Stats', 'normal')
html_output += '<h1>Stats 💯</h1>'
html_output += '<ul>'
html_output += '<li>📜 ' + str(total_posts) + ' posts</li>'
html_output += '<li>📝 ' + str(total_words) + ' words</li>'
html_output += '<li>🖊️ ' + str(total_chars) + ' characters</li>'
html_output += '<li>🖼️ ' + str(total_images) + ' images</li>'
html_output += '</ul>'

html_output += '<h2>Posts With Most Words 📝</h2>'
html_output += '<ol>'
posts_sorted_by_words = sorted(posts, key=lambda k: k['words'], reverse=True) # sort by dates, reverse to get most on top
for p in posts_sorted_by_words:
	html_output += '<li><a href="' + p['path'] + '">' + p['title'] + '</a> — <a href="' + p['path'] + '/stats' + '">' + str(p['words']) + ' words</a></li>'
html_output += '</ol>'

html_output += '<h2>Posts With Most Images 🖼️</h2>'
html_output += '<ol>'
posts_sorted_by_images = sorted(posts, key=lambda k: len(k['images']), reverse=True)
for p in posts_sorted_by_images:
	if len(p['images']) > 0:
		html_output += '<li><a href="' + p['path'] + '">' + p['title'] + '</a> — <a href="' + p['path'] + '/stats' + '">' + str(len(p['images']))
		if len(p['images']) == 1:
			html_output += ' image'
		else:
			html_output += ' images'
		html_output += '</a></li>'

html_output += '</ol>'

html_output += '</div>'

html_output += generateFooter()
if not saveHTML(html_output, os.path.join(SITE_ROOT, 'stats.html')):
	print ("ERROR: saving stats page failed")
	sys.exit(1)

print ("Copying files from the include folder to the site root...")
files = os.listdir(INCLUDE_FOLDER)
for f in files:
	src = os.path.join(INCLUDE_FOLDER, f)
	dest = os.path.join(SITE_ROOT, f)
	if parsed.verbose: print("\t", src, "-->", dest)
	shutil.copy(src, dest)

print()
print ("All done!")
print ("Find your website in", os.path.abspath(SITE_ROOT))
