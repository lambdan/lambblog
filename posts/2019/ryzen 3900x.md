2019-11-29T22:48:00+01:00
# 8700K to 3900X

I finally caved and bought Ryzen 3000. Why?

Well, frankly, if we wanna cut right through the crap: I like spending money. My i7-8700K was perfectly fine and didn't bottleneck me in anything I actually did. 

I could sit here and make up arguments for why I needed the CPU upgrade:

- I need to transcode x264 faster
- I need a better CPU so I can stream with x264 while playing PC games
- I want to support AMD

Do I need to transcode x264 faster? Nope. In fact, I don't even use my main computer for it anymore. Since I have my Plex server on 24/7 I just do it on that (which has a Ryzen 1700X by the way) so it can run 24/7 making it faster overall, even if the actual transcode speed is slower than my main computer, since it can run 24/7 while my computer is off when I'm sleeping.

Do I need a better CPU so I can stream while playing PC games? Nope. I rarely stream nowadays. 

Do I want to support AMD? Hell yeah. This is the biggest reason why I did this basically. Ever since the first 3000 reviews came out in the summer I've been right on the edge of ordering. Just the idea of having a 12-core CPU was amazing and seeing the x264 benchmarks was amazing. 

I tried to distract myself from it by [moving my computer to a Louqe Ghost](https://lambdan.se/blog/2019/07/29/the-louqe-ghost-s1-build/) case, and I lived with it for a couple of months, but I eventually switched back to ATX.

And then I switched back to the Ghost for a couple of weeks. And then I finally switched back again to ATX, landing on the _Fractal Design Define C_ again, this time without the tempered glass.

The Louqe Ghost is a nice small case and all but there are just so many hazzles with a tiny build like that:

- Want to switch RAM? You need to take the CPU cooler off, which means you basically need to remove everything.
- Want more storage? Either squueze in a SATA disk, adding a bunch of cables, or replace one of your expensive NVMe SSDs. 
- Want to switch motherboard? mITX motherboards are more expensive.

Having a big computer is a pain in the ass if I ever wanna move it, but I realized I rarely do. I rarely take my computer anywhere. And even if I do, I have a car nowadays so it doesn't really matter.

... I digress.

Back in the ATX case I wanted to get my 8700K overclocked again. I had been running it as cool as possible in the Ghost so now I wanted to try and go for 5 GHz on it.
Unfortunately, I think I fried something in the process. 

You see, before I switched to mITX, I ran my 8700K at constant 4.8GHz all cores for a year. It was super stable. So I figured that with good cooling and bumping up the voltage to 1.35 or so I could easily get 5 GHz. 

But no matter what I tried, I couldn't get it stable. And even though I had delidded it, it got up in the high 90s of celsius. 

So I gave up and put it back to 4.8 GHz at 1.28 volts. But something interesting had happened: it wasn't stable anymore.
No matter what settings I tried (bumping up the voltage, changing LLC, unlocking everything I could find regarding power limits) it just wasn't stable anymore. 

My conclusion was basically that my 8700K was degraded, and that was the final straw for me ordering the Ryzen parts. What fun is it having an unlocked Intel CPU in a big case when you cant overclock it?

# Pre Ordering (as in Before Ordering)

Previously when buying motherboards I honestly haven't cared much. I just looked at the form factor, socket, brand, and maybe how many SATA ports it had available. But my understand is that VRM's matter alot for Ryzen 3000. 

What is VRM? I have no idea. It's something about how the motherboard delivers power to the CPU or something. Frankly I don't care enough. I just know I want good VRM's.

So there are many Youtube videos about this subject, I think this one was the most straight to the point: [Affordable X570 VRM Thermal Performance, Warning: One Board Sucks! by Hardware Unboxed](https://www.youtube.com/watch?v=_7PkZwY9PWM).

The choice basically came down to the _Asus TUF Gaming X570-Plus_ or the _Gigabyte X570 Aorus Elite_. Both had their pros and cons from my research:

- The TUF has better VRM
- The TUF has a PS/2 port, which might seem silly but those of us that sometimes use a _IBM Model M_ greatly appreciate that
- The Gigabyte has Intel LAN which most people prefer over the TUF's Realtek LAN
- The Gigabyte has integrated IO shield
- I really hate the TUF branding

So I went with the _Aorus/Gigabyte X570 Elite_.

Which brings me to the topic of discussion: **Why did I go with X570?**

Mostly because it just feels like the right thing to do. I got a X370 board for my Plex server and I really liked it. It felt premium and had that nice little thing that makes it easier to plug in the power buttons and LEDs. 

And also, because I don't wanna run the risk of having to get a board that isn't updated for the 3000 CPUs. 

Finally, because it's more futureproof. Although, this point is fairly moot because I tend to upgrade often anyway.

While researching all of this I also completely forgot the X570 boards have a little fan on them. When these motherboards were originally introduced I laughed at it and said I would refuse to get a motherboard with a fan on it. 
But researching more about it, it basically doesn't seem to matter. The general consensus seems to be that the fan is so quiet it doesn't matter.

And as an owner of a X570 board, I can confirm this. I never think about the fan. With that said, I would still prefer if motherboards didn't have a fan, as they're likely to fail first.

## 3900X or 3950X

After picking a motherboard, it was time to decide which CPU to get: the 3900X or the new 3950X.

Part of me wanted to go with the 3950X, just because of the 16 cores, but the more I thought about it the more I realized the 3900X is a much saner choice for me. Frankly, even the 3700X would be, but I wanted >10 cores.

I feel like 12 cores is already ridiculous, 16 cores just felt unecessary. 

Another consideration was that 3950X was rumored to be severely limited in store stock at launch, which turned out to be true. I think all stores over here sold out immediately. 

And with the prices in Sweden, it turns out I got the 3900X + motherboard for cheaper than what just the 3950X is over here.

Still, the 3900X is very expensive. It is the most expensive CPU I have ever bought.

![Goodies](https://lambdan.se/img/IMG_20191125_163632.jpg)

# Assembling

Not much to say here thats specific to the CPU but I just wanna comment on the mounting system for AM4: I don't like it. The little pin you pull down feels very breakable. Having been on Intel for a couple of years I've gotten used to it's socket and how tight the CPU is held down. 
The AM4 socket feels very flimsy and cheap. But hey, you could put this CPU in a B350 motherboard from 2 years ago so that's always something.

# Parts List

So my final parts list is as of now:

- Fractal Design Define C (Case)
	- Noctua NF-A12X25 120mm (Fan) in the back, as exhaust
- Gigabyte/Aorus X570 ELITE (Motherboard)
- AMD Ryzen 9 3900X (CPU)
- NZXT Kraken X62 (CPU Cooler), mounted in front with pull configuration
- Corsair Vengeance LPX 3200 MHz 2x16 GB RAM CL16 (RAM)
- MSI GTX 1080 TI Founders Edition (GPU)
- Corsair CX650M (PSU)
- SSDS:
	- Samsung 970 EVO 500 GB NVME (Windows Disk)
	- Intel 660p 2 TB NVMe
	- Samsung 960 EVO 1 TB SATA
	- Crucial MX300 750 GB SATA
	- (I tried putting a mechanical disk in here again, but nope, I can't stand the noise, keep that in mind whenever I mention anything about noise)
- Startech PEXHDCAP60L (Capture Card)

![Inside](https://lambdan.se/img/IMG_20191125_175800.jpg)
<figcaption>The Noctua fan should be to the left on the picture. If it isn't, I hate rotation metadata. Try clicking the image to open the original photo which should have the correct orientation.</figcaption>

The nice thing about having a case without a window on it is that you really don't have to care about cable management. I still try to route the wires as neatly as I can through the little holes but I don't feel the need to be OCD about it.

Surprising to me is how tight the Define C is with an AIO in the front. My graphics card has a reference cooler and it's not much space between it and the AIO's fans. So if I buy a new GPU (which I really hope I don't have to anytime soon because they're still so expensive) I'll definitively need to measure first.

I'm also waiting for the [140mm variants of NF-A12X25](https://twitter.com/Noctua_at/status/991726945481232386). The NZXT stock fans are fine for now.

# Performance/Benchmarks

So let's get into why you're here. 

Well, maybe you're not here because of this because this CPU has been out for almost half a year now, there are plenty of benchmarks all over the internet. But here's mine.

I enjoy making these kind of benchmarks for the most part. It's fun changing variables and see what happens.

As a sidenote, I have to mention I used _Google Docs_ for these numbers for the first time. Previously I've used _LibreOffice_ or _OpenOffice_, but I really prefer Google Docs I have to say. I don't know why I didn't try it sooner, I guess it's because they're web browser based and so I assumed they were automatically bad.

## x264

First my classic x264 benchmark: encoding _Friends S05E21_ into 1080p 6000kbps using the medium preset using Handbrake and [Don Melton's scripts](https://github.com/donmelton/video_transcoding). This is the test I've done on most CPU's so I have many CPU's to compare with. Here's the most recent chart:

![x264 Chart](https://lambdan.se/img/x264_2019-11-29.png)

This was the first test I ran, and boy was I excited. I immediately fell in love with this CPU. It's effectively a 2x improvement over the 8700K.

## x265

For x265 I encoded the same episode of Friends, with the same settings, except I used x265 instead. Unfortunately I haven't ran this on many CPU's, so this is all I have to show:

![x265 chart](https://lambdan.se/img/x265_2019-11-29.png)

x265 is still very slow unfortunately, even if its a 55% improvement. Atleast we can do it in realtime now.

## Cinebench R20

Running Cinebench is kind of silly, because I don't do any rendering. But everyone else runs this and it's easy to do, so why not.

![Cinebench R20 Single Core](https://lambdan.se/img/cbr20_single_2019-11-29.png)

Not a huge difference in single core, as expected. In fact, if I could run my 8700K at 5GHz I'm fairly sure it would be better.

![Cinebench R20 Multicore](https://lambdan.se/img/cbr20_multi_2019-11-29.png)

Huge, >2x gain when using all the cores and threads, as expected. Running Cinebench is kinda fun on this CPU, just to look at the picture fill in. From what I've seen of other benchmarks my 3900X is kinda low, I should be getting around 7200 points, but it doesn't really matter. It's fast.

## Gaming while "streaming"

This is a test I haven't ran before, but I got inspired after watching some [_Gamers Nexus_](https://www.youtube.com/user/GamersNexus) video where they did it when testing CPUs. I unfortunately can't remember which video it was so I can't link it. It was probably a review of a Ryzen CPU.

To test this I decided to run _Red Dead Redemption 2_ at 1080p with all settings set to High. Then I record it with OBS, using various x264 settings, and run the in-game benchmark. I take note of average FPS, 1% low FPS, 0.1% low FPS and how many frames OBS skips due to encoding lag. 
I also run a test with no OBS, as a control. 

Why RDR2? Well, it's a new game and it's the only game I could think of at the moment that had an in-game benchmark.

Recording with OBS instead of streaming is basically the same thing, except that instead of pushing your video to Twitch over the internet, you are just saving it locally on your hard drive. It should be just as CPU demanding.

This was going well, until I got the Ryzen system, because then I started getting skipped frames in OBS due to render lag. I tried googling it, and I still can't understand it. It seems to have something to do with the GPU being too busy to render for OBS but since I didn't switch GPU that doesn't make any sense to me. Because the CPU isn't pegged at 100% usage I would like to just ignore these render lag skips, but I feel that would be unfair and would look like I am trying to hide something. 

So instead of showing you how many frames each CPU skipped on a diagram, I'll show you this diagram showing the benchmark results:

![RDR2 Bench](https://lambdan.se/img/rdr2_bench_2019-11-29.png)

As expected the 8700K is better for the average FPS, but note the 0.1% lows are significantly worse when streaming with one of the heavier x264 presets, creating an uneven "jerky" gameplay experience. The 3900X generally performs more consistently no matter how you're streaming.

But then to show you how many frames each CPU skipped, and what implication that has, I present you this video with the resulting recordings of the medium preset tests:

<div class="video-container">
<iframe allowfullscreen="true" frameborder="0" src="https://www.youtube.com/embed/TaIpamy1_kI"></iframe>
</div>

As you can see, the 8700K version is basically unwatchable because it dropped 5381 frames due to encoding lag. Meanwhile the 3900X dropped 0 due to encoding lag (203 due to render lag).
Also notice how the 8700K is pegged at 100% constantly, while the 3900X is down in the 60%'s.

In interest of full disclosure, here's my whole table of data for these tests:

(8700K was in MCE mode)

|CPU/Preset	Avg|FPS|1% Low FPS|0.1% Low FPS|OBS Skipped Frames due to encoder lag|OBS Missed Frames due to render lag|
|--------------|---|----------|------------|-------------------------------------|-----------------------------------|
|8700K (No OBS)|86,2|62,8|44,8|N/A|N/A|
|3900X (No OBS)|79,6|58,8|41,9|N/A|N/A|
|8700K (x264 veryfast)|75,1|35,5|27,5|0|26|
|3900X (x264 veryfast)|69|30,5|26,5|0|176|
|8700K (x264 fast)|67,9|21,7|9,3|327|13|
|3900X (x264 fast)|68,6|31,1|26,9|0|193|
|8700K (x264 medium)|71,3|27,6|14,3|5381|0|
|3900X (x264 medium)|69,1|30,4|25,6|0|203|

It occurs to me that the 8700K gets more render lag frames when the CPU is pushed less also. So maybe the less stressed the CPU is the more stressed the GPU is and causes render lag? I have no idea.

It's really amazing to see the 3900X drop 0 frames on the medium preset, but it's also fascinating that the 8700K still gets better in-game performance. This makes me realize I really don't understand how CPU's actually work.

## Civilization VI

Civ 6 has an AI benchmark built in. _Gamers Nexus_ also tests this game so I figured I'd try it too. 

![Civ 6](https://lambdan.se/img/civ6_2019-11-29.png)

Minor win for the 3900X here, by roughly 0.2 seconds. Does 0.2 seconds matter? 

Well, a typical game of Civ 6 is 500 rounds. So for the 8700K that would be `6.28 * 500 = 3140 seconds` of waiting for the AI over the course of the whole game. 
On the 3900X you would be waiting `6.09 * 500 = 3045 seconds` which is roughly 1.5 minutes less. 

## Bonus: Fan & Pump RPM vs CPU Performance with the _NZXT Kraken X62_

Since Ryzen automatically "overclocks" itself when there is sufficient cooling (I think it's called _Precision Boost_ but it's very confusing, [read here if you really want to](https://www.gamersnexus.net/guides/3491-explaining-precision-boost-overdrive-benchmarks-auto-oc)) I've been experimenting with fan and pump speed on my _NZXT Kraken X62_, to see if it made any difference to the CPU speed when changing pump or fan RPM, in the hopes of having a practically silent system while maximizing performance.

To test this I encode the first hour of the Godfather (1080p) in _Handbrake_, using the _HQ 1080p30 Surround_ preset (which is the slow preset), and take note of the average FPS. This takes roughly 27 minutes to complete and it's important that it takes a while, because you need to run a long workload so the liquid inside the AIO has time to get warm. I first tried just running it on the aforementioned Friends episode, but it finishes it so fast the liquid doesn't really get warm. Ideally I'd do the whole movie (which should take 1.5 hours), maybe some day.

The _NZXT CAM_ software lets you set the pump to a minimum of 60% speed, which is roughly 2000 RPM. For the fans it lets you go down to 25%, which is roughly 500 RPM on the stock fans.

100% on the pump is roughly 2700 RPM and on the fans 1700 RPM. 

As far as noise goes, the pump is pretty quiet no matter what speed you run at, but you can hear it at 100% if everything else is quiet. It's like a gentle buzz, similar to a 5400 RPM hard drive.

The fans becomes audible for me at around 800 RPM, and they're very loud at their max speed.

So here's my table of results:

|Pump Speed|Fan Speed|Average FPS|Peak CPU Temperature|
|----------|---------|-----------|----------------------|
|60%|25%|52,061398|88° C|
|100%|25%|52,092243|87° C|
|60%|100%|52,864212|81° C|
|100%|100%|52,963295|78° C|

Frankly, the differences in average FPS are so low it might just be margin of error, or my testing methodology is wrong (maybe _Precision Boost_ doesn't work on AVX workloads?). 
On the other hand, the average FPS goes up (albeit very little) the cooler the CPU ran, so maybe it is accurate.

My conclusion from this is that pump speed doesn't make much of a difference, which is in line with what I read online. Seems like a lot of people just run their pumps at the lowest possible speed. 

Do note the max temps on the lower fan speed setups though, and remember that's only after a 27 minute workload. Would be very interesting to see what would happen if you ran a much longer workload.

I'll probably end up running my pump at the lowest value (60%) and fans at variable speed. I currently have the fans at the lowest speed (25%) until the liquid hits 40°, then the fans ramp up to 50%. In my experience it seems the liquid stays below 40° unless you're doing something CPU intensive. I usually sit at 35° in Windows doing regular things, like writing this.

It's important to target the liquid temperature in the _NZXT CAM_ software instead of the default CPU temperature, because otherwise the fans will spin up immediately when the CPU gets warm, which is kinda dumb because it's when the liquid starts getting warm they need to spin up. 
Once I figured this out I was very happy with my AIO as this results in a significantly more quiet computer compared to the _Noctua NH-U14S_ tower cooler I had previously.

I might do a follow up post on this subject some day, because I feel there is more to be explored. 

# Thoughts

I love AMD in the year of 2019. I'm thrilled to see how they turned things around. 
I've also become a huge fan of their CEO, _Lisa Su_. I've watched alot of her interviews and presentations on YouTube and I love her. She seems like a nice, calm, smart, reasonable and genuine CEO.

I remember building my cousin a PC of couple of years ago and I nagged him many times to see if he couldn't come up with a bit more money so we could go on Intel instead. But no, he had to settle for something really terrible that he can barely game on nowadays. I think its an A10 or something. 

Nowadays you can build a really cheap Ryzen based computer and it's great. Something like the Ryzen 2600 is super cheap now and is still very good. I wish that CPU was available when my cousin built his computer a couple of years ago.

With time I believe Ryzen will just become better and better, especially because the new game consoles will use it. I think games will become more multithreaded and take advantage of the architecture. 

Hopefully Intel will also get their act together and come up with some actual new CPUs and take care of those security vulnerabilities. If they're significantly better I'll switch back to them, no problem, but for the moment I am very happy to see them struggling because they've been on top for a long time and did nothing interesting.

But for now I'll continue to enjoy watching multithreaded runs of Cinebench.