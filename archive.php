<?php
require 'Parsedown.php';
require 'helpers.php';
?>


<html>
<head>
<title>Archive - lambdan.se</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="http://lambdan.se/css.css">

<meta charset="utf-8">

</head>

<body>
	<div class="navigation">
	<h1><a href="." class="logo">lambdan.se</a></h1>
	<p>Archive ... <a href="rss.php">RSS</a> ... <a href="https://twitter.com/djs__">Twitter</a></p>
	</div> 
	<h1>Archive</h1>

<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

echo '<p>There are ' . count($files) . ' posts.</p>';

// List them
$prevMonth = "";
foreach($files as $txt) {
	$currMonth = get_date($txt, "F Y");
	if ($currMonth != $prevMonth) {
		print "<h2>" . $currMonth . "</h2>";
		$prevMonth = $currMonth;
	}
	print '<li><a href="index.php?entry=' . get_display_filename($txt) . '" style="text-decoration:none;">' . get_title($txt) . '</a> - ' . get_date($txt, "j M Y") . '</li>';
}

?>

</body>
</html>
