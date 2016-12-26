<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];

// Words to filter out
$common_words = array("an","and","the","this","at","in","or","of","is","for","to","it","you","me","my","on","that","but","me","as","so","quot","th","td","-","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
?>
<html>
<head>

<?php
// Set title of post to <title> if possible
if(isset($_GET['entry'])) {
	$entry = $_GET['entry'];
	$filename = file_from_url($entry, $path_to_txts);
	echo '<title>Stats: ' . get_title($filename) . ' - lambdan.se</title>';
} else {
	echo '<title>Stats - lambdan.se</title>';
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="http://lambdan.se/css.css">
<link rel="alternate" type="application/rss+xml" title="RSS" href="http://lambdan.se/rss.php" />

<meta charset="utf-8">

</head>

<body>
	<div class="navigation">
	<p><a href="." class="logo">lambdan.se</a> • <a href="archive.php">Archive</a> • Stats • <a href="rss.php">RSS</a> • <a href="https://twitter.com/djs__">Twitter</a></p>
</div>

<div class="article">
<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

if(isset($_GET['entry'])) { // Stats for specific entry
	// Read text file for that entry
	$entry = $_GET['entry'];
	$filename = file_from_url($entry, $path_to_txts);
	if (!file_exists($filename)) {
		echo '<p>I could not find that post.</p>';
		echo '<footer><ul><a href="archive.php"><li>Archive</a></li></ul></footer>';
		die();
	}

	// HTML version
	$Parsedown = new Parsedown();
	$html_text = $Parsedown->text(get_text($filename));

	// Print out title
	echo '<h1>Stats for: <a href="index.php?entry=' . get_display_filename($filename) . '" style="text-decoration:none;">' . get_title($filename) . '</a></h1>';

	// Words
	echo '<p>Words in total: ' . str_word_count(strip_tags($html_text)) . '</p>';
	echo '<h3>Most Used Words</h3><ol>';
	$word_counts = array_count_values(str_word_count(strip_tags(strtolower($html_text)), 1));
	natsort($word_counts);
	$word_counts = array_reverse($word_counts, false); // reverse to get top 10
	$i = 0;
	foreach ($word_counts as $word => $occurences) {
		if ($i < 10) {
			echo '<li><b>' . $word . '</b> = ' . $occurences . ' occurences</li>';
			$i++;
		}
	}
	echo '</ol>';

	// Excluding common words and some html mumbo jumbo
	echo '<h3>Most Used Words (excluding common words)</h3><ol>';
	$i = 0;
	foreach ($word_counts as $word => $occurences) {
		if ($i < 10) {
			if (!in_array($word, $common_words)) {
				echo '<li><b>' . $word . '</b> = ' . $occurences . ' occurences</li>';
				$i++;
			}
		}
	}
	echo '</ol>';


} else { // Global stats
	echo '<h1>Stats</h1>';
	echo '<p>There are ' . count($files) . ' posts.</p>';

	$post_word_counts = array();
	$total_words = 0;
	foreach($files as $filename) {
		$Parsedown = new Parsedown();
		$html_text = $Parsedown->text(get_text($filename));
		$words = str_word_count(strip_tags($html_text));

		$total_words = $total_words + $words;
		$post_name = get_title($filename);
		$post_word_counts[$filename] = $words; // add to array with title as key
	}

	echo '<p>Words in total: ' . $total_words . '</p>';
	echo '<h2>Posts With Most Words</h2><ol>';
	$i = 0;
	natsort($post_word_counts);
	$post_word_counts = array_reverse($post_word_counts, false);
	foreach($post_word_counts as $filename => $words) {
		if ($i < 10) {
			echo '<li><b><a href="index.php?entry=' . get_display_filename($filename) . '" style="text-decoration:none;">' . get_title($filename) . '</a></b> = ' . $words . ' words <a href="stats.php?entry=' . get_display_filename($filename) . '" style="text-decoration:none;">(stats)</a></li>';
			$i++;
		} else {
			break;
		}
	}
	echo '</ol>';


}

echo '</div>';
echo '<footer>';
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
printf('<p>Page generated in %.3f seconds', $totaltime);
echo '<br>Running on <a href="https://github.com/lambdan/lambblog">lambblog</a></p>';
echo '</footer>';


?>

</body>
</html>
