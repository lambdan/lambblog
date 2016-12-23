<?php
require 'Parsedown.php';
require 'helpers.php';
?>
<html>
<head>

<?php
// Set title of post to <title> if possible
if(isset($_GET['entry'])) {
	$entry = $_GET['entry'];
	$filename = file_from_url($entry, $path_to_txts);
	echo '<title>' . get_title($filename) . ' - lambdan.se</title>';
} else {
	echo '<title>lambdan.se</title>';
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="http://lambdan.se/css.css">
<link rel="alternate" type="application/rss+xml" title="RSS" href="http://lambdan.se/rss.php" />

<meta charset="utf-8">

</head>

<body>
	<div class="navigation">
	
	<p><a href="." class="logo">lambdan.se</a> • <a href="archive.php">Archive</a> • <a href="stats.php">Stats</a> • <a href="rss.php">RSS</a> • <a href="https://twitter.com/djs__">Twitter</a></p>


<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);
?>

</div>
<?php

// Maybe show one?
if(isset($_GET['entry'])) {
	$entry = $_GET['entry'];
	$filename = file_from_url($entry, $path_to_txts);
} else {
	$filename = $files[0]; // latest entry if nothing is requested
}

if (file_exists($filename)) {
	echo '<h1 class="article_title">' . get_title($filename) . '</h1>';
	echo '<h2 class="article_date"><a href="?entry=' . get_display_filename($filename) . '">' . get_date($filename, "j M Y H:m") . '</a></h2>';
	echo '<div class="article">';
	$Parsedown = new Parsedown();
	echo $Parsedown->text(get_text($filename));
	echo '</div>';

	// Footer
	echo '<footer><ul>';
	echo '<li><a href="stats.php?entry=' . get_display_filename($filename) . '">Stats For This Post</a></li>';

	$curr = get_number($filename);

	// We would just do $curr-1 and $curr+1 for previous/next, but if you remove a blog post that wont work
	$i = 1;
	$prev = file_from_url($curr - $i, $path_to_txts);
	while(!file_exists($prev)) {
		if ( ($curr-$i) < 0 ) {
			break;
		}
		$i++;
		$prev = file_from_url($curr - $i, $path_to_txts);
	}

	$i = 1;
	$next = file_from_url($curr + $i, $path_to_txts);
	while(!file_exists($next)) {
		if ( ($curr+$i) > get_number($files[0]) ) {
			break;
		}
		$i++;
		$next = file_from_url($curr + $i, $path_to_txts);
	}

	if (file_exists($next)) {
		print '<li>Next: <a href="?entry=' . get_display_filename($next) . '">' . get_title($next) . '</a>';
	}

	if (file_exists($prev)) {
		print '<li>Previous: <a href="?entry=' . get_display_filename($prev) . '">' . get_title($prev) . '</a>';
	}
} else {
	echo '<h3>Not found</h3>';
	echo '<p>The post you wanted to see was not found. It has probably been removed or you changed the entry value in the URL to be invalid.</p>';
	echo '<footer><ul>';
}

echo '<li><a href="archive.php">Archive</a>';

echo '</ul></footer>';


?>

</body>
</html>
