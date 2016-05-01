<?php
    require_once 'config.php';
    $output  = '<?xml version="1.0" encoding="UTF-8"?>';
    $output .= '<rss version="2.0">';
    $output .= '<channel>';
    $output .= '<title>' . $brandName . '</title>';
    $output .= '<link>' . $rootURL . '</link>';
    $output .= '<description>' . $rssDescription . '</description>';
    
    require_once 'Parsedown.php';
    require_once 'getPostData.php';

    $content = array_diff(scandir($dir), array('..', '.', '.htaccess'));
    natcasesort($content);

    $i = 0;

    foreach (array_reverse($content) as $c) {
        if ($i<=10) {
        $path = '' . $dir . '' . $c . '';
        $title = getPostData($path, "title");

        $pubDate = getPostData($path, "date");
        $url = "";
        if (getPostData($path, "isLinked")) {
            $url = getPostData($path, "linkedURL");
            $title = $linkedSymbol . $title . '';
        } else {
            $url = getPostData($path, "link");
        }

        $Parsedown = new Parsedown();

        $output .= '<item>';

        $output .= '<title>' . $title . '</title>';
        $output .= '<description><![CDATA[' . $Parsedown->text(getPostData($path, "content")) . ']]></description>';
        $output .= '<link>' . $url . '</link>';
        $output .= '<pubDate>' . date('r', strtotime($pubDate)) . '</pubDate>'; // we have to strtotime the nice format to make it rss compliant
        $output .= '</item>';
        $i++;
        }
    } 

    $output .= '</channel>';
    $output .= '</rss>';

    header('Content-type: application/rss+xml; charset=utf-8');
    echo $output;
?>

