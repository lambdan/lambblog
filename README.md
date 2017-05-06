This is the thing my blog over at http://lambdan.se is running on.

I mainly keep it on Github for my own development purposes, but also so you can use it if you want.

If you do decide to you use it, you should open every PHP-file in a text editor and search for "lambdan.se" and replace all of those with your own domain. 
(Yes, I know I could have like a `$domain = "lambdan.se";` global option but it just looks messier in the code with all the `<?php ?>` everywhere.)

## Features

- Reads blog posts from Markdown formatted txt-files saved in the `posts/` directory 
- [Valid RSS Feed][rss]
- Mirrors images and saves them locally for (probably) faster load times and future proofing (incase images disappear in the future)
- Dynamic sitemap with every blog post
- Doesn't use any 3rd party CSS/JS library. Only thing we use (that I haven't written) is [Parsedown][pd], and that is for converting Markdown into HTML using PHP
- Looks good on mobile
- Stats page showing word counts and most common words for a specific post

## How To Use

- Install PHP (my VPS is running PHP 5.5.27-1)
- Replace all instances of "lambdan.se" in the php files with your own domain
- Write blog posts in Markdown and save them in the `posts/` directory. 
	- First line must be the date (many formats work, see [strtotime][strtotime] manual)
	- The second line must be a # followed by a space, and then the title of the blog post
	- (See the `posts/` folder in this repository for examples)
	- After that you can write whatever you want
- Start writing and hope someone reads 😭

[pd]: http://parsedown.org
[strtotime]: http://php.net/manual/en/function.strtotime.php
[rss]: https://validator.w3.org/feed/check.cgi?url=lambdan.se%2Frss