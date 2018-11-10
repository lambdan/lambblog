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

<h1>Contact Me</h1>
<ul>
	<li>If you wanna contact me, use <a href="https://twitter.com/nadbmal">Twitter</a></li>
	<li>This should also work: <a href="mailto:david@lambdan.se">david@lambdan.se</a></li>
</ul>

<h1>Me Elsewhere</h1>
<ul>
<li>Twitter: <a href="https://twitter.com/nadbmal">nadbmal</a></li>
<li>Last.fm: <a href="https://last.fm/user/djs_">djs_</a></li>
<li>Youtube: <a href="http://youtube.com/user/pipdjs">DJS</a></li>
<li>Twitch: <a href="http://twitch.tv/lambdan">lambdan</a></li>
<li>Whatpulse: <a href="http://whatpulse.org/lambdan">lambdan</a>
<li>Github: <a href="https://github.com/lambdan">lambdan</a>
</ul>


<h1>Feeds</h1>
<ul>
<li><a href="https://lambdan.se/rss.php">RSS</a>
<li><a href="https://lambdan.se/feed.json">JSON Feed</a>
</ul>

<p>
Blog powered by <a href="https://github.com/lambdan/lambblog">lambblog</a>
<br>
</p>
</div>
<footer>
	<?php
echo '<footer>';
generateCopyrightFooter();
echo '</footer>';
?>
</footer>
</body>
</html>
