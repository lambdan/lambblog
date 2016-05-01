<?php
require_once 'config.php';
require_once 'Parsedown.php';
require_once 'class.PaginationLinks.php';
require_once 'getPostData.php';

$content = array_diff(scandir($dir), array('..', '.', '.htaccess'));
natcasesort($content); // Sort content

if (isset($_GET['p'])) {
    $currpage = intval(htmlspecialchars($_GET['p']));
} else {
    $currpage = 1;
}

$totPosts = count($content);
$i = $totPosts - (($currpage-1)*5);
$stopLimit = ($i-5);

// Header generation
$pageTitle = "Home";
$pageName = "Home";
$twitter = array($pageTitle, $indexDescriptionTwitter);
require 'header.php';

    echo '<div class="section"><div class="container">';
                while ($i>$stopLimit && $i>0) {
                    $number = $i;
                    $path = glob($dir . '' . $number . '*.txt');
                    $firstline = fgets(fopen($path[0], 'r'));
                    
                    $title = getPostData($path[0], "title");
                    if (getPostData($path[0], "isLinked")) {
                        $title = '' . getPostData($path[0], "title");
                    }
                    
                    $dateStamp = getPostData($path[0], "date");
                    $linkToPost = getPostData($path[0], "link");
                    $isLinked = getPostData($path[0], "isLinked");
                echo '<div class="row">
                    <div class="col-md-12">
                        ';
                    if ($isLinked) {
                        $url = getPostData($path[0], "linkedURL");
                        echo '<div class="panel">
                        <div class="panel-heading">
                        <h3 class="panel-title"><a href="' . $url . '"><span class="linkedPost">' . $title . '</a>';
                        echo '<span class="panel-title">&nbsp;&nbsp;&nbsp;<a href="' . $linkToPost . '"><<<</a></span>';
                    } else {
                        echo '
                        <div class="panel">
                        <div class="panel-heading">
                        <h3 class="panel-title"><a href="' . $linkToPost . '"><span class="regularPost">' . $title . '</a></a>';
                    }

                            echo '<br><small>' . $dateStamp . '</small></h3>
                            </div>
                            <div class="panel-body">';
                                $output = "";
                    $Parsedown = new Parsedown();
                                $images = getPostData($path[0], "images");
                    $output .= $Parsedown->text(getPostData($path[0], "content"));

                                echo '<p>';
                                echo $output;
                                echo '</p>';
                                echo '
                            </div>
                        </div>
                    </div>
                    </div>';
                                echo '<hr class="ArticSep">';
                $i--;
                }
                ?>
                <div class="row">
                    <div class="col-md-12">
<center>
                        <ul class="pagination">
                            <?php
                            if($currpage>1) {
                                echo '<li><a href="?p=' . ($currpage-1) . '">Prev</a></li>';
                            }
                            
                            echo PaginationLinks::create($currpage, ceil($totPosts/5), 2, '<li><a href="?p=%d">%d</a></li>','<li class="active"><a href="#">%d</a></li>','');
                            
                            if($currpage<ceil($totPosts/5)) {
                                echo '<li><a href="?p=' . ($currpage+1) . '">Next</a></li>';
                            }
                            ?>
                        </ul>
</center>
                    </div>
                </div>
            </div>

<?php require 'footer.php'; ?>
