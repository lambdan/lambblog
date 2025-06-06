2019-02-01T17:54:00+01:00
# GTA 100% Checklists
https://lambdan.se/d/gta_checklists/

Here's a little propject I've been working on: [GTA 100% Checklists](https://lambdan.se/d/gta_checklists/). The code is available on GitHub also: https://github.com/lambdan/gta_checklists

![Current Version](https://lambdan.se/img/blogpics2019/chrome_2019-02-01_18-03-22.png)

What is it? Well it's 100% checklists for the GTA games (only Vice City at the moment), but it lets you check the boxes and save your progress so you can easily keep track of what you've done.
Works great on phone, tablet, laptop or the Steam in-game browser.

That's pretty much it. It's pretty self-explanatory.

I mostly made it for myself as I like to play through the games 100% occasionally and I am tired of having to print out a list and check of the boxes manually and keeping track of if you reloaded a save in the game what you picked up etc.

I also added a really poor "save by code" feature, which just encodes the checklist (which is JSON, by the way) to base64 and then you can just copy/paste that if you don't trust the web browsers local storage.

I actually made a very similar thing back in 2014/2015 for my big school project, except it was an app that ran on both iOS and Android (I used some cross platform crap). 
Unfortunately I can't find my code for it anywhere, so I have no idea where it is. I don't think I threw it away so it's probably buried deep in my very unorganized Dropbox folder.

This time I've just made it with Javascript/Jquery and Bootstrap for the CSS/HTML, and honestly I've learned a lot. I feel like I get Jquery now, kinda. 
I also get Bootstrap, kinda, just throw everything in div's and find a suitable class.
Honestly, a lot of it was just googling and finding vaguely related questions on StackOverflow, and then some additional guessing. But hey, it works!

For giggles, here's the very working first version. It's very clean and simple, albeit a bit unusable as everything is just one very long column:

![First Version](https://lambdan.se/img/blogpics2019/chrome_2019-02-01_18-04-01.png)