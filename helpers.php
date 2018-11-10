<?php
require 'config.php';

function get_title($txt) {
	$lines = file($txt);
	$title = preg_split("/[#\n]+/", $lines[1]);
	$title = substr($title[1], 1);
	return $title;
}

function get_date($txt, $format) {
	$lines = file($txt);
	$unixtime = strtotime($lines[0]);
	$date = date($format, $unixtime);
	return $date;
}

function get_text($txt) {
	$lines = file($txt);
	unset($lines[0]); // remove date
    unset($lines[1]); // remove title
    if (isLinked($txt)) { // remove url if its a linked post
        unset($lines[2]);
    } 
	return implode('',$lines);
}

function get_display_filename($txt) {
	$filename = basename($txt); // get just filename
	$filename = pathinfo($filename, PATHINFO_FILENAME); // remove .txt or whatever
	$filename = seo_friendly_url($filename);
	if (is_numeric($filename)) { // If the filename is just a number, put title of post in URL
		//$number = get_number($txt);
		$title = get_title($txt);
        //$combined = $title . "-" . $number;
        $string = seo_friendly_url($title);
		//$string = seo_friendly_url($combined);
    } else { // ... otherwise just put filename in URL
        $string = $filename;
        $string = substr($string, strpos($string, '-')+1);
	}
    //return get_date($txt, "Y.m.d.") . $string . '.'.  get_number($txt);
    //return get_number($txt) . get_date($txt, ".Y.m.d-") . $string;
    return get_number($txt) . '-' . $string;
}

function get_number($txt) {
	$filename = basename($txt); // get just filename
	$filename = explode(".", $filename)[0];
	$components = explode(" ", $filename);
	return $components[0];
}

function file_from_url($entry, $dir) {
	$pieces = explode("-", $entry); // separate number
	$number = intval($pieces[0]); // consider it an int (idk if this is actually necessary as the glob kind of uses it as a string? whatever)
    $filepath = glob($dir . $number . '*'); // get all files in $dir that starts with that number
	return @$filepath[0]; // return the 1 file that matches
}

function seo_friendly_url($string){
	// http://stackoverflow.com/a/14114430
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}

function count_posts($dir){
	$files = glob('' . $dir . '*.{txt,md,markdown}', GLOB_BRACE);
	return count($files);
}

function get_summary($filename) {
    return substr(get_text($filename),0,100) . '...';
}

function get_summary_frontpage($filename) {
    return explode("\n", get_text($filename))[1];
}

function isLinked($filename) {
    $lines = file($filename);
    // Check if third line starts with http
    if (substr($lines[2],0,4) == "http") {
        return true;
    } else {
        return false;
    }
}

function linkedURL($filename) {
    $lines = file($filename);
    return rtrim($lines[2]);
}

function generateNavigation() {
    global $navbar_title;
    include 'header.php';
}

function generateCopyrightFooter() {
    global $site_title;
    global $copyright_start;
    global $author_email;
    echo '<br>©' . $copyright_start . '-' . date("Y") . '<br><a href="mailto:' . $author_email . '">' . $author_email . '</a>';
}

function faviconHeaders() {
	echo '
<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png?v=rMlK32YJeL">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png?v=rMlK32YJeL">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png?v=rMlK32YJeL">
<link rel="manifest" href="/favicons/manifest.json?v=rMlK32YJeL">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg?v=rMlK32YJeL" color="#ff0f00">
<link rel="shortcut icon" href="/favicons/favicon.ico?v=rMlK32YJeL">
<meta name="msapplication-config" content="/favicons/browserconfig.xml?v=rMlK32YJeL">
<meta name="theme-color" content="#ffffff">
	';
}


?>