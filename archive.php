<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>


<html>
<head>
<title>Archive - lambdan.se</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="https://lambdan.se/css.css">

<meta charset="utf-8">

</head>

<body>
	<div class="navigation">
	<p><a href="." class="logo">lambdan.se</a><br><a href="archive.php">Archive</a> • <a href="stats.php">Stats</a> • <a href="rss.php">RSS</a> • <a href="https://twitter.com/djs__">Twitter</a></p>
    </div> 
<div class="article">
	<h1>Archive</h1>

<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

// List them
$prevMonth = "";
foreach($files as $txt) {
	$currMonth = get_date($txt, "F Y");
	if ($currMonth != $prevMonth) {
		print "</ul><h2>" . $currMonth . "</h2><ul>";
		$prevMonth = $currMonth;
	}
	print '<li><a href="index.php?entry=' . get_display_filename($txt) . '" style="text-decoration:none;">' . get_title($txt) . '</a> - ' . get_date($txt, "j M Y") . '</li>';
}

?>
</ul>
</div>
<footer>
<?php
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('Page generated in %.3f seconds', $totaltime);
?>

<br><img class="logo" src="https://lambdan.se/avatar.png">
</footer>
</body>
</html>
