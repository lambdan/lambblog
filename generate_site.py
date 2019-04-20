#!/usr/bin/env python
# -*- coding: utf-8 -*- 

import markdown2
from bs4 import BeautifulSoup
from slugify import slugify
from dateutil.parser import parse
import os, shutil, sys, hashlib, time, requests
from datetime import datetime
from PIL import Image

reload(sys)
sys.setdefaultencoding('UTF8')

SITE_ROOT = '/home/djs/public_html/static/'
SITE_ROOT_URL = 'https://lambdan.se/static/'

POSTS_DIR = './posts/'
IMAGES_FOLDER = './images/'
INCLUDE_FOLDER = './includes/'
OTHER_PAGES_FOLDER = './pages/'

SITE_TITLE_SUFFIX = ' - lambdan.se'
CSS_URL = SITE_ROOT_URL + 'css-night-2018.css'



#html = markdown2.markdown_path('./posts/113.txt')
#print html

def saveHTML(code, filepath):
	soup = BeautifulSoup(code, 'html.parser')
	f = open(filepath, 'w')
	f.write(soup.prettify())
	f.close()
	return os.path.isfile(filepath)


def generateHeader(page_title, css_class):
	output = '<html>'
	output += '<head>'
	output += '<title>' + page_title.strip() + SITE_TITLE_SUFFIX + '</title>' # strip() to remove newline
	output += '<meta charset="utf-8">'
	output += '<meta name="viewport" content="width=device-width, initial-scale=1">'
	output += '<link rel="stylesheet" type="text/css" href="' + CSS_URL + '">'
	output += '</head>'
	output += '<body>'
	output += '<div class="navigation">'
	output += '<p>'
	output += '<a href="' + SITE_ROOT_URL + '" class="logo">lambdan.se (STATIC BETA VERSION)</a>'
	output += '<br>'
	#output += '<a href="archive">Archive</a> • '
	#output += '<a href="stats">Stats</a> • '
	output += '<a href="misc">Misc</a> •'
	output += '<a href="about">About</a> '
	output += '</p>'
	output += '</div>'
	output += '<div class="' + css_class + '">'
	return output

if os.path.isdir(SITE_ROOT):
	shutil.rmtree(SITE_ROOT)
	os.makedirs(SITE_ROOT)
elif not os.path.isdir(SITE_ROOT):
	os.makedirs(SITE_ROOT)

posts = []

for post in os.listdir(POSTS_DIR):
	f = open(os.path.join(POSTS_DIR, post), 'r')
	date = parse(f.readline(), fuzzy=True) # 1st line, date
	title = f.readline() # 2nd line, title
	title = title[2:]
	#print "processing", title
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
	if third_line.lower().startswith("http"): # linked post?
		html_output += '<h1 class="article_title_linked"><a href="' + third_line + '">' + title + '</a></h1>'
	else:
		html_output += '<h1 class="article_title">' + title + '</h1>'

	html_output += '<h2 class="article_date">' + str(date) + '</h2>'

	# body text 
	markdown_body = markdown2.markdown(body_text, extras=["tables"])

	# find images and mirror/thumbnail them
	soup = BeautifulSoup(markdown_body, "html.parser")
	images = soup.find_all('img') # https://stackoverflow.com/a/47166709
	if len(images) > 0:
		for image in images:
			imgurl = image['src']
			ext = os.path.splitext(imgurl)[1].lower()

			if 'jpeg' in ext or 'jpg' in ext: # to remove twitter weird .jpeg:large extensions etc
				ext = ".jpg"
			elif 'png' in ext:
				ext = ".png"
			elif ext == '':
				print "warning:", imgurl, "in blog post", title.strip(), ": has no extension. assuming .jpg"
				ext = ".jpg"

			md5 = hashlib.md5(imgurl).hexdigest().lower()
			mirror_img_filename = md5 + ext
			mirror_img_filepath = os.path.join(IMAGES_FOLDER, mirror_img_filename)
			if os.path.isfile(mirror_img_filepath):
				#print mirror_img_filename, "already exists :)"
				destination = os.path.join(post_root, mirror_img_filename)
				shutil.copy(mirror_img_filepath, destination)
			else:
				print "image: not mirrored:", imgurl, mirror_img_filename
				print "image: attempting download", imgurl, " --> ", mirror_img_filename
				f = open(mirror_img_filepath, 'wb')
				f.write(requests.get(imgurl).content)
				f.close()
				f = open(mirror_img_filepath, 'r')
				if "puush could not be found" in f.read().lower():
					print "error: image download failed: puush could not be found"
					f.close()
					os.remove(mirror_img_filepath)

				if not os.path.isfile(mirror_img_filepath):
					print "error: downloading image seems to have failed"
					print "debug: blog post is", title
				else:
					print "image: success downloading image", mirror_img_filepath, os.path.getsize(mirror_img_filepath)
					destination = os.path.join(post_root, mirror_img_filename)
					shutil.copy(mirror_img_filepath, destination)

			mirror_img_filename_thumb = md5 + "_thumb.jpg"
			mirror_img_filepath_thumb = os.path.join(IMAGES_FOLDER, mirror_img_filename_thumb)
			if os.path.isfile(mirror_img_filepath_thumb):
				#print "thumb for", mirror_img_filename, "exists :)"
				destination = os.path.join(post_root, mirror_img_filename_thumb)
				shutil.copy(mirror_img_filepath_thumb, destination)
			else:
				print "image: no thumbnail:", imgurl, mirror_img_filename_thumb
				if os.path.isfile(mirror_img_filepath):
					print "image: generating thumbnail"
					im = Image.open(mirror_img_filepath)
					if not im.mode == 'RGB':
						im = im.convert('RGB')
					im.save(mirror_img_filepath_thumb, quality=75)
					if not os.path.isfile(mirror_img_filepath_thumb):
						print "error: creating thumbnail seems to have failed"
						print "debug: blog post is", title
					else:
						print "success: created thumbnail", mirror_img_filename_thumb, os.path.getsize(mirror_img_filepath_thumb)
						destination = os.path.join(post_root, mirror_img_filename_thumb)
						shutil.copy(mirror_img_filepath_thumb, destination)
				else:
					print "image: original file hasnt been downloaded so i cant create a thumbnail"
					print "debug: blog post is", title


			image['src'] = mirror_img_filename_thumb # inline image is the thumb
			link_to_fullres = soup.new_tag('a', href=mirror_img_filename) # make the thumb clickable to get fullres
			image.wrap(link_to_fullres)

	html_output += str(soup)

	html_output += '</div>'
	# footer
	html_output += '</body>'
	html_output += '</html>'

	stub = markdown2.markdown(body_text, extras=["tables"]).split("\n")[0].encode("utf-8")

	if saveHTML(html_output, os.path.join(post_root, 'index.html')):
		#print "success: wrote", title.strip(), "to", html_file
		posts.append({'title': title.strip(), 'date': date, 'path': post_url, 'stub': stub})
	else:
		print "critical: writing post html seems to have failed"
		print "debug: blog post is", title.strip()
		sys.exit(1)

if len(posts) == len(os.listdir(POSTS_DIR)):
	print "success: wrote", len(posts), "html files from", len(os.listdir(POSTS_DIR)), "post files"
else:
	print "critical: not every post in", POSTS_DIR, "seems to have gotten a html file"
	print "debug:", len(posts), "/", len(os.listdir(POSTS_DIR))
	sys.exit(1)

#print posts

newlist = sorted(posts, key=lambda k: k['date'], reverse=True) # sort by dates, reverse to get newest on top
posts = newlist # extremely ugly code but whatever

print "writing archive..."
html_output = generateHeader("Home", "normal")
for p in posts:
	html_output += '<li><a href="' + p['path'] + '">' + p['title'] + '</a></li>'
html_output += '</html>'

saveHTML(html_output, os.path.join(SITE_ROOT, 'index.html'))

#print "writing year index..."
#years = []
#for post in post_paths: # get years
#	y = post.split('/')[0]
#	years.append(y)
#for year in years: # process years, this is inefficient
#	html_output = generateHeader(year, "normal")
#	html_output += "<h1>" + year + "</h1>"
#	for post in post_paths:
#		y = post.split('/')[0]
#		if y == year:
#			post = post.replace(year + '/','') # remove year from path so the directory structure is correct
#			html_output += '<a href="' + post + '">' + post + '</a>'
#			html_output += '<br>'
#		else:
#			continue
#	html_output += "</html>"
#	file = os.path.join(SITE_ROOT, year, "index.html")
#	f = open(file, 'w')
#	f.write(html_output)
#	f.close()


print "creating other pages"
pages = os.listdir(OTHER_PAGES_FOLDER)
for page in pages:
	path = os.path.join(OTHER_PAGES_FOLDER, page)
	f = open(path,'r')
	title = f.readline()
	html_output = generateHeader(title, "article")
	html_output += f.read()
	f.close()

	if saveHTML(html_output, os.path.join(SITE_ROOT, page)):
		print "success: created other page:", page
	else:
		print "failed: creating other page:", page
		sys.exit(1)

print "copying everything from include/ to site root"
files = os.listdir(INCLUDE_FOLDER)
for f in files:
	src = os.path.join(INCLUDE_FOLDER, f)
	dest = os.path.join(SITE_ROOT, f)
	shutil.copy(src, dest)

print "all done"