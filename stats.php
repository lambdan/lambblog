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
faviconHeaders();
// Set title of post to <title> if possible
if(isset($_GET['i'])) {
	$entry = $_GET['i'];
	$filename = file_from_url($entry, $path_to_txts);
	echo '<title>Stats: ' . get_title($filename) . ' - ' . $site_title .'</title>';
} else {
	echo '<title>Stats - ' . $site_title . '</title>';
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo $css_url; ?>">

<meta charset="utf-8">

</head>

<body>
<?php generateNavigation(); ?>
<div class="article">
<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

if(isset($_GET['i'])) { // Stats for specific entry
	// Read text file for that entry
	$entry = $_GET['i'];
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
	echo '<h1>Stats for: <a href="./' . get_display_filename($filename) . '" style="text-decoration:none;">' . get_title($filename) . '</a></h1>';

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
    echo '<h1>Blog Stats</h1>';
    echo '<ul>';
    echo '<li>' . count($files) . ' entries</li>';

	$post_word_counts = array();
	$total_words = 0;
	$total_characters = 0;
	foreach($files as $filename) {
		$Parsedown = new Parsedown();
		$html_text = $Parsedown->text(get_text($filename));
		$words = str_word_count(strip_tags($html_text));
		$chars = strlen(strip_tags($html_text));

		$total_words = $total_words + $words;
		$total_characters = $total_characters + $chars;
		$post_name = get_title($filename);
		$post_word_counts[$filename] = $words; // add to array with title as key
	}
    
	echo '<li>Words in total: ' . $total_words . '</li>';
	echo '<li>Characters in total: ' . $total_characters . '</li>';
	echo '</ul><h1>Posts With Most Words</h1><ol>';
	$i = 0;
	natsort($post_word_counts);
	$post_word_counts = array_reverse($post_word_counts, false);
	foreach($post_word_counts as $filename => $words) {
		if ($i < 20) {
			echo '<li><a href="./' . get_display_filename($filename) . '" style="text-decoration:none;">' . get_title($filename) . '</a> = ' . $words . ' words <a href="stats?i=' . get_number($filename) . '" style="text-decoration:none;">(stats)</a></li>';
			$i++;
		} else {
			break;
		}
	}
	echo '</ol>';


}

echo '</div>';

?>

</body>
</html>
