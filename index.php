<?php
if (isset($_GET['entry'])) {
	header('Location: ' . 'post.php?entry=' . $_GET['entry']);
	die();
}

require 'Parsedown.php';
require 'helpers.php';



?>
<html>
<head>

<?php

faviconHeaders();
// Set title of post to <title> if possible
if(isset($_GET['entry'])) {
	$entry = $_GET['entry'];
	$filename = file_from_url($entry, $path_to_txts);
	echo "<title>" . get_title($filename) . " - ${site_title}</title>";

    // Twitter card
    if ($twitter_username != "") {
	    echo '<meta name="twitter:card" content="summary" />';
	    echo '<meta name="twitter:site" content="@' . $twitter_username .'" />';
	    echo '<meta name="twitter:title" content="' . get_title($filename) . '" />';
	    $summary = get_summary($filename);
        echo '<meta name="twitter:description" content="' . $summary . '" />';
    }
} else {
	echo '<title>' . $site_title . '</title>';
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
echo '<link rel="stylesheet" type="text/css" href="' . $css_url. '">
<link rel="alternate" type="application/rss+xml" title="RSS" href="' . $site_root .'/rss.php" />
<link rel="alternate" title="JSON Feed" type="application/json" href="' . $site_root .'/feed.json" /> ';
?>

<meta charset="utf-8">

</head>

<body>

<?php
generateNavigation();
?>
<div class="normal">

<?php

// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);


$i = 0;
if (count($files) >= 5) {
	$max = 5;
} else {
	$max = (count($files));
}
while ($i < $max) {
$filename = $files[$i];
	
	if (file_exists($filename)) {
   	 echo '<a href="./' . get_display_filename($filename) . '">';
    if (isLinked($filename)) {
        echo '<h1 class="article_title_linked"><a href="' . linkedURL($filename) . '">' . $linkedSymbol . ' ' . get_title($filename) . '</a>';
    } else {
        echo '<h1 class="article_title">' . get_title($filename) . '</h1>';
    }
    echo '<h2 class="article_date">' . get_date($filename, "j M Y H:i") . '</a></h2>';


	$Parsedown = new Parsedown();
	echo $Parsedown->text(get_summary_frontpage($filename));
	}
$i++;
}

?>
<hr>
<p>The rest are in the <a href="archive">archives</a>...</p>
</div>
<?php
echo '<footer>';
generateCopyrightFooter();
echo '</footer>';
?>
</body>
</html>
