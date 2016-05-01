<?php

// Root URL for blog, ex. http://yourpage.com/blog
$rootURL = "http://lambdan.se";

// Copyright name (displayed in the footer)
$copyrightName = "DJS";

// Folder with all markdown .txt files
$dir = 'posts/';

// <title> suffix
$titleSuffix = " - lambdan.se";

// Title of page/brand name. Showed on navbar to the left and is clicked to go to $rootURL
$brandName = "lambdan.se";

// How many posts to show on index.php?
$postsOnPage = 5;

// RSS feed <description>
$rssDescription = 'Blog posts by David. Visit http://lambdan.se';

// Twitter usename. Skip the @
$twitterUsername = 'djs__';

// Path to About page's markdown .txt
$aboutTextPath = "about_text.txt";

// Placeholder image. Will be used to Twitter card if there isn't a image in your post.
$placeholderImage = "http://lambdan.se/placeholder.png";

// Custom CSS file. Included after bootstrap, so you can modify bootstrap.
$customBootstrapCSS = 'http://lambdan.se/customBootstrap.css';

// Text/symbol for a linked post. Shows in <title> and Archive
$linkedSymbol = '> ';

// Navbar dropdown menu
$navDropdownMenu = '
<li><a href="http://lambdan.se/ps4settings">PS4 Equivalent Settings for PC Games</a></li>
<li><a href="http://lambdan.se/d/tvesti">TV Show Intro Size Estimator</a></li>
 
<li role="separator" class="divider"></li>

<li><a href="http://kus-oge.com/">kus-oge</a></li>
<li><a href="http://rhythmgameslive.com/">RhythmGamesLive</a></li>
';

// Additional sitemap entries. All blog posts are automatically added
$additionalSitemap = '
<url><loc>http://lambdan.se</loc></url>
<url><loc>http://lambdan.se/about</loc></url>
';

// Local dir where compressed images will be saved. Make sure to end with /
$compressDestination = '/home/djs/public_html/compressimg/';
// URL to that dir. Make sure to end with /
$compressURL = 'http://lambdan.se/compressimg/';

// Local dir where mirorred images will be saved. Make sure to end with /
$mirrorDestination = '/home/djs/public_html/img/mirrors/';
// URL to that dir. Make sure to end with /
$mirrorURL = 'http://lambdan.se/img/mirrors/';


// Page descriptions for Twitter cards
// Index page
$indexDescriptionTwitter = 'Home of lambdan.se';

// Archive
$archiveDescriptionTwitter = 'All Posts on lambdan.se';

// About
$aboutDescriptionTwitter = "About lambdan.se and the guy who runs it";

?>