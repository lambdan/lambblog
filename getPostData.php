<?php
require_once 'config.php';
require_once 'friendly-url.php';

function getPostData($inputfile, $request) {
	$acceptedRequests = array("title", "isLinked", "linkedURL", "content", "date", "link", "teaser", "images", "actualTeaser");

	if(in_array($request, $acceptedRequests)) {
		$lines = file($inputfile); // Read file into lines (array)

		if ($request=="date") {
			date_default_timezone_set('UTC');
			$unixtime = strtotime($lines[0]); // Parses first lines date (many formats) into unix time
			$date = date('F j Y', $unixtime);
			return $date;
		}
		if ($request=="title") {
			// Removes # and whitespace from line with title
			$title = preg_split("/[#\n]+/", $lines[1]);
			$title = substr($title[1], 1);
			return $title;
		}
		if ($request=="isLinked") {
			if (substr($lines[2],0,4) == "http") {
				return true;
			} else {
				return false;
			}
		}
		if ($request=="linkedURL") {
			return $lines[2];
		}
		if ($request=="content") {
			unset($lines[0]);
			unset($lines[1]);
			if (substr($lines[2],0,4) == "http") {
				unset($lines[2]);
			}
			return implode("",$lines);
        }
        if ($request=="images") {
            $Parsedown = new Parsedown();
            // Convert markdown to html so we can scan for tags
            $html = $Parsedown->text(getPostData($inputfile, "content"));
            
            $doc = new DOMDocument();
            @$doc->loadHTML($html);
            $tags = $doc->getElementsByTagName('img');
            $imagesArray = array();
            foreach ($tags as $tag) {
                array_push($imagesArray, $tag->getAttribute('src'));
            }

            if (count($imagesArray)>0) {
                return $imagesArray;
            } else {
                return false;
            }
        }
		if ($request=="link") {
			$number = preg_split("/[\s,.]+/", $inputfile);
			$number = substr($number[0],6);
			$title = preg_split("/[#\n]+/", $lines[1]);
			$title = substr($title[1], 1);
			global $rootURL;
			return $rootURL . '/' . $number . '/' . seo_friendly_url($title) . '';
		}
		if ($request=="teaser") { // For lazy reasons I didn't change name of this request
            unset($lines[0]);
            unset($lines[1]);
            if (substr($lines[2],0,4)== "http") {
                unset($lines[2]);
            }
            $pdown = new Parsedown();
            $fullString = implode("",$lines);
            $stringCut = substr($fullString, 0, 500);
            return substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
        }
        if ($request=="actualTeaser") { 
              if (substr($lines[2],0,4) == "http") {
                                   // Remove newline
                                    return str_replace("\n", '', $lines[4]);
                                 } else {
                                      return str_replace("\n", '', $lines[3]);
                                   }
        }
	} else {
		echo "Not a valid request for PostData";
    }
}

function howManyPosts() {
	// How many posts are there in total?
    $fi = new FilesystemIterator('posts/', FilesystemIterator::SKIP_DOTS);

	return iterator_count($fi)-1;
}

?>
