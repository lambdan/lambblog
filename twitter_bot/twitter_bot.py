import tweepy
import feedparser
import re
import requests
import os
import datetime

# pip3 install tweepy feedparser

feed_url = "https://lambdan.se/blog/rss.xml"
database_file = "./tweeted_by_twitter_bot.txt" # txt with urls that have been tweeted (one url per line)
twitter_consumer_api_key = ""
twitter_api_secret_key = ""
twitter_access_token = ""
twitter_access_token_secret = ""

def auth_twitter():
	auth = tweepy.OAuthHandler(twitter_consumer_api_key, twitter_api_secret_key)
	auth.set_access_token(twitter_access_token, twitter_access_token_secret)
	api = tweepy.API(auth)
	return api

# print date time, useful for cron logging
print ( "The time is", str(datetime.datetime.now() ) ) 

# read already tweeted links
already_tweeted = []
if os.path.isfile(database_file):
	with open(database_file) as f:
		lines = f.readlines()
	for line in lines:
		already_tweeted.append(line.rstrip())
print(len(already_tweeted), "urls in", os.path.abspath(database_file))


# read rss
print ("Grabbing rss feed", feed_url)
feed = feedparser.parse(feed_url)
print("Got", len(feed.entries), "posts")

for entry in reversed(feed.entries): # reverse it to get newest last (makes sense if posting a backlog)
	title = entry.title
	url = entry.link
	text = entry.summary

	tweet_text = str(title) + " " + str(url)

	# check here if url in tweeted links
	if url not in already_tweeted:
		print(">>> Tweeting", title, url)

		# auth twitter
		twitter_api = auth_twitter()

		# find first image
		images = []
		images = re.findall('src="([^"]+)"', text)

		# dont tweet if first pic is a gif
		if len(images) > 0 and str(os.path.splitext(images[0])[1]).lower() == '.gif':
			print("*** First image is a gif, not dealing with that. Posting without image instead.")
			images = []

		if len(images) > 0: # tweet with image
			picture_url = images[0]
			# download image - https://stackoverflow.com/a/31748691
			temp_filename = "twitter_temp_" + os.path.basename(picture_url) # this should get us the file extension etc
			req = requests.get(picture_url, stream=True)
			if req.status_code == 200:
				with open(temp_filename, 'wb') as img:
					for chunk in req:
						img.write(chunk)

				twitter_api.update_with_media(temp_filename, status=tweet_text)
				os.remove(temp_filename)
			else:
				print("!!! ERROR: Unable to download image")
				sys.exit(1)
		else: # tweet without image
			twitter_api.update_status(tweet_text)

		with open(database_file, 'a') as d:
			d.write(str(url) + '\n')
	else:
		print("Already tweeted:", title, "-", url)
