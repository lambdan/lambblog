<?php
require 'Parsedown.php';
require 'helpers.php';

if (isset($_GET['view_raw'])) {
	$filename = file_from_url(intval($_GET['view_raw']), $path_to_txts);
	header('Content-type: text/plain');
	if(file_exists($filename)) {
		echo file_get_contents($filename);
	} else {
		echo "not found";
	}
	die();
}

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

// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

// Maybe show one?
if(isset($_GET['entry'])) {
	$entry = $_GET['entry'];
	$filename = file_from_url($entry, $path_to_txts);
} else {
	$filename = $files[0]; // latest entry if nothing is requested
}

if (file_exists($filename)) {
	if ( substr($_SERVER['REQUEST_URI'], -5) == ".text")  {
		header("Location: post.php?view_raw=" . get_number($filename));
		die();
	}
    echo '<div class="article">';
    if (isLinked($filename)) {
        echo '<h1 class="article_title_linked"><a href="' . linkedURL($filename) . '">' . $linkedSymbol . ' ' . get_title($filename) . '</a>';
    } else {
        echo '<h1 class="article_title">' . get_title($filename) . '</h1>';
    }
    echo '<h2 class="article_date"><a href="./' . get_display_filename($filename) . '">' . get_date($filename, "j M Y H:i") . '</a></h2>';


	$Parsedown = new Parsedown();
	echo $Parsedown->text(get_text($filename));
	echo '</div>';

	// Footer
	echo '<footer>';

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
        //print 'Next: <a href="./' . get_display_filename($next) . '">' . get_title($next) . '</a><br>';
        print '<a href="./' . get_display_filename($next) . '">Next</a>';
    }


echo '<a href="stats?i=' . get_number($filename) . '">Stats</a>';



	if (file_exists($prev)) {
        //print 'Previous: <a href="./' . get_display_filename($prev) . '">' . get_title($prev) . '</a><br>';
        print '<a href="./' . get_display_filename($prev) . '">Previous</a>';
	}
} else {
    echo '<div class="article"><h3><font color="red">Not found</h3>';
    echo 'Entry: ' . $_GET['entry'];
    echo '</font><p>The post you wanted to see was not found. It has probably been removed or you changed the entry value in the URL to be invalid.</p>';
    echo '<p>There is a also a very slim possibility I added a new post and you or your feed reader managed to view/cache my blog before I managed to view the <a href="archive">Archive</a> page in order to refresh and add the post. (The risk of this happening is very low, so if it does happen please let me know... Seriously, we are talking like a 5 second window here.)</p>';
	echo '</div><footer>';
}
echo '</footer>';


?>

</body>
</html>
