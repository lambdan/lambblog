<?php
require_once 'config.php';
function compress($source, $quality) {

        global $compressDestination;
        global $compressURL;
        // Generate filename from url
        $filename = md5($source);

        // Set destination and finalurl from filename
        $destination = $compressDestination . $filename . '_compressed.jpg';
        $finalurl = $compressURL . $filename . '_compressed.jpg';

        if(!file_exists($destination)) {
            // File doesnt exist. download and compress it
            // Save image temporarily
            copy($source, $compressDestination . $filename . '');
            $source = $compressDestination . $filename . '';

        $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') 
                        $image = imagecreatefromjpeg($source);

                elseif ($info['mime'] == 'image/gif') 
                            $image = imagecreatefromgif($source);

                elseif ($info['mime'] == 'image/png') 
                            $image = imagecreatefrompng($source);

                imagejpeg($image, $destination, $quality);

                unlink($source); // Delete original file
                return $finalurl;
        } else {
            return $finalurl;
        }
}

?>
