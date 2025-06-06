2019-04-20T21:41:00+02:00
# We're Static Now

Not too long ago I wrote [If It Ain't Broke Don't Fix It](https://lambdan.se/blog/2018/11/10/if-it-ain-t-broke-don-t-fix-it/).
And well, now it's broken and somewhat fixed, because I made my own static blogging engine!

It's just a Python script I wrote completely from scratch which parses my old blog text files, mirrors and thumbnails images, creates the stats pages, creates the RSS feed, etc, and creates HTML files out of that.
It does almost everything the old lambblog engine did, but now it's done once and then the files are static and just served. My server doesn't have to do basically any processing.

The downside of all this is ofcourse that basically every link that ever linked to my blog is now broken. I have set up a re-direct so you get to this new one, but it will still be very annoying for a long time. Google needs to re-index everything too, and such.
I'm gonna try go to through my old blog posts and edit the links there too. 

But, now I finally have that `blog/yyyy/mm/dd/slug-title/` format that everyone uses, because it looks nice.

Another nice thing, since it's static, is that I have upped the limits on the Stats page alot. [Now all of the posts are listed](https://lambdan.se/blog/stats). I also tried listing every word on the individual post stats pages, but it broke with my 20,000 word [Friends post](https://lambdan.se/blog/2016/12/21/personal-notes-on-friends-all-of-its-episodes/) so I disabled that for now.

And finally, the nicest thing is of course that everything is a bit snappier. While my blog was pretty fast before, it's even faster now.

As always, you can find the code to it on the [Github page](https://github.com/lambdan/lambblog). I am actually pretty impressed with myself because I wrote all of this in less than a day. It went very smooth for the most part.

One huge problem with it at the moment is that it just flat out deletes the entire website folder, and then starts generating it. This means that if there is an error the website folder will be empty and you will have no website.
I should generate the site to a temporary folder, and then move everything over once everything is OK. That is next on my list.

And then after that, there's probably a ton of other problems. I've noticed inline URLs don't automatically get turned into clickable links, for example. But it seems good enough for now.

Oh, and while doing this, I listened to the same two songs (or well, one of them is just a remix of the other one so it's basically the same song).

![Horse 1](https://lambdan.se/img/blogpics2019/brave_2019-04-20_01-53-23.png)
![Horse 2](https://lambdan.se/img/blogpics2019/brave_2019-04-20_22-17-04.png)

