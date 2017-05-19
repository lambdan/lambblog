<?php
$feed = array();

$feed['version'] = 'https://jsonfeed.org/version/1';
$feed['title'] = 'lambdan.se';
$feed['home_page_url'] = 'https://lambdan.se/';
$feed['feed_url'] = 'https://lambdan.se/feed.json';
$feed['icon'] = 'https://lambdan.se/avatar.png';

$feed['author']['name'] = 'djs';
$feed['author']['url'] = 'https://twitter.com/djs__';
$feed['author']['avatar'] = 'https://lambdan.se/avatar.png';

$items = array();
    
    require 'Parsedown.php';
    require 'helpers.php';

    $files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

    $i = 0;

    foreach ($files as $txt) {
        if ($i<=10) {
            $pubDate = get_date($txt, "Y-m-d\TH:i:sP");

            $url = 'http://lambdan.se/index.php?entry=' . get_number($txt);
            $title = get_title($txt);

            $Parsedown = new Parsedown();
            
            $item = array();
            $item['id'] = get_number($txt);
            $item['title'] = $title;
            $item['content_html'] = $Parsedown->text(get_text($txt));
            $item['url'] = $url;
            $item['date_published'] = $pubDate;
            array_push($items, $item);
            $i++;
        }
    } 
    $feed['items'] = $items;
    header('Content-type: application/json; charset=utf-8');
    $json = json_encode($feed, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo $json;
?>

