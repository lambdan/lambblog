This is the blogging engine I've written myself and use on my own blog/website: http://lambdan.se

It uses Bootstrap but you can just edit all that shit out. The main thing in this engine is the PHP code that reads markdown .txt files from a folder, and lets you output their date, links, images, content etc. into whatever HTML you want. In a way, you could say `getPostData.php` is the core.

## Features

- Can edit/create blog posts from anywhere with a internet connection (SSH)
- Portable (no databases)
- Markdown for text format (and you can also have HTML in your Markdown files)
- Twitter Cards (compresses images if needed)
- Downloads images stored on remote places to make loading (potentially) faster
- RSS feed
- Can see the raw markdown for posts by adding .text to the URL (example: http://lambdan.se/91/how-i-rip-my-dvds-amp-blu-rays.text)
- Dynamic sitemap.xml

## Installation

1. Install PHP5. Make sure to allow .htaccess yadda yadda.
2. Put all files in some folder of your website directory. Personally I use the root level (http://lambdan.se) but you can also use something like /blog (http://lambdan.se/blog)
3. Edit config.php

## Making a blog post

Your markdown files should be in `posts` and start with a number and can also have an optional name: `1.txt` or `2 title.txt`. I don't need whatever you put after the space after the number. It's just to make things easier for yourself.

Your Markdown .txt files should then have this syntax:

    date
    # Title
    (optional url)

    Content...

All you need to do to publish a post is to put the file in `/posts`, or wherever you config that folder to be.

If you don't know Markdown syntax, see this [page](https://daringfireball.net/projects/markdown/syntax). 

See `/posts` for examples. 