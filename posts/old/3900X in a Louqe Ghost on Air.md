2020-04-11T18:45:00+02:00
# Air-cooling Ryzen 3900X in a Louqe Ghost

For a couple of weeks now I've ran a Ryzen 3900X in my Louqe Ghost S1 case.

12 cores in a case that small could be considered crazy, but it isn't too bad.

I was going to make this post a really long one, similar to [the one I wrote last summer](https://lambdan.se/blog/2019/07/29/the-louqe-ghost-s1-build/), and I started writing it, but it got too long and I got distracted and put it off.
With that said, you should read my previous post about the case as a lot of info about the cooler and such are still relevant. Consider this post a sequel. You'll be lost without the prequel.

So now I am back, with a shorter point list to share my experiences:

- The motherboard I used was a _Asus Strix B450-I_.
	- I went with this board because it was the cheapest motherboard that:
		- Is mITX
		- Could swallow a 3900X
		- Has 2 M.2 slots.
- The cooler I used was the one I used last time: _Alpenföhn Black Ridge_, with the original fan removed and a _Noctua NF-A12x15_ put on top as intake (sucking fresh air in and blowing it through the fins onto the motherboard).
	- This is actually a ideal setup as this will help cooling the VRMs a little, even if it's hot air.
	- I know there is some scare about if the Alpenföhn works with some AM4 motherboards. I can report the Black Ridge, atleast the one I have, fits perfectly on the Strix B450-I without modification: ![Alpenföhn on  the B450-I](https://lambdan.se/img/rFxHNkZupS.jpg)
- Other specs are the same as my post from last summer, except I upgraded to 32 GB RAM:
	- Corsair SF600 Platinum
	- GTX 1080 TI FE
	- Corsair 2x16 GB LPX 3200MHz
	- Intel 660P 2 TB
- For short bursts of workload, i.e. gaming, the 3900X will do just fine on its own with the Black Ridge in the Ghost S1 case. _You don't have to worry about it._
	- This is true in general about all CPUs and cooler combinations if you are just gaming.
	- You could get the tiny _Noctua L9A_ cooler and use it with the 3900X if you are just gaming.
	- The thing is though, if you got the 3900X, you likely aren't just gaming. You probably run long workloads too.
- For long workloads, 15+ mins or so, the motherboard's VRMs and CPU gets toasty.
	- The CPU will hit 95 C and throttle, and the motherboards VRM's will get up there too.
	- The best and easiest way to fix this, is to add a exhaust fan (preferably a _Noctua NF-A12x25_) above the CPU/motherboard.
		- Inverting the case and adding a NF-A12x25 on the inside in the top as exhaust will keep the CPU from thermal throttling but VRM's still get toasty.
		- Adding a NF-A12x25 right above the motherboard will solve all your issues, and is the best you can do without going for liquid. I think only one fan will suffice, but since there's room for two in the tophat, I have two.
		- See the graphs below for results and pictures of the setups.
- Good video from _Optimum Tech_ about cooling a 3950X with low profile coolers: [Ryzen 3950X vs. Low Profile Coolers - Sanity Check](https://www.youtube.com/watch?v=2Ir1Wvcypic)
	- Unfortunately, he doesn't test the Alpenföhn, but he does test the Noctua L12S which is similar.
- The Asus boards seem to have a hardcoded limit where 75 C means 100% fan speed.
	- Unfortunately, this means even with custom fan curves and fan smoothing settings your fans will occasionally rev up for no reason. I recommend using a Noctua Low Noise Adapter for the CPU fan to help with this.
		- This does ofcourse mean everything will run a little hotter, but a little quieter also.
	- Liquid coolers have a big advantage when used with Ryzen as they won't annoyingly rev up and down, as their speed is based on liquid temperature.
- The Strix B450-I will make the PCI-express slot run at 8x if both M.2 slots are used.
	- [Apparently this shouldn't really matter](https://www.gamersnexus.net/guides/2488-pci-e-3-x8-vs-x16-performance-impact-on-gpus) but it fundamentally bothers me so I only end up using one of the M.2's anyway.
- I have not looked into undervolting/underclocking. If you're not super keen on getting all the performance you could probably look into doing that.

# Let's Look At Some Graphs

## CPU and VRM Temps With The Different Configurations

Temps were logged using HWiNFO64, while transcoding the first hour of the Godfather Blu-Ray to x264.

Be mindful of the Y scale. I don't wanna make clickbait graphs, but they're easier to look at.

First, lets look at CPU temps:

![CPU Temps](https://lambdan.se/img/iZWpvyJN3P.png)

- The standard configuration comes uncomfortably close to the 95 C thermal throttle
- Flipping the case and adding a NF-A12x25 on the inside as exhaust in the top helps a little, should prevent it from hitting 95 C
- Adding one or two NF-A12x25 on top, like in a tophat, is ridiculously effective, even if you case isn't inverted. No chance for the CPU to go over 90 C.

Perhaps more important in a configuration like this are the VRM's however:

![VRM Temps](https://lambdan.se/img/4DDNn5ICko.png)

- Standard configuration is very uncomfortably warm, and it'll probably keep on going up if the test was longer. Not recommended for prolonged use.
- Inverting the case and adding a top exhaust fan on the inside helps, or at least slows the heating down.
- Adding NF-A12x25's as if they were in a tophat, is super effective. Notice here that the Inverted LNA test performs better than Standard Max RPM.
- Two NF-A12x25's is of course silly loud, but good lord it's a tornado.

## Fans Matter!

Something I tried early on was comparing the Noctua S12A fans to the A12x25 fans. I believe I had
two of them mounted externally (pseudo tophat, because I didn't have one yet), running at max RPM.

It's quite a difference:

![Fans](https://lambdan.se/img/AC9bV5nKmp.png)

The A12x25's are incredible. It's like you have a tornado in your room.

# Conclusion

3900X in a Ghost is possible on air, but you should really get a exhaust fan right above the motherboard, so you probably wanna get a tophat... but if you're getting a tophat anyway maybe you should look into getting a large tophat and going for liquid cooling instead.

I mean, you can do it on air, but I don't feel super comfortable leaving it on overnight to batch process video encodes. It's a little too warm for my taste.

# More Pictures

I know looking at SFF builds can be appealing, so here, have some more random pictures of my build in its various states:

![Thermal Paste](https://lambdan.se/img/TKtRNBWu5C.jpg)
<figcaption>Probably the absolute worst Thermal Paste application I have ever done. I pushed the tube and nothing came, and then suddenly it just poofed. After watching Gamers Nexus video on the matter, I really don't care though. It's gonna be a mess to clean though if I remove the cooler.</figcaption>

![Alpfenföhn Mounting Brackets](https://lambdan.se/img/6pq8ao5R46.jpg)
<figcaption>My Black Ridge mounting bars looked like this. I think they're different between revisions or something.</figcaption>

![12-Core sandwich](https://lambdan.se/img/a30lkfun09.jpg)
<figcaption>12-core sandwich. Yummy.</figcaption>

![F_Panel Extension](https://lambdan.se/img/o3YsUQ8Dgb.jpg)
<figcaption>The Strix B450-I comes with a little F_PANEL extension to make it easier to hook them up. Nice!</figcaption>

![Cable Management](https://lambdan.se/img/sVqtw9YRyk.jpg)
<figcaption>Pretty good cable management I think, considering I don't have custom cables.</figcaption>

![Top Exhaust](https://lambdan.se/img/Y2x0vNakC0.jpg)
<figcaption>With cable management that good, you can squueze in a NF-A12x25 in the top without a tophat.</figcaption>

![Tophat](https://lambdan.se/img/l8Xw5yFyGT.jpg)
<figcaption>My Tophat M box. I really don't like the Tophats to be honest. They're very flimsy and annoying to assemble.</figcaption>

![Tophat Grill Removed](https://lambdan.se/img/diptrZBAfk.jpg)
<figcaption>If you lift the grill up on my build right now, it looks like this.</figcaption>

![First Boot](https://lambdan.se/img/tRWBE5eJye.jpg)
<figcaption>I hate it when BIOS picks the wrong monitor.</figcaption>

![Battlestation](https://lambdan.se/img/wuuOmvxVS1.jpg)
<figcaption>Here's my battlestation writing this... but where's the computer?</figcaption>

![There it is!](https://lambdan.se/img/ujOlT84FPv.jpg)
<figcaption>Ah, there it is. Behind the monitor!</figcaption>

-------------------------------------

Thanks for reading.
