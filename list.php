<?php
require_once 'config.php';
require_once 'getPostData.php';

// Header generation
$pageTitle = "All Posts";
$pageName = "All Posts";
$twitter = array($pageTitle, $archiveDescriptionTwitter);
require 'header.php';
?>
  
        <div class="section"><div class="container"><div class="row"><div class="col-md-12">

        <?php
        $dir = 'posts/';
        $content = array_diff(scandir($dir), array('..', '.', '.htaccess'));
        natcasesort($content); // Sort content
        $prevMonth = "";
        foreach (array_reverse($content) as $c) {
            $number = preg_split("/[\s,.]+/", $c);
            $path = $dir . $c;

            $dateStamp = getPostData($path, "date");        
            $currMonth = date("F Y", strtotime($dateStamp));

            if($currMonth != $prevMonth) {
                if ($prevMonth!="") {
                }
                echo '<h4>' . $currMonth . '</h4>';
                $prevMonth = $currMonth;
            }
                

            if (getPostData($path, "isLinked")) {
                $title = $linkedSymbol . getPostData($path, "title") . ''; // Display linked symbol
            } else {

                $title = '' . getPostData($path, "title") . '';
            }
            //$dateStamp = getPostData($path, "date");
            $link = getPostData($path, "link");

            echo '<li class="archive"><a href="' . $link . '">' . $title . '</a></li>';
        }
        ?>
        </div></div></div></div>

</div>
<?php require 'footer.php'; ?>
    