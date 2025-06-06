2020-02-01T15:00:00+01:00
# macOS on AMD?!? (Ryzen 3900X Hackintosh Build)

What a time to be alive. I never thought it would be possible to run macOS on an AMD based system, but here we are.

![htop](https://lambdan.se/img/hackamd.png)

And perhaps more surprisingly, is that I think this was my smoothest Hackintosh ever.
Once I got everything set up exactly, according to [this guide](https://khronokernel-2.gitbook.io/opencore-vanilla-desktop-guide/), and I got the setup booted everything was smooth! 

I did have a problem getting ethernet to work. Turns out I was using the wrong `SmallTreeIntel82576.kext`. I downloaded the one linked in the guide and then it worked.

# Specs

- AMD Ryzen 3900X
- Aorus/Gigabyte X570 Elite
- 2x16 GB (32GB) Corsair Vengeance LPX 3200 MHz
- 500 GB Samsung 970 Evo NVME
- MSI RX 570 Armor OC 8GB
- Unimportant Parts: Fractal Design Define C, NZXT Kraken X62 (how do I control the Kraken without CAM? [I don't](https://github.com/lambdan/Setup/tree/master/Windows/NZXT%20Kraken%20Without%20CAM).)
- macOS Catalina 10.15.3, using OpenCore

# What Works

- GPU acceleration (RX 570 is natively supported, which is why I bought one specifically for this)
- Sound through rear headphone jack (haven't tested anything else)
- iCloud, App Store, iMessage 
	- The guide states you should use a serial number that is valid, but isn't in use, but I didn't. I just took a random one and made sure it wasn't valid and used that one, like I have with all my other hacks.
	- Using a valid, but not used, serial number feels icky because I think it gets messy if someone actually purchases that real Mac and registers it
- And basicallly everything else...?

# What Doesn't Work (that I've noticed)

- Sleep
	- Computer just hangs, you have to press the reset button or pull the power
- <s>NVMe Drives Show Up as External</s>
	- Managed to fix it [thanks to Reddit](https://www.reddit.com/r/hackintosh/comments/eye59t/everything_perfect_except_nvme_is_shown_as/?utm_source=share&utm_medium=ios_app&utm_name=iossmf)

# Benchmarks

## Geekbench

Here's [my Geekbench](https://browser.geekbench.com/v5/cpu/1128336):
![Geekbench](https://lambdan.se/img/Screenshot%202020-02-01%20at%2013.16.56.png)

On single core, it currently tops the [Mac charts](https://browser.geekbench.com/mac-benchmarks/), where the top was the 2019 27-inch iMac with the 9900K, scoring 1248 points. 

On multi-core it comes in right around the 12-core 2019 Mac Pro (11683 points, so it's margin of error).

## Cinebench

In Cinebench R20, I get about the same score I got in Windows, 6800 points. It's good.
![Cinebench](https://lambdan.se/img/Screenshot%202020-02-01%20at%2013.20.34.png)

# Snazzy Labs

Snazzy Labs video was what inspired me to finally buy a RX 570. I recommend his video to give you an general idea of what you are expected to do. It is mostly correct, but it glosses over many of the individual changes you need to make to your `config.plist`. 

So my recommendation is to first watch the video to see if this is something you wanna get into, and then once you decide to actually do it, read [the guide](https://khronokernel-2.gitbook.io/opencore-vanilla-desktop-guide/) very carefully. 

(Also, the SmallTreeIntel kext he links to was the one that didn't work for me.)

<div class="video-container"><iframe src="https://www.youtube.com/embed/l_QPLl81GrY" frameborder="0" allowfullscreen></iframe></div>

# Conclusion

So will I keep running this system? 

Yeah, I will. For now. Right now I have this PC as a dedicated Mac, and another PC dedicated for gaming. It's kinda nice to have 2 rigs, albeit messy.


-------------------

Update 2020-02-02: Confirmed iMessage works
<br>
Update 2020-02-04: Fixed the NVME drive showing up as external 
