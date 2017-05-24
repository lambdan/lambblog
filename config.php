<?php
date_default_timezone_set('Europe/Stockholm'); // timezone your times are in

$path_to_txts = './posts/'; // where your markdown files are stored

$site_root = 'https://lambdan.se'; // url root, do not end with /

$site_title = 'lambdan.se'; // displayed at end of <title> and used as title in rss/json feed

$navbar_title = '👌🏻'; // shown above links in the header/navbar. can also be  a <img>

$twitter_username = 'djs__'; // your twitter handle without @, leave blank to not use twitter cards

$css_url = $site_root . '/css.css'; // link to css file

$logo = 'https://lambdan.se/avatar.png'; // shown in footer

$feed_description = 'Blog posts by djs'; // shown in RSS and JSON feed

$image_mirror_root = 'https://lambdan.se/images/';
$image_mirror_root_path = './images/'; // path relative to where Parsedown.php is and is where images will be stored

// Default author stuff, shown in JSON Feed and maybe elsewhere in the future
$author_name = "djs";
$author_url = "https://twitter.com/djs__";
$author_avatar = "https://lambdan.se/avatar.png";

?>