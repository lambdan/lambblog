2019-07-29T20:12:00+02:00
# The Louqe Ghost S1 Build

Not very long ago I wrote [how I moved to a mini ITX case](https://lambdan.se/blog/2019/05/01/mitx-considered/). Now I am back to talk about the same subject because I moved into an even smaller case.

The Node 304 is a fine case, but it's pretty big and bulky for an ITX case. I had to make so many sacrifices to move down to ITX that I feel like I want it to be as small as possible.
So one late night when I was scrolling through Reddit and Twitter some Ghost builds showed up and I got very interested in them. I mean, I've seen this case many times before but I didn't really "care" too much about it. But I decided to read up on it and learned a lot about it's build quality and how the air is meant to move in it, and most importantly I learned that _Louqe_ is Swedish. 

So that late night, around 3 AM, I essentially decided on an impulse that I was gonna get this case.

# Preparations

To build in a Ghost you need to fit some requirements:

- mini ITX motherboard
- SFX power supply
- GPU length can be 305mm max (and not larger than dual-slot)
- CPU cooler can be 66mm max

3 of these were already fulfilled:

✅ I had a mini ITX motherboard from the Node 304, the _Gigabyte/Aorus Z390 I PRO WIFI_

✅ I had the SFX PSU from the Node 304, the _Corsair SF600 Platinum_

✅ My GPU is a Founders Edition, the _MSI GTX 1080 Ti Founders Edition_ which is compatible with almost everything

❌ But my CPU cooler was gonna be a problem. The _Noctua NH-U14S_ I was using is 165mm, which is enormous. 

So the hunt for a low-profile CPU cooler began. 

## Finding a CPU Cooler

Because the max height of the CPU Cooler in a Ghost S1 is 66mm you can either use low profile coolers or AIO's. I've always been using towers so this is new territory to me. 

An AIO watercooler would be an obvious choice because their performance tends to be very good and pretty quiet. But for a variety of reasons I don't want any liquid inside of my computers. You can tell me all day and all night how tight and leakfree they are but the possibility is there. I don't want that possibility of fluid leaking out and killing my entire computer.

I found this ["document"](https://www.louqe.com/files/heatsink_test_ghost_s1_MkII.pdf) that Louqe themselves provided where they tested a bunch of different air coolers. 

Since the _Noctua NH-L12_ was their favorite that immediately became my goal. Unfortunately I discovered relatively quickly that it was out of production and the only choice was hunting it down second hand. I researched some more and eventually ended up on the [_Sweclockers_ forum thread](https://www.sweclockers.com/forum/trad/1538722-louqe-ghost-s1-owners-club) for this case where the _Alpenföhn Black Ridge_ in combination with a _Noctua NF-A12x15_ fan was [recommended](https://www.sweclockers.com/forum/post/17955798). Both of those things were widely available to buy so I went with that combination. 

## Naked RAM

So I was all ready to order the Ghost S1 case, the Black Ridge and the Noctua fan, when I decided to double check, and I'm glad I did because I discovered the Black Ridge only supports RAM that is max 33mm tall. My _GSkill FlareX_ sticks were 38mm or something so this was gonna be a problem.

I was almost ready to order some new _Corsair Vengeance LPX_ sticks, going up to 32GB while I was at it, when someone on _Sweclockers_ gave me a tip to remove the heatspreaders on my current RAM, which I decided to try after some quick research telling me the heatspreaders are basically only there for marketing. All RAM would look the same otherwise. I also figured that if I break them I have legit reason to buy and upgrade to 32GB. 

Long story short: I removed the heatspreaders from my _FlareX_, no problemo:

![Naked RAM](https://lambdan.se/img/IMG_20190712_145224_1_.jpg)

My methodology was to do 1 stick at a time, and run _Memtest_ inbetween. I ran Memtest to heat up the sticks (to loosen the glue) and to test that I hadn't broken anything. 

Eitherway, this worked fine and my RAM would fit the Black Ridge, so I went ahead with the order. I went with the Limestone (Silver) color of the case, as I figured it would show dust and fingerprints less.

### Black Ridge Gotchas!

The Black Ridge has a lot of "make sure you think about this" things about it:

- RAM height (see above)
- Some motherboards are incompatible due to layout. If possible, try to find someone who has your motherboard and used this cooler. For my motherboard, I found this [build](https://www.reddit.com/r/sffpc/comments/bqmdi0/first_sff_build_8600k_49_using_a_black_ridge/). If I hadn't found that I'm not sure I'd risk buying it. 
- Your graphics card need to be connected through a riser, see this [picture](https://imgur.com/a/CjqQdRg)
- First batches had a major screw up with the quality control (the heatpipes weren't connected)

So if you're gonna get this cooler, make sure to do your research!

# Building

A couple of days later the parts showed up. My cousin wanted to see me building it though so I waited to build it until the weekend.

![Arrived](https://lambdan.se/img/IMG_20190717_161653.jpg)

You might think the building itself in a case like this would be the most interesting part, but no, it really isn't. It's pretty easy and straight forward to build in this thing so I don't really have a lot to comment on.

![Motherboard and cooler](https://lambdan.se/img/IMG_20190719_221928_1_.jpg)
![GPU Side](https://lambdan.se/img/IMG_20190719_231048_1_.jpg)
![CPU Side](https://lambdan.se/img/IMG_20190719_231109_1_.jpg)
![Above shot](https://lambdan.se/img/IMG_20190719_232410_1_.jpg)

(I had a screw misplaced which is why you see a really long regular screw above the GPU in some of the photos. I've since gone back and found the proper screw to use there.)

During the build it was a concern I would damage the PCI riser cable but it seems to be fine. I've really pushed it in there to make it as flat as possible so the grill on top won't budge out. 

The finished product looked like this: 

![A Ghost](https://lambdan.se/img/IMG_20190721_150035.jpg)

# Thermal Problems

Pretty much immediately I was pretty disappointed with the thermal performance of this build. The CPU cooler was loud and the CPU was hot. 

I immediately took it apart to try and re-apply the thermal paste to see if that made a diffrence. It didn't.

I got two recommendations: delid and/or undervolt. 

I decided to start with the undervolting because I've never had the guts to do a delid. Setting a fixed voltage was much easier. I jumped down to 1.20v, and tried to go lower but the PC got unstable, so I've ended up with 1.20v on the Vcore which I still use and it has been rock solid. This dropped temperatures by about 10 C.
This made the temperatures tolerable, especially while gaming.

I could leave it here, but of course I wouldn't. 

## Testing a Different Cooler

The next day I took it all out and tried all the CPU coolers and different fans I had that would go into this case and benchmarked them:

![Testing CPU coolers](https://lambdan.se/img/IMG_20190720_145820.jpg)

Sadly, none of them were better than the Black Ridge with the NF-A12x15 fan. I decided to try and use the _Noctua NH-L9i_ for a couple of days though, mostly for fun and because of compact and neat it is. 

You can run a not-delidded 8700K with a NH-L9i but I really wouldn't recommend it. 

![NH-L9i](https://lambdan.se/img/NH_L9i_cinebench.png)

As you can see, it hit 88 C after a run of Cinebench, which doesn't even use AVX. When I ran Prime95, which does use AVX instructions, we creeped up on 100 C. But sure, if you're not gaming you could get by with a _NH-L9i_ - it's surprisingly quiet.

I also ordered a _Noctua L9x65_ with the intention of making that my main cooler, especially since Noctua themselves says it's good enough for the _i9-9900K_. Ultimately I ended up canceling the order though, because I realized the Black Ridge would be better. But someday I might get a _L9x65_, I am a huge Noctua fanboy. 

It was time for the thing I had promised myself to never do.

## Delidding

I ultimately decided to delid my _8700K_. I was considering maybe getting a new CPU instead, like the _9900K_ which has a soldered IHS, but it's pretty damn expensive, and from the benchmarks I saw, the _8700K_ is still a very good CPU, especially for gaming. I would've loved to get the new _Ryzen 3000_ series, but then I would need a new motherboard too, so delidding my existing CPU seemed like the cheapest and most logical next step.

For a pretty good while I was pretty sure I was gonna send it in to this [danish guy](https://delid.dk/) who offers delidding as a service, and he seems really good at it. But I knew I would call myself a pussy if I didn't do it myself, so I ordered the _der8auer Delid Die Mate 2_ and some _Thermal Grizzly Condoctonaut_ liquid metal after watching a ton of YouTube videos about it and seeing how some people were very gentle and some were very rough, but in either case both succeeded with nice results. I felt confident I could do it. 

### Fresh GPU Thermal Paste

While waiting for the things to arrive, I "practiced" by applying new thermal paste to my GPU. This is far from as scary since I didn't use Liquid Metal and taking the FE cooler off is very easy. My _GTX 1080 Ti_ is over 2 years old anyway so the old thermal paste was pretty dried up. 

Putting some fresh _Noctua NT-H1_ on there didn't make a huge difference in raw performance: 

![Scores](https://lambdan.se/img/Superposition_1080p_Extreme_scores.png)

But where it made a huge difference was noise levels. The GPU fan goes down much faster when it cools down which makes it alot more pleasant, because these blower coolers are loud as heck by default.

Overall, swapping the GPU thermal paste was super easy and I am sure I will do it again. Maybe every year or so. 

### Actually Delidding

The things eventually arrived: 

![Things](https://lambdan.se/img/IMG_20190724_171534.jpg)

I just went right into it. I ran a quick session of Prime95 to heat up the CPU to make the thermal paste less gluey to make it easier to detach the cooler. 

Instead of taking the motherboard out of the Ghost, I instead removed the GPU and the riser cable (which is just held there by two screws, very easy to remove and put back), leaving the motherboard in place for this operation. I figured this is easier since you don't have to unplug as many things and fiddle with the PSU. And in practice, I do think it actually was easier! So this is the way I recommend doing it if you need to do something with your CPU cooler: remove your GPU and the riser instead of removing the motherboard.

Once I had the CPU out I did the actual delidding with the _der8auer_ tool, which was super easy. Then I started cleaning it and all that. I accidentally got some thermal paste on the contact points that goes to the motherboard but that went away with some rubbing alcohol.

What surprised me is how hard the original silicone or glue or whatever that is was stuck there. I didn't get rid of everything even though I rubbed alot and used alot of alcohol.

This was my first time using liquid metal, and yep, it is as scary and weird as everyone says. You can't really control it precisely, you just use the bundled Q-tips and be careful. I recommend squirting some on a piece of paper first to practice and to get rid of the initial "splat" that plagues these tubes of _Conductonaut_.

![LM](https://lambdan.se/img/IMG_20190724_180714.jpg)
![In socket](https://lambdan.se/img/IMG_20190724_181301.jpg)

I did not "relid" the CPU. The IHS is just held in place by the socket bracket thingy. Hopefully I'll remember this in the future when I remove the CPU.

So how about the results? 

![Delid results](https://lambdan.se/img/Delid_results.png)

The simple answer is: about 10 C better. I'm pretty sure I could get it even better if I put less LM on there. You can see in the pictures that I had quite the pool of LM on the IHS. Sure, I could retry but that could also make it worse so I'm just gonna leave it for now. 10 C better is enough for me for now.

Finally. I was happy with the CPU temps.

Also, when I ran the tests it was about 30 C in my room because we had an unusually warm week of July. Now that it's cooler again the temps are much better. Room temperature and ambient temperature makes a big difference in this case since it's pure aluminium, which brings me to my next section...

## Tophat?

Now that the CPU temps were pretty good and GPU temps were good enough, I still had a problem: the case just gets warmer, it never gets colder.

The neat thing about the Ghost is that you can expand it by adding these tophats, either to the top of it or the bottom. Most of the tests I've read said it made little difference adding a fan on top or the bottom, but I wanted to test it myself.

It was mainly the GPU that was the problem because it got hot and warmed up the rest of the case, and once the case was warm, it never got cold again until I shut it off. This is also worsened by the fact that the _Corsair SF600_ PSU is semi-passive, and it's really aggresively semi-passive, because the fan on it never spun when just the CPU was stressed, it was only when my GPU was also stressed it started spinning. This made the PSU very warm when just browsing the web and stuff, and it just stays warm since no fans were cooling it, thusly heating up the entire case and all the parts inside it. 

Why don't I compare the GPU temps then? Because the way my GPU works, it will just run as fast as it can until it hits 84 C, and then throttle down to cool down and then run full speed again until it hits 84 C and so on. This means that the max temperature was always 84 C which wouldn't really tell us much. But since Superposition will give us a score based on how fast the GPU is, that is much more useful. More points means the GPU could run below 84 C more often. 

Since I didn't already have the tophat (remember: I was doing this to decide whether or not I should get one), I just plopped 2 of the _Noctua NF-A12x25_ fans I had lying around on top of the case in both an exhaust configuration and intake configuration. It looked like this: 

![Fan testing](https://lambdan.se/img/IMG_20190726_153206_2_.jpg)

I actually kinda like the way it looks, but it's not very practical to move around the case. 

Anyway, here are the results:

![Superposition scores](https://lambdan.se/img/Superposition_1080p_Extreme_scores_1_.png)

- Without extra fans the first run gets a good score, then it gets progressively worse as everything just gets warmer and warmer
- When we have exhaust fans we get roughly the same score each run, which means our GPU can run at a nice and consistent level
- Flipping our fans to make them intakes is also interesting, because we get the best score of them all on the first run because it's extra cold then, but since the air isn't exhausted fast enough it gets warmer and warmer and results in worse and worse scores as time goes on

Ultimately my conclusion is that having exhaust fans helps, and the best thing is that the case itself never gets warm. It stays nice and cool all the time. Because of this I highly recommend adding some exhaust fans. 

CPU temps however are largely unaffected, we're talking 1 C here and there.

[Some people](https://www.youtube.com/watch?v=R5wFdMjlGoc) also have good experience putting a fan in the bottom as an exhaust, but I have been unable to try this as I don't have another slim fan that can go in there. With these 25mm fans I have the PSU cables get in the way. 

I'm pretty sure having an tophat with exhaust fans is gonna be better, atleast looking at raw numbers, but the big pro of just putting it in the bottom is that you don't need an ugly tophat making the case larger.
Eventually, I will get around to trying this. 

~~Based on this testing I've ordered an M sized Tophat and I will put my NF-A12x25's in it. If I didn't already have the fans I would've maybe gone for an S sized Tophat and use NF-A12x15's.~~

### Flipping It

Well, that was my plan until I decided to instead try "flipping" the whole case after reading a random comment on Reddit that suggested it, and then seeing another one try it and having positive results. 

This gives your CPU clear passage to the top grill so the hot air can get out instead of being trapped by the PCI riser. You can also squueze in an exhaust fan without having a tophat. And this works surprisingly well, as well as having the two exhaust fans on top. 

![Flipped 1](https://lambdan.se/img/IMG_20190730_201044.jpg)
![Flipped 2](https://lambdan.se/img/IMG_20190730_211444.jpg)

This is pretty perfect. Ideally I should get perfect length PSU cables and maybe some nicer zipties to hold the fan, or I could skip the zipties entirely and just let the fan lie there. It's so tight that it stays put. 


# Future

In the future I might look into getting perfect length PSU cables, because as it is right now the cables are a bit excessively long and it would be neater if they were shorter. You can buy these cables from [pslatecustoms](https://www.pslatecustoms.com/) but it's fairly expensive. They're handcrafted and you can pick your own colors so it's probably worth it though.

I'm also not fully sold on the Black Ridge cooler. It's fine, but it ain't Noctua. I just get a bad vibe from it. If Noctua makes a new low profile cooler I'm gonna be very interested. To be clear, performance wise the Black Ridge is fine, I am just a Noctua fanboy.

# Conclusion

Overall, the _Louqe Ghost S1_ is a very nice and neat case, and the community for it and all the SFF PC's are amazing. You can find individual forum threads for almost every case and then there is the [/r/sffpc](https://reddit.com/r/sffpc) subreddit if you wanna get some inspiration. 

I think it was easier to build in the Ghost than it was in the Node 304. This is because in the Node 304 pretty much everything was in the way of everything. But in this Ghost, since it's compartmentalized it's much easier to get around. 
For example, in the Node 304 if you'd want to swap out the CPU Cooler you'd have to remove everything except the PSU. In the Ghost you can just remove the GPU and the riser. 

If I had to complain about something with the Ghost it would be the lack of front I/O and the price.

Lack of front I/O is not a huge deal, because since it's so small you're likely to have it on your desk next to you anyway, and most monitors and some keyboards come with USB hubs nowadays. But it'd be nice if it even had just 1 USB port on the front. 

Then there's the price. I mean, _Louqe_ isn't a big company, I get that, but this case is around $300 (atleast over here). For $300 you could get another case and a motherboard. I can't really say that I feel like this case is worth $300. It feels nice and solid and all, but I'm not like "oooh this is why it's $300". 

But overall, yeah, it's a fun case to build in, and I'm happy to finally have a shoebox PC.

# Final Parts List
| |Model|Notes|
|-|-|-|
|Case|Louqe Ghost S1 (Limestone)||
|Motherboard|Gigabyte (Aorus) Z390 I PRO WIFI||
|CPU|Intel i7-8700K|Delidded, runs at 1.2V, stock speeds|
|CPU Cooler|Alpenföhn Black Ridge + NF-A12x15|default Black Ridge fan removed|
|RAM|GSkill FlareX 2x8 GB 3200MHz|Heatspreaders removed|
|GPU|MSI GTX 1080 Ti FE|Thermal paste replaced|
|PSU|Corsair SF600 Platinum||
|SSD 1 (M.2 NVMe)|Samsung 970 Evo 500GB|My C: drive|
|SSD 2 (M.2 NVMe)|Intel 660p 2 TB||
