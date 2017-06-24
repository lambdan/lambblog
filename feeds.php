<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>


<html>
<head>
<title>Feeds - <?php echo $site_title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo $css_url;?>">

<meta charset="utf-8">

</head>

<body>

<?php generateNavigation(); ?>

<div class="article">

<ul>
<li><a href="rss.php">RSS</a></li>
<li><a href="feed.json">JSON Feed</a> (I recommend this one if you have the option)</li>
</ul>


</div>
</body>
</html>
