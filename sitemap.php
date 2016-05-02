<?php
require 'config.php';
require_once 'resources/getPostData.php';
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
  
        $dir = 'posts/';
        $content = array_diff(scandir($dir), array('..', '.', '.htaccess'));
        natcasesort($content); // Sort content
        foreach (array_reverse($content) as $c) {
            $number = preg_split("/[\s,.]+/", $c);
            $path = $dir . $c;
            echo '<url><loc>' . getPostData($path, "link") . '</loc></url>';
        }

        echo $additionalSitemap;

        echo '</urlset>';
?>
