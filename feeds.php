<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>


<html>
<head>
<title>Feeds - lambdan.se</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://lambdan.se/blog/css.css">

<meta charset="utf-8">

</head>

<body>
	<div class="navigation">
	<p><a href="." class="logo">lambdan.se</a><br><a href="archive.php">Archive</a> • <a href="stats.php">Stats</a> • <a href="feeds.php">Feeds</a> • <a href="https://twitter.com/djs__">Twitter</a> • <a href="about.php">About</a></p>
    </div> 
<div class="article">
	<h1>Feeds</h1>

<ul>
<li><a href="rss.php">RSS</a></li>
<li><a href="feed.json">JSON Feed</a></li>
</ul>

</div>
<footer>
<br><img class="logo" src="https://lambdan.se/avatar.png">
</footer>
</body>
</html>
