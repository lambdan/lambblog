# lambblog

Markdown static blog generator made with Python, used at https://lambdan.se/blog/

This is a new rewrite of lambblog, which previously was dynamic using PHP, so there are still features missing and lots of things I haven't tested. 

**I cannot really recommend anyone but me using it at this point :)**

## Features

- [Valid RSS Feed](https://validator.w3.org/feed/check.cgi?url=https%3A%2F%2Flambdan.se%2Fblog%2Frss.xml)
- [Stats](https://lambdan.se/blog/stats) page with some silly metrics
- Mirrors full quality images and *also* creates lower quality versions for faster loading
- Looks good on mobile
- Support for link posts

## Usage

This is made for my own blog, but if you wanna use it, you can:

- Place this script in a new folder
- In the folder called `posts` goes your Markdown formatted text files/blog posts... see examples in the repo, the first 3 lines are important
- In the folder called `pages` goes your `about.html` and `misc.html` pages. If you want more pages, you can add more but you have to modify the generateHeader() def to include them (ideally this will be done automatically eventually). The very first line of these HTML files should be the title of the page. These pages will be wrapped in the css-class `article`. See examples in the repo.
- Next to the script, create a folder called `includes`, in here goes stuff you want in the root of your site, such as CSS files, favicons
- `pip install python-dateutil python-slugify markdown2 Pillow bs4 requests feedgen`
- Then run the script with either `--test` or `--live`