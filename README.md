Before you start using this, there are things you should edit:

archive.php
- Change any occurence of lambdan.se to your domain
- Change the twitter username

helpers.php
- Change the time zone
- Change the txt directory if you plan on keeping them anywhere else but './posts/'

index.php
- Change any occurence of lambdan.se to your domain
- Change the Twitter username

Parsedown.php
- change the $image_mirror_url_prefix to better suit your domain

rss.php
- change any occurence of lambdan.se to your domain

sitemap.php
- change any occurence of lambdan.se to your domain

##########################

Requirements:
- PHP

To use:
- Write Markdown formatted text files and save them as "n.txt" in the posts/ directory. The first line should be the date, and the second line should be "# Title". See the examples for more info.

##########################

Sidenote:
- The images/ folder are where images found in the Markdown files are mirrored to, to improve loading and future proofing (Dropbox is ending support for its Public folder links etc)
- The filenames are the md5 hashes of the URL to the image
