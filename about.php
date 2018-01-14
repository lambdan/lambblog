<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>


<html>
<head>
<title>About - <?php echo $site_title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>">
<?php faviconHeaders(); ?>
<meta charset="utf-8">

</head>

<body>

<?php generateNavigation(); ?>

<div class="article">
    <h1>About</h1>
<p>   Most other blogs have an about page so I have one too, but I'm not really sure what to put here...</p>

<h1>Me Elsewhere</h1>
<ul>
<li>Twitter: <a href="https://twitter.com/djs__" style="font-family:monospace;letter-spacing:2px;">@djs__</a> (this is is also in the header of my blog, and there are two underlines (that's why I used a monospace font))</li>
<li>Last.fm: <a href="https://last.fm/user/djs_">djs_</a> (if you wanna see what music I listen to. I take scrobbling very seriously so it should be pretty accurate.)</li>
<li>Youtube: <a href="http://youtube.com/user/pipdjs">pipdjs? DJS?</a> (that old url with my original username still works, but I have no idea for how long)</li>
<li>Twitch: <a href="http://twitch.tv/lambdan">lambdan</a> (fun fact: I almost streamed creating this page)</li>
<li>Whatpulse: <a href="http://whatpulse.org/lambdan">lambdan</a>
<li>Github: <a href="https://github.com/lambdan">lambdan</a> (lots of crap there, this blogging engine to name one)
</ul>


<h1>Feeds</h1>
<p>
RSS: <a href="https://lambdan.se/rss.php">/rss.php</a>
<br>
JSON Feed: <a href="https://lambdan.se/feed.json">/feed.json</a>
</p>
</div>
<footer>
<p>Running on <a href="https://github.com/lambdan/lambblog">lambblog</a></p>
<img class="logo" src="<?php echo $logo;?>">
</footer>
</body>
</html>
