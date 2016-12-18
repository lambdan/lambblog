<?php
require 'helpers.php';

header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);


foreach($files as $txt) {
	echo '<url><loc>http://lambdan.se/?entry=' . get_display_filename($txt) . '</loc></url>';
}

// echo any additional urls you want here
echo '<url><loc>http://lambdan.se/rss</loc></url>';

echo '</urlset>';

?>
