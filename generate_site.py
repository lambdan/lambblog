#!/usr/bin/env python
# -*- coding: utf-8 -*- 
import markdown2
from bs4 import BeautifulSoup
from slugify import slugify
from dateutil.parser import parse
import os, shutil, sys, hashlib, time, requests, re
from datetime import datetime
from PIL import Image
from email import utils
from curses import ascii
from collections import Counter
from argparse import ArgumentParser
from tqdm import tqdm
import PyRSS2Gen

script_run_time = datetime.now()

########################### Settings ################################
SITE_TITLE = 'lambdan.se'
SITE_TITLE_SUFFIX = ' - ' + SITE_TITLE # at the end of every <title>

CSS_FILE = 'css-night-2018.css' # should be in the root of ./includes/

AUTHOR_NAME = 'djs'
AUTHOR_EMAIL = 'david@lambdan.se' # these are in the footer
AUTHOR_TWITTER = 'nadbmal' # no @
SITE_STARTED_YEAR = 2012 # used for (c) in the footer

IMAGE_SIZE_THRESHOLD = 300000 # (bytes) images smaller than this won't get a thumbnail
THUMBNAIL_MAX_RESOLUTION = 1000,1000 # max resolution for thumbnails in each axis (aspect ratio is preserved)

POSTS_DIR = './posts/'
IMAGES_FOLDER = './images/'
INCLUDE_FOLDER = './includes/'
OTHER_PAGES_FOLDER = './pages/'
VALID_POST_EXTENSIONS = ('txt', 'md', 'markdown')

STATS_WHITELISTED_CHARACTERS = set('abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ åäö ÅÄÖ')
#####################################################################

# handle arguments
parser = ArgumentParser()
parser.add_argument("--root-folder", action='store', dest='folder', help='root folder of website, default = ./_output/')
parser.add_argument("--root-url", action='store', dest='url', help='root url of website', required=True)
parsed = parser.parse_args()

if not parsed.folder:
	SITE_ROOT = './_output/'
else:
	SITE_ROOT = parsed.folder

SITE_ROOT_URL = parsed.url
# TODO: make sure they are valid
print ("Output folder:", SITE_ROOT)
print ("URL Root:", SITE_ROOT_URL)
yn = input("Continue? y/N ").lower()
if yn != "y":
	print ("exiting...")
	sys.exit(1)

CSS_URL = SITE_ROOT_URL + CSS_FILE

def saveHTML(code, filepath):
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

def xml_clean(text): # https://stackoverflow.com/a/20819845
	return str(''.join(ascii.isprint(c) and c or '' for c in text)) 

def generateHeader(page_title, css_class):
	output = '<html>'
	output += '<head>'
	output += '<link rel="apple-touch-icon" sizes="180x180" href="' + SITE_ROOT_URL + 'apple-touch-icon.png?v=rMlK32YJeL">'
	output += '<link rel="icon" type="image/png" sizes="32x32" href="' + SITE_ROOT_URL + 'favicon-32x32.png?v=rMlK32YJeL">'
	output += '<link rel="icon" type="image/png" sizes="16x16" href="' + SITE_ROOT_URL + 'favicon-16x16.png?v=rMlK32YJeL">'
	#output += '<link rel="manifest" href="' + SITE_ROOT_URL + 'manifest.json?v=rMlK32YJeL">'
	output += '<link rel="mask-icon" href="' + SITE_ROOT_URL + 'safari-pinned-tab.svg?v=rMlK32YJeL" color="#ff0f00">'
	output += '<link rel="shortcut icon" href="' + SITE_ROOT_URL + 'favicon.ico?v=rMlK32YJeL">'
	#output += '<meta name="msapplication-config" content="' + SITE_ROOT_URL + 'browserconfig.xml?v=rMlK32YJeL">'
	output += '<meta name="theme-color" content="#ffffff">'
	output += '<link rel="alternate" type="application/rss+xml" title="RSS" href="' + SITE_ROOT_URL + 'rss.xml" />'
	output += '<title>' + page_title.strip() + SITE_TITLE_SUFFIX + '</title>' # strip() to remove newline
	output += '<meta charset="utf-8">'
	output += '<meta name="viewport" content="width=device-width, initial-scale=1">'
	output += '<link rel="stylesheet" type="text/css" href="' + CSS_URL + '">'
	output += '</head>'
	output += '<body>'
	output += '<div class="navigation">'
	output += '<p>'
	output += '<a href="' + SITE_ROOT_URL + '" class="logo">' + SITE_TITLE + '</a>'
	output += '<br>'
	output += '<a href="' + SITE_ROOT_URL + 'archive">Archive</a> • '
	output += '<a href="' + SITE_ROOT_URL + 'stats">Stats</a> • '
	output += '<a href="' + SITE_ROOT_URL + 'misc">Misc</a> • '
	output += '<a href="' + SITE_ROOT_URL + 'about">About</a> '
	output += '</p>'
	output += '</div>'
	output += '<div class="' + css_class + '">'
	return output

def generateFooter():
	output = '<footer>'
	output += '<a href="mailto:' + AUTHOR_EMAIL + '">' + AUTHOR_EMAIL + '</a><br>'
	output += 'See the <a href="https://lambdan.se/blog/about">about page</a> for other ways to contact me<br>'
	output += '©' + str(SITE_STARTED_YEAR) + '-' + str(datetime.now().year) + ' ' + AUTHOR_NAME + '<br>'
	#output += '<br><small>Generated ' + script_run_time.strftime('%Y-%m-%d %H:%M') + ' by <a href="https://github.com/lambdan/lambblog">lambblog</a></small>'
	output += '</footer></body></html>'
	return output

if os.path.isdir(SITE_ROOT):
	shutil.rmtree(SITE_ROOT)
	os.makedirs(SITE_ROOT)
elif not os.path.isdir(SITE_ROOT):
	os.makedirs(SITE_ROOT)

if not os.path.isdir(IMAGES_FOLDER):
	os.makedirs(IMAGES_FOLDER)

posts = []
processed_posts = 0
pbar = tqdm(total=len(os.listdir(POSTS_DIR))) # start progress bar

for post in os.listdir(POSTS_DIR):
	if not post.lower().endswith(VALID_POST_EXTENSIONS):
		print ("(ignoring",post,"because it doesnt have any of these extensions:",VALID_POST_EXTENSIONS,")")
		pbar.update(1)
		continue

	f = open(os.path.join(POSTS_DIR, post), 'r', encoding="utf8")
	try:
		date = parse(f.readline(), fuzzy=True) # 1st line, date
	except Exception as e:
		print ("error parsing date, you probably forgot to put a date at the very top of the file:", post)
		print (e)
		print ("exiting...")
		sys.exit(1)
	title = f.readline() # 2nd line, title
	title = title[2:]
	#print ("> " + title.strip() + " [" + post + "]")
	third_line = f.readline() # 3rd line, possibly a link
	body_text = f.read()
	f.close()

	slug_title = slugify(title)

	# create folder for post
	post_url = str(date.year) + "/" + "%02d" % date.month + "/" +  "%02d" % date.day + "/" + str(slug_title)
	post_root = os.path.join(SITE_ROOT, post_url)
	os.makedirs(post_root)

	# header
	html_output = generateHeader(title, "article")

	# blog post header
	if third_line.lower().startswith("http"): # detect linked post
		isLinked = third_line
		html_output += '<h1 class="article_title_linked"><a href="' + third_line + '">' + title + '</a></h1>'
	else:
		isLinked = False
		html_output += '<h1 class="article_title">' + title + '</h1>'

	html_output += '<h2 class="article_date">' + date.strftime('%a %d %b %Y, %H:%M') + '</h2>'

	# body text 
	markdown_body = markdown2.markdown(body_text, extras=["strike", "tables"])

	# find images and mirror/thumbnail them
	soup = BeautifulSoup(markdown_body, "html.parser")
	images = soup.find_all('img') # https://stackoverflow.com/a/47166709
	if len(images) > 0:
		for image in images:
			imgurl = image['src']
			ext = os.path.splitext(imgurl)[1].lower()

			# remove twitters weird :orig :large extensions
			if 'jpeg:' in ext or 'jpg:' in ext:
				ext = ".jpg"
				#print ('correcting extension of', imgurl, 'to', ext)
			elif 'png:' in ext:
				ext = ".png"
				#print ('correcting extension of', imgurl, 'to', ext)
			
			# cursed old puush images
			if ext == '':
				#print (imgurl + " has no extension. assuming jpg")
				ext = ".jpg"

			# add a dot in case the extension doesnt come with one
			if '.' not in ext:
				ext = "." + ext

			md5 = hashlib.md5(imgurl.encode("utf8")).hexdigest().lower()
			mirror_img_filename = md5 + ext
			mirror_img_filepath = os.path.join(IMAGES_FOLDER, mirror_img_filename)
			if os.path.isfile(mirror_img_filepath):
				#print mirror_img_filename, "already exists :)"
				destination = os.path.join(post_root, mirror_img_filename)
				shutil.copy(mirror_img_filepath, destination)
			else:
				print ("\tnot mirrored:", imgurl)
				print ("\tattempting download", imgurl, " --> ", mirror_img_filename)
				f = open(mirror_img_filepath, 'wb')
				f.write(requests.get(imgurl).content)
				f.close()
				#f = open(mirror_img_filepath, 'r') 
				#if "puush could not be found" in f.read().lower(): # this is broken with python3
				#	print ("error: image download failed: puush could not be found")
				#	f.close()
				#	os.remove(mirror_img_filepath)

				if not os.path.isfile(mirror_img_filepath):
					print ("\terror: downloading image seems to have failed")
				else:
					print ("\tsuccess downloading image", mirror_img_filepath)
					destination = os.path.join(post_root, mirror_img_filename)
					shutil.copy(mirror_img_filepath, destination)

			mirror_img_size = os.path.getsize(mirror_img_filepath)
			mirror_img_filename_thumb = md5 + ".thumb.jpg"
			mirror_img_filepath_thumb = os.path.join(IMAGES_FOLDER, mirror_img_filename_thumb)

			if ext == ".gif":
				#print ('skipping thumbnail for gif:', imgurl)
				if os.path.isfile(mirror_img_filepath_thumb):
					print ('\tdeleting old thumbnail because its not needed anymore:', mirror_img_filepath_thumb)
					os.remove(mirror_img_filepath_thumb)
				image['src'] = mirror_img_filename

			elif mirror_img_size < IMAGE_SIZE_THRESHOLD:
				#print ('skipping thumbnail because original is small enough:', imgurl, mirror_img_size)
				if os.path.isfile(mirror_img_filepath_thumb):
					print ('\tdeleting old thumbnail because its not needed anymore:', mirror_img_filepath_thumb)
					os.remove(mirror_img_filepath_thumb)
				image['src'] = mirror_img_filename

			else:
				if os.path.isfile(mirror_img_filepath):
					thumb_destination = os.path.join(post_root, mirror_img_filename_thumb)
					#print ("\tgenerating thumbnail to " + thumb_destination)
					im = Image.open(mirror_img_filepath)
					if not im.mode == 'RGB':
						im = im.convert('RGB')
					im.thumbnail((THUMBNAIL_MAX_RESOLUTION))
					im.save(thumb_destination, "JPEG")
					if not os.path.isfile(thumb_destination):
						print ("\terror: creating thumbnail seems to have failed")
					else:
						#print ("\tok. original size:", mirror_img_size, ", thumb:", os.path.getsize(thumb_destination))
						image['src'] = mirror_img_filename_thumb
				else:
					print ("\toriginal file hasnt been downloaded so i cant create a thumbnail")

			image['src'] = SITE_ROOT_URL + post_url + '/' + image['src'] # disgusting hack for getting full urls in RSS
			link_to_fullres = soup.new_tag('a', href=SITE_ROOT_URL + post_url + '/' + mirror_img_filename) # make the thumb clickable to get fullres
			image.wrap(link_to_fullres)

	html_output += str(soup)

	html_output += '</div>'
	# footer
	# previous/next navigation should probably be here?
	html_output += generateFooter()

	stub = markdown2.markdown(body_text, extras=["tables"]).split("\n")[0]

	if saveHTML(html_output, os.path.join(post_root, 'index.html')):
		#print ("success: wrote", title.strip(), "to", post_root)
		posts.append({'title': title.strip(), 'linked': isLinked, 'slug': slugify(title.strip()), 'full_url': SITE_ROOT_URL + post_url, 'textfile': post, 'words': len(body_text.split()), 'chars': len(body_text), 'date': date, 'path': post_url, 'stub': stub, 'body': str(soup)})
	else:
		print ("\tcritical: writing post html seems to have failed")
		sys.exit(1)

	# write stats page
	html_output = generateHeader(title + ' - Stats', "normal")
	html_output += '<h1>Stats: <u>' + title + '</u></h1>'
	html_output += '<p>' + str(len(body_text.split())) + ' words, ' + str(len(body_text)) + ' characters.</p>'
	# filter out so we only get whitelisted characters (STATS_WHITELISTED_CHARACTERS) to avoid counting symbols and dashes etc.
	stats_body_text = ''.join(filter(STATS_WHITELISTED_CHARACTERS.__contains__,body_text)) # https://stackoverflow.com/a/21564666
	count = Counter(stats_body_text.lower().split()) # also make it lowercase so for example "The" and "the" aren't separated
	html_output += '<ol>'
	for word, value in count.most_common(10): # i tried listing all words but it stops working properly for some reason, around 2080 words
		html_output += '<li><b>' + str(word) + '</b> - ' + str(value) + ' occurences</li>'
	html_output += '</ol>'
	html_output += '</div>'
	html_output += generateFooter()
	if not saveHTML(html_output, os.path.join(post_root, 'stats.html')):
		print ("\tfailed saving stats page")
		sys.exit(1)
	processed_posts += 1
	pbar.update(1)

pbar.close()

if len(posts) == processed_posts:
	print ("success: wrote", len(posts), "html files from", processed_posts, "processed files")
else:
	print ("critical: not every post in", POSTS_DIR, "seems to have gotten a html file")
	print ("debug:", len(posts), "/", processed_posts)
	sys.exit(1)

newlist = sorted(posts, key=lambda k: k['date'], reverse=True) # sort by dates, reverse to get newest on top
posts = newlist # extremely ugly code but whatever

print ("generating rss feed")
rss_items = [] # First generate the posts RSS items...
for p in posts:
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
	description = SITE_TITLE + ' RSS feed.',
	lastBuildDate = script_run_time,
	items = rss_items)

rss.write_xml(open(os.path.join(SITE_ROOT,'rss.xml'), 'w'))


print ("writing front page")
html_output = generateHeader("Blog", "normal")
for p in posts[:10]:
	if p['linked']: # linked post? is either False or an URL
		html_output += '<h1 class="article_title_linked"><a href="' + p['linked'] + '">' + p['title'] + '</a></h1>'
	else:
		html_output += '<h1 class="article_title"><a href="' + p['full_url'] + '">' + p['title'] + '</a></h1>'
	html_output += '<h2 class="article_date"><a href="' + p['full_url'] + '">' + p['date'].strftime('%a %d %b %Y, %H:%M') + '</a></h2>'
	html_output += p['stub']

html_output += '</div>'
html_output += generateFooter()
if not saveHTML(html_output, os.path.join(SITE_ROOT, 'index.html')):
	print ("error")

print ("writing archive")
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

print ("writing year indexes")
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

print ("writing month indexes")
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

print ("writing day indexes") # for those url modifying geeks
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

print ("creating other pages:")
pages = os.listdir(OTHER_PAGES_FOLDER)
for page in pages:
	if not page.lower().endswith('html'):
		print ("(ignoring",page,"because its not a html file)")
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

print ("creating stats page")
total_words = 0
total_chars = 0
for p in posts:
	total_words += p['words']
	total_chars += p['chars']
total_posts = len(posts)

# hide some useful debug info in the html as a comment
html_output = '<!---'
html_output += 'lambblog super hidden secret debug info: '
html_output += 'Generated ' + script_run_time.strftime('%Y-%m-%d %H:%M') + ", python sys.version: "
html_output += sys.version
html_output += '--->'
# and then make the actual stats page
html_output += generateHeader('Stats', 'normal')
html_output += '<h1>Stats</h1>'
html_output += '<ul>'
html_output += '<li>' + str(total_posts) + ' posts</li>'
html_output += '<li>' + str(total_words) + ' words</li>'
html_output += '<li>' + str(total_chars) + ' characters</li>'
html_output += '</ul>'

html_output += '<h2>Posts With Most Words</h2>'
html_output += '<ol>'
posts_sorted_by_words = sorted(posts, key=lambda k: k['words'], reverse=True) # sort by dates, reverse to get most on top
for p in posts_sorted_by_words:
	html_output += '<li><a href="' + p['path'] + '">' + p['title'] + '</a> <a href="' + p['path'] + '/stats' + '">(' + str(p['words']) + ' words)</a></li>'
html_output += '</ol>'

html_output += '</div>'

html_output += generateFooter()
if not saveHTML(html_output, os.path.join(SITE_ROOT, 'stats.html')):
	print ("failed!")
	sys.exit(1)

print ("copying from " + INCLUDE_FOLDER + " to site root:",)
files = os.listdir(INCLUDE_FOLDER)
for f in files:
	src = os.path.join(INCLUDE_FOLDER, f)
	dest = os.path.join(SITE_ROOT, f)
	print("\t", src, "-->", dest)
	shutil.copy(src, dest)

print ("all done!")