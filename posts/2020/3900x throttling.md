2021-05-09T20:37:00+02:00
# Power Limiting the 3900X

[After I sold my 3070](https://lambdan.se/blog/2021/05/02/high-end-pc-parts-a-burden-on-the-mind/) I've gone back to my Louqe Ghost case. Running the 3900X in here is possible, but it gets sweaty. Almost a bit too sweaty. 

I could maybe solve it by adding a tophat and some more fans, but I don't like the Ghost tophats. I want it to be as small as possible.

So instead I started looking into throttling the CPU. The 3900X is way too much power for me anyway, I don't need it all.

Limiting the PPT value in PBO settings seems to be what most people recommended from what little googling I did. To be frank, I'm not exactly sure what it does, but it seems to control how much power the CPU can slurp up. Lowering it = less lower = less heat.

So, knowing that I set out to test some values.

The goal is to reduce the CPU temperature. In turn, this also means lowering all other temperatures and having a quieter system.
Another aspect we need to monitor is how performance is affected.

My main method of testing was using Cinebench R23 and just doing a run of it (takes 10 minutes so the system has time to get heated up) and see how many points I get. 

I figured I should also do some game testing so I also started doing GTA V Benchmark runs which gives me numbers I can somewhat relate to.

The settings I tested were:

- Stock (PBO Disabled)
- PBO Enabled (Motherboard limits)
- 65 W PPT Limit
- 95 W PPT Limit
- 120 W PPT Limit

Ideally I would've tried every W possible but I didn't have the energy for that so I just did some incremental jumps. A lot of more "lower end" CPU's use 65 W so I figure that'd be a good number. The cooler I use is rated for 95 W TDP so I figured that could be a good number. 120 W was something more towards the high end but not quite the highest possible value (3900X goes around 140W by default).

The parts of my system are:

- Louqe Ghost S1 
- Asus B450-i Strix
- 32 GB Corsair LPX 3200 MHz
- MSI RX 570 8 GB
- Corsair SF600
- Alpenföhn Black Ridge w/ Noctua NF-A12x15 Fan
- Noctua NF-A12x25 exhaust fan

When I built this system originally I did write about it here: [Air-cooling Ryzen 3900X in a Louqe Ghost](https://lambdan.se/blog/2020/04/11/air-cooling-ryzen-3900x-in-a-louqe-ghost/) - I've changed some things though since then so it's not quite up-to-date.

----------------------

So let's look at some charts:

Starting off with temps, we can obviously see reducing the amount of power has a significant effect on temperatures:

![Temps](https://lambdan.se/img/2021-05-09_20-23-07.804893.png)

Of particular interest to me is the VRM temps, which gets scary hot with the stock settings. But the main interest is of course the CPU temperature where lower temperature means lower fan speed which means less noise!

So how does this affect performance? Let's look at the Cinebench points chart:

![Cinebench Points](https://lambdan.se/img/2021-05-09_20-23-03.149246.png)

Going down to 65 W has a significant reduction in performance, but even then, 12k points is nothing to sneeze at. It's still better than a lot of other popular CPUs, but it feels a bit silly for a 12-core CPU to be down in 6-core territory. 95 W gets a reasonable amount of points in my opinion, it's good enough for me, especially when taking into account how much cooler it runs.

A more fun way to look at these points and the temps, is to divide the points by CPU temperature which tells us what gives us most "bang for the buck":

![Bang for the buck](https://lambdan.se/img/2021-05-09_20-23-01.605497.png)

I apologize that I forgot to tidy up the label, but basically, we are looking at amount of points divided by the max temperature of the CPU. 95 W has a significant lead here which is what made it my favorite.

Now, Cinebench is more productivity oriented, so how about games? Well, let's take a look at the GTA V numbers: 

![GTA V](https://lambdan.se/img/2021-05-09_20-23-06.266324.png)

There is practically no difference. They're all in margin of error (made evident by the 120 W numbers). Perhaps I ran into a GPU bottleneck but that really just shows you I won't notice a difference in gaming performance.

---------------------

I'll be running my 3900X at 95 W PPT from now on. It runs cooler and quieter and fast enough for me. It's a reasonable setting for a CPU that resides in a shoebox underneath a low profile cooler.
