<?php
require 'Parsedown.php';
require 'helpers.php';

$feed = array();

$feed['version'] = 'https://jsonfeed.org/version/1';
$feed['title'] = $site_title;
$feed['home_page_url'] = $site_root;
$feed['feed_url'] = $site_root . '/feed.json';
$feed['description'] = $feed_description;
$feed['icon'] = $logo;

$feed['author']['name'] = $author_name;
$feed['author']['url'] = $author_url;
$feed['author']['avatar'] = $author_avatar;

$items = array();
    
    $files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
    $total_posts = count($files);
natsort($files);
    $files = array_reverse($files, false);

    if (isset($_GET['offset'])) {
        $x = 0;
        while ($x < intval($_GET['offset'])) {
            unset($files[$x]);
            $x++;
        }
        $next_offset = intval($_GET['offset']) + 10;
        if ($next_offset<=$total_posts) {
            $feed['next_url'] = $site_root . '/feed.json?offset=' . strval($next_offset) . '';
        }
    } else { // Request with no offset, so start at offset=10
        $feed['next_url'] = $site_root . '/feed.json?offset=10';
    }

    $i = 0;

    foreach ($files as $txt) {
        if ($i<10) {
            $pubDate = get_date($txt, "Y-m-d\TH:i:sP");

            $url = $site_root . '/index.php?entry=' . get_number($txt);
            $title = get_title($txt);

            $Parsedown = new Parsedown();
            
            $item = array();
            $item['id'] = get_number($txt);
            $item['url'] = $url;
            $item['title'] = $title;
            $item['date_published'] = $pubDate;
            $item['content_html'] = $Parsedown->text(get_text($txt));
            
            array_push($items, $item);
            $i++;
        }
    } 
    $feed['items'] = $items;
    header('Content-type: application/json; charset=utf-8');
    $json = json_encode($feed, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo $json;
?>

