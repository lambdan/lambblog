<?php
date_default_timezone_set('Europe/Stockholm'); // timezone your times are in

$path_to_txts = './posts/'; // where your markdown files are stored

$site_root = 'https://lambdan.se'; // url root, do not end with /

$copyright_start = 2012; // copyright start year

$author_email = 'david@lambdan.se'; // your email, displayed in footer

$site_title = 'lambdan.se'; // displayed at end of <title> and used as title in rss/json feed

$twitter_username = 'nadbmal'; // your twitter handle without @, leave blank to not use twitter cards

$css_url = $site_root . '/css-night-2018.css'; // link to css file

$linkedSymbol = '📍';

$logo = 'https://lambdan.se/avatar.png'; // shown in footer

$feed_description = 'Blog posts by djs'; // shown in RSS and JSON feed

$image_mirror_root = 'https://lambdan.se/images/';
$image_mirror_root_path = './images/'; // path relative to where Parsedown.php is and is where images will be stored

// Default author stuff, shown in JSON Feed and maybe elsewhere in the future
$author_name = "djs";
$author_url = "https://twitter.com/nadbmal";
$author_avatar = "https://lambdan.se/avatar.png";

?>
