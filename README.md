This is the thing my blog over at http://lambdan.se is running on.

I mainly keep it on Github for my own development purposes, but also so you can use it if you want.

If you do decide to you use it, you should open every PHP-file in a text editor and search for "lambdan.se" and replace all of those with your own domain. 
(Yes, I know I could have like a `$domain = "lambdan.se";` global option but it just looks messier in the code with all the `<?php ?>` everywhere.)

## Features

- Reads blog posts from Markdown formatted txt-files saved in the `posts/` directory 
- Support for linked posts
- [Valid RSS Feed][rss] and JSON Feed
- Mirrors images and saves them locally for (probably) faster load times and future proofing (incase images disappear in the future)
- Dynamic sitemap with every blog post
- Doesn't use any 3rd party CSS/JS library. Only thing we use (that I haven't written) is [Parsedown][pd], and that is for converting Markdown into HTML using PHP
- Looks good on mobile
- Stats page showing word counts and most common words for a specific post

## How To Use

- Install PHP (my VPS is running PHP 5.5.27-1)
- Go through config.php and configure it your way (root URLs, etc.)
- Write blog posts in Markdown and save them in the `posts/` directory. 
	- First line must be the date (many formats work, see [strtotime][strtotime] manual)
	- The second line must be a # followed by a space, and then the title of the blog post
	- Optional: The third line shall be a URL starting with http (or https) if you are doing a linked post
	- (See the `posts/` folder in this repository for examples)
	- After that you can write whatever you want
- Start writing and hope someone reads 😭

## Note on filenames for posts (as of versions from 2 Jul 2017)

The filename for the first post you ever do shall start with a number (maybe `1`?), and then call it whatever you want, like: `1.txt` or `1 first post.txt`. This is because we need to start our numbering index somewhere. After this post, you can add another post with a filename like `i am quitting blogging.txt` and it will automatically be prefixed with a number `2` when you visit the Archive page. 

So in other words, here is the flow chart for adding posts:

If it is your first post:

- Name it `1.txt`, `1 first post.txt` or `666 i love satan.txt`
- Upload/save it into the `posts/` folder

If it isn't your first post:

- Name it `whatver you want.txt`
- Upload/save it into the `posts/` folder
- Visit the archive page (`archive.php`) in order to refresh and automatically rename `whatever you want.txt` to `n+1 whatever you want.txt` (where n is the number of your previous post)
- Of course, you could have also called it `n+1 whatever you want.txt` right from the start, but it gets hard to keep track of after 150 posts...

[pd]: http://parsedown.org
[strtotime]: http://php.net/manual/en/function.strtotime.php
[rss]: https://validator.w3.org/feed/check.cgi?url=lambdan.se%2Frss
