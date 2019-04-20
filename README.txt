- Everything in includes is copied to site root
- Pages includes static pages you can make yourself. They will use the "article" CSS class.
- The pages in pages should just be plain HTML, but the very first line should be the title of the page, eg Misc, About

In POSTS_DIR, you will store Markdown text files in this format:

20 April 2019, 21:55
# Title
(optional link if a linked post)

Bla bla bla...

Mirrored and thumbnailed images will be stored in IMAGES_FOLDER

pip install python-dateutil python-slugify markdown2 Pillow bs4 requests feedgen