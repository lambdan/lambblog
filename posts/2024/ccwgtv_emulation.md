2022-01-15T23:20:00+01:00
# Emulation on Chromecast Google TV

Couple of weeks ago I got a Chromecast with Google TV, or as you can elegantly abbreviate it: CCwGTV. Main reason was to remove my Apple TV 4K box so I had one less box hooked up, along with its 3 cables (power, ethernet, HDMI). 

Unfortunately, this Chromecast requires dedicated power (can't just run it off your TV's USB port like you could with older Chromecasts) so I still have to have 1 cable running to it (not counting the HDMI since it's practically just a stump). 

Anyway, it's fine but I hate a lot of things about it:

- The UI (Android TV) is generally slow and choppy
	- Switching output resolution to 1080p60 (from 4k60) seems to make it snappier, so if you have a 1080p TV: enjoy.
- The remote is generally bad. It's too small, the volume buttons are placed awkwardly, the source button doesn't seem to do anything.
- The Plex app is awful and for some reason has to transcode anything HEVC encoded. Curiously, if you cast from your phone it direct-plays them. Weird.
- You have to set up a Google Home to use it and say no to a bunch of personal recommendations crap. The onboarding was just generally terrible, I have no idea how "normal" users can get through it without cursing.

Other than that, it's a fine Chromecast, it's like a Chromecast Ultra but with extra bloat. There are a couple of things I miss from my Apple TV (like good Plex app and AirPods support), but I watch so little Plex nowadays that I figured it makes sense to optimize for YouTube instead.

And then today, out of nowhere, I woke up and wanted to try running emulators on it.

There's nothing weird about this really. Since it is Android TV, you can just search for emulators on the Play Store and install them. To get files (roms) onto the device you'll probably want to install something that can host a FTP server - I use Solid Explorer - but there are probably millions of apps that can do this.

Once you have a FTP server running you can just go on your computer and transfer roms over to it. Then you just pair a Bluetooth controller to it, fire up an emulator, pick your rom, and there you go: you are now emulating games on the CCwGTV.

As easy as it is, there are some discoveries I made throughout the day I figured I should share to save everyone some time in the future. But before I do, let's go over our priorities here.

Our main priority is convenience, not accuracy. If your main goal is accuracy and performance you should get out your CRT, all the consoles, and all the cables. That is a very messy setup and not very convenient. If you get tired of retro games you have all that crap out just collecting dust. Contrast that with the CCwGTV: if you get bored of retro games literally nothing changes, it's just stuck there behind the TV as it always was. And then when you wanna play again you just pull out the controller and you're good to go again.

In essence, my priorities are:

Convenience > Performance/Latency > Visuals > Emulation Accuracy

If you're one of those people that want your scanlines, sub frame input lag and 100% accuracy, this ain't for you, go hug your CRT. This is for us who want to get 90% there and not have a bunch of shit hooked up.

So, here are my notes:

- Google/Android TV works well to navigate with a game controller. I used some 8bitdo controllers and a PS4 controller and both worked fine. 
	- Unfortunately, the headphone jack on the PS4 controller does not work. Would've been neat to be able to use that for those late nights when you wanna use headphones.
	- Bluetooth connection also seems pretty sensitive with PS4 controller, I was able to block it by putting my leg up in front of it. Didn't seem to be a problem with the 8bitdo's. Since your TV is blocking your CCwGTV I can imagine that the Bluetooth signal is already weakened.

- There is only about 2 GB of free space on the CCwGTV. This means you cannot put a ton of roms on there, especially PS1 stuff is tricky... a game like _Final Fantasy VII_ is about 1.5 GB when compressed to a `.pbp`. 
	- The entire NES USA set is about 200 MB so you can throw that on there
	- For the rest of the systems I recommend just putting the games you actually want to play on there, or you can google around and find romsets that have the top 100 most popular games, those are perfect and usually have what you want. 
	- You can (apparently) hook up a USB-C hub to it and expand storage that way. I, however, have not done that as I want my setup as minimal as possible. But if you want to have a bunch of PS1 games ready to go you probably want to look into this.
		- Another benefit is that you can get wired ethernet this way.
	- The cartridge based emulators below support reading roms from .zip and even .7z files. While the space savings aren't massive, they do add up, so it could be worth it since the CCwGTV is so small.
		- Does not work for PS1/ePSXe as PS1 games are several hundreds of MB: too large to uncompress on the fly.
		- Roms will start slightly slower when they are zipped. It's not a huge difference but you can notice it.
			- Epsecially zipped N64 games in M64Plus takes a couple of seconds.
		- Needs to be one rom per zip. If you're on Windows and have 7-Zip available, you can check here how to how to do it: [How do I create separate zip files for each selected/file directory in 7zip?](https://superuser.com/questions/311937/how-do-i-create-separate-zip-files-for-each-selected-file-directory-in-7zip)
		- .zip files tend to be more compatible, but .7z does save slightly more space.
		- Here's how much space I saved in my testing:
			- 377 NES roms uncompressed: 92 MB
				- Compressed to .zip: 47 MB
				- Compressed to .7z: 42 MB
			- 170 SNES roms uncompressed: 316 MB
				- Compressed to .zip: 199 MB
				- Compressed to .7z: 182 MB
			- 162 Genesis roms uncompressed: 214 MB
				- Compressed to .zip: 116 MB
				- Compressed to .7z: 104 MB
			- 199 GB/GBC roms uncompressed: 209 MB
				- Compressed to .zip: 84 MB
				- Compressed to .7z: 72 MB
			- 260 GBA roms uncompressed: 2.37 GB
				- Compressed to .zip: 1.12 GB
				- Compressed to .7z: 986 MB
			- 34 N64 roms uncompressed: 840 MB
				- Compressed to .zip: 652 MB
				- Compressed to .7z: 597 MB


- RetroArch works, with all of its RetroArch features, but performance is not great. If you're not super picky about performance and latency, it's fine (I was able to beat Back To The Future 3 using it), but you will get dropped frames and audio stutter here and there. It felt very juddery. Maybe with some future updates it'll be great.
	- Switching output resolution to 1080p60 helped a little, it made NES games (Nestopia UE core) perfectly smooth, but especially SNES (Snes9x core) was still chugging along at times. Genesis (using PicoDrive core) was pretty good (I beat BTTF3 with it as I said).
	- Another downside of RetroArch is that the app itself is close to 700 MB which is quite a lot when we only have a few GB's to play with.

- Instead of RetroArch I recommend using the "dedicated" apps that are on the Play Store. You can just do generic search terms like "nes", "snes", "genesis", "ps1" and "n64" and they should be the first result. Most of them are paid but I've found them well worth it, I bought them years ago, probably when I had my first Android phone. They're not that fancy but they're solid and have been around forever.
	- These are seemingly made by the same person and has been around for a long, long time:
		- _NES.emu_
			- I recommend going into video settings and changing the color palette to FirebrandX's for a more real NES look. I find the default FCEUX palette that most emulators use a bit too saturated.
		- _Snes9x EX+_
		- _MD.emu_
		- _GBA.emu_
		- (These are just the ones I use, but I think he has most 2D platforms covered so just get the ones you need)
		- All of these use the same kind of UI. It's a bit weird at first but once you get used to it you can fly through it.
	- _ePSXe_
		- By default the audio quality is very bad and has lots of lag. However you can easily fix this in audio settings.
	- _M64Plus FZ_
		- The UI is kind of busy and modern but click around and you'll figure it out. Notably all the controller settings are done with the so called "Presets", not in Input settings.
		- I recommend changing to one of the faster presets and reducing the resolution to 320x240. This is quite ugly but I think it's better than 640x480 + more lag.
		- There is a Pro version but I don't use that. Not sure what's better with it. 
- By default most of these emulators are set up to use some kind of bilinear filter which makes everything look slightly soft. Luckily you can turn it off, but everyone calls it something different. 
- Similarily, all emulators by default does not use integer scaling. If you're into that (you should be) you can go into video settings 
- In each emulator input settings, make sure to map a button to the menu, otherwise you have to use the Google remote to get out of the game, which is very annoying.
	- I use R3 for this (old OG Xbox muscle memory), except for ePSXe where I use the PS button on the PS4 controller

- NES, SNES and Genesis works great. No issues. Atleast in the games I played.

- PS1 seems good. I only tried _Castlevania SOTN_ and _Spyro the Dragon_ and they seemed to run well in ePSXe. 

- N64 games are... not great. They're not terrible either, but they obviously have problems. It feels like playing on _Project64_ back in 2006 again and it doesn't look very pretty. With that said, if you don't have your N64 and just wanna do a casual playthrough of _Ocarina of Time_ again after 20 years, it's probably good enough for you.
	- Hell, I have a N64 and I think I might still do a playthrough using this setup, just because its more convenient than pulling my CRT and all the other crap out.

- GBA games seem fine. They had some lag sometimes, but not much. I am not very into GBA though so I don't know what to look for. I played some Super Mario Advance and I found them very playable.

Overall, I think using a CCwGTV for emulation is very enticing as it is a very clean setup. No extra cables, no upscalers, no scart splitters, no power cables or bricks... The Chromecast is just hanging out behind your TV like it always is. The only visible thing is your wireless controller, but that is very easy to put away.

Seriously, I cannot make this point clear enough: even if you have a HTPC, Raspberry Pi or a Mister, that is atleast 2 extra cables, but probably more, and a box added to your setup. A CCwGTV is invisible: it's behind your TV. It's a very clean and elegant setup.

If Google releases another CCwGTV that is faster I think it could be really good. I mean, it's already pretty good, but I feel like it's right on the edge of being good enough. Would be nice to have a little boost, especially for N64 stuff.

![Homescreen](https://i.imgur.com/9tjlEpB.jpg)
<figcaption>What my homescreen looks like now</figcaption>

-----------------------

Updated 2022-01-16: Added .zip details