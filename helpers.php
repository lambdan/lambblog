<?php

// You should probably edit these
date_default_timezone_set('Europe/Stockholm');
$path_to_txts = './posts/';

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
	// remove link
	/* if (substr($lines[2],0,4) == "http") {
		unset($lines[2]);
	} */
	return implode('',$lines);
}

function get_display_filename($txt) {
	$filename = basename($txt); // get just filename
	$filename = pathinfo($filename, PATHINFO_FILENAME); // remove .txt or whatever
	$filename = seo_friendly_url($filename);
	return $filename;
}

function get_number($txt) {
	$filename = basename($txt); // get just filename
	$components = explode(" ", $filename);
	return $components[0];
}

function file_from_url($entry, $dir) {
	$pieces = explode("-", $entry); // separate number
	$number = intval($pieces[0]); // consider it an int (idk if this is actually necessary as the glob kind of uses it as a string? whatever)
	$filepath = glob($dir . $number . '*'); // get all files in $dir that starts with that number
	return $filepath[0]; // return the 1 file that matches
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

?>