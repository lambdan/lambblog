# lambblog

This is the blogging engine I've written myself and use on my own blog/website: http://lambdan.se

It uses Bootstrap but you can just edit all that shit out. The main thing in this engine is the PHP code that reads markdown .txt files from a folder, and lets you output their date, links, images, content etc. into whatever HTML you want.

## Goals

- Can edit/create blog posts from anywhere with a internet connection (SSH is a thing)
- Portable (no databases)
- Markdown for text format (and you can also have HTML in your Markdown files)

## Installation

1. Install PHP5. Make sure to allow .htaccess yadda yadda.
2. Put all files in some folder of your website directory. Personally I use the root level (http://lambdan.se) but you can also use something like /blog (http://lambdan.se/blog)
3. Edit config.php

## Post syntax

    date
    # Title
    (optional url)

    Content...

See `/posts` for examples. 