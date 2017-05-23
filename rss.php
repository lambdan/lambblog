<?php
    require 'Parsedown.php';
    require 'helpers.php';
    $output  = '<?xml version="1.0" encoding="UTF-8"?>';
    $output .= '<rss version="2.0">';
    $output .= '<channel>';
    $output .= '<title>' . $site_title .'</title>';
    $output .= '<link>' . $site_root .'</link>';
    $output .= '<description>' . $feed_description . '</description>';

    $files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

    $i = 0;

    foreach ($files as $txt) {
        if ($i<=10) {
            $pubDate = get_date($txt, "r");

            $url = $site_root . '/index.php?entry=' . get_number($txt);
            $title = get_title($txt);

            $Parsedown = new Parsedown();

            $output .= '<item>';

            $output .= '<title>'  . htmlspecialchars($title) . '</title>';
            $output .= '<description><![CDATA[' . $Parsedown->text(get_text($txt)) . ']]></description>';
            $output .= '<link>' . $url . '</link>';
            $output .= '<pubDate>' . $pubDate . '</pubDate>'; // we have to strtotime the nice format to make it rss compliant
            $output .= '</item>';
            $i++;
        }
    } 

    $output .= '</channel>';
    $output .= '</rss>';

    header('Content-type: application/rss+xml; charset=utf-8');
    echo $output;
?>

