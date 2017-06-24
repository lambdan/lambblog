<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>


<html>
<head>
<?php echo "<title>Archive - ${site_title}</title>"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo '<link rel="stylesheet" type="text/css" href="' . $css_url . '">'; ?>

<meta charset="utf-8">

</head>

<body>

<?php generateNavigation(); ?>

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
	print '<li><a href="./' . get_display_filename($txt) . '" style="text-decoration:none;">' . get_title($txt) . '</a> - ' . get_date($txt, "j M Y") . '</li>';
}

?>
</ul>
</div>
</body>
</html>
