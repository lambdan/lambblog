2019-03-02T23:07:00+01:00
# Migrating out of iCloud (2019)

There is a very slight possibility that I might be trying out an Android phone soon, so I wanted to move my stuff out of iCloud. I figured it's easy to use iOS with Google stuff, but it's hard to use Android with iCloud stuff.
This is kinda nice even if you're not gonna potentially switch to Android, as I find Google's web apps alot better than Apples. And Googles stuff is probably supported better elsewhere too, like the built-in apps in Windows and such.

_Google Photos_ has way better search too. I find it infinetely better than Apple's version. Although, with Google your searches are done on the server side and Google probably learns alot from your photos. With Apple it's done on device and they don't know anything. 

I already use Gmail for my email so that was easy, I didn't have to do anything. I believe you can still use iCloud Mail on Android by just setting it up manually as an IMAP account, so even if I did use iCloud Mail that probably wouldn't have been a problem.

I also had bookmarks in Safari, but I sync those on my Windows PC using Google Chrome (where I've logged into my Google account and enabled syncing) and the iCloud Control Panel + extension for Chrome. This syncs bookmarks back and forth.

I never use Reminders, I usually just write up stuff I need to remember in Notes, so I didn't have to bother with Reminders. So if you want to move your Reminders I can't help you there.

But I do use Calendar, Contacts, Notes and Photos on iCloud. How do I move these? 
Well, first you need to decide where you're gonna move them.

For me, I chose these:

- Calendar -> Google Calendar
- Contacts -> Google Contacts
- Notes -> Simplenote
- Photos -> Google Photos

Here's how I did the migrations in early 2019. I wouldn't be surprised if the steps change as time goes on, so that's why I've included the date of when I did this.

## Calendar -> Google Calendar

I learned this from the [Apple Community Forums](https://discussions.apple.com/thread/4824115). I should warn you that this makes your calendar public for a few seconds. It shouldn't be a risk, but technically someone could guess a ~100 character URL during these seconds and get your calendar.

- Go on _icloud.com_ in a desktop web browser and go into Calendar
- Select your calendar, and hit the Share button (kinda looks like a sideways Wifi signal strength icon)
- Share your calendar publicly and copy the URL that starts with `webcal://`
- Change `webcal://` to `http://` and go to that page
- You will download a `.ics` file of your calendar. Go ahead and make your Calendar not public again. 
- (If you have more than one calendar you wanna export, repeat the steps)
- Go on _Google Calendar_ in a browser on your Desktop
- In the sidebar you'll find a 3-dot menu, and in it there's a Import option
- On the Import page you'll choose the `.ics` file(s) you downloaded earlier, and import it/them to your Google Calendar.

Once they're imported and they show up on Google Calendar, feel free to remove your calendars from iCloud and disable iCloud Calendar syncing on your iOS devices.

## Contacts -> Google Contacts

This one is very easy.

- Go on _icloud.com_, and go into Contacts.
- In the bottom left, you'll find a cog icon. Click it and first select "Select All", and then select the export Vcard option.
- You'll get a Vcard file downloaded that you can import into a lot of apps that use Contacts
- Go on _Google Contacts_
- In the left sidebar, under More you'll find a import option
- Select the Vcard file you got earlier and import it

Once they're imported and they show up in Google Contacts, feel free to remove your contacts from iCloud and disable iCloud Contacts syncing on your iOS devices.

## Notes -> Simplenote

This one is gonna be very annoying, depending on how many Notes you wanna sync. I just moved over the most important ones. 97% of my Notes are one liners of just random thoughts in my head, I didn't move those.

I was planning to move my notes to Google, as iOS lets you sync notes via Google, but I have no idea where to find the web app for Google notes, so I decided to move to [Simplenote](https://simplenote.com/). Before I used iCloud Notes, I used Simplenote, I decided to just move back there. Their apps are very fast and so is their web app, and it's free. **[They don't encrypt your notes in storage](https://simplenote.com/help/#encryption) though**, which is kind of weird. **They do however encrypt it while in transit**, so I'll roll with it for now. But if you have some very sensitive data, you might not wanna store it there.
If it's a dealbreaker for you, I also found [Standard Notes](https://standardnotes.org/) which seems alot better in that aspect, but costs money on a regular basis. 

Anyway, the idea is basically to just open up Apple Notes and Simplenotes side-by-side. You can do this either on a computer with two web browser windows, or on your iPad with the two apps side-by-side. I suppose you can do it on your phone too, but you have to go back and forth between the apps, very annoying if you ask me.

Eitherway, just select a note, select all the text, copy, and paste it in the other app in a new note. Repeat for all the notes you wanna copy. 

It's pretty easy, but might be annoying if you have a ton of notes you wanna move over. 
I had about 5 of them, so it wasn't very annoying.

## Photos -> Google Photos

This one takes a couple of hours or days, maybe weeks. But it's pretty simple. 

Just install the _Google Photos_ app on your iOS device (I used my iPad), log into the Google account you wanna use, pick if you wanna use Original quality (fills your Google storage) or just High-quality (doesn't fill up your Google storage, in another word: free), and just let it start uploading the photos.

If you want to speed it up, plug in the charger and just let the app be open.

Once all your Google photos are uploaded, I suppose you can go ahead and disable iCloud Photos sync on your devices and remove all the photos from the Photos.app (or let the Google app do it for you). I haven't tried this yet though, because I am waiting for it to upload all the photos still. 

# What About All the Other Apps?

The reason why I decided it is possible for me to migrate over, is because I am already pretty cross platform!

- Music: [Spotify](https://spotify.com)
- Passwords: [1Password](https://1password.com/) - here I am very thankful for switching to the subscription plan as I don't have to re-buy any apps!
- 2-Step Authentication: [Authy](https://authy.com/)
- File Storage: [Dropbox](https://www.dropbox.com/) (although I might switch to Google Drive eventually)

Then there's stuff like [Overcast](https://overcast.fm/) which I use for podcats. But surely I can find a good alternative on Android... if I end up switching. I honestly kinda doubt I will, but I haven't been this Android positive ever before. I'll give it a go for a week for sure.

