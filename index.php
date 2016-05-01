<?php
require_once 'config.php';
require_once 'Parsedown.php';
require_once 'class.PaginationLinks.php';
require_once 'getPostData.php';

$content = array_diff(scandir($dir), array('..', '.', '.htaccess'));
natcasesort($content);
$totPosts = count($content);
if (isset($_GET['p'])) {
    $currpage = intval(htmlspecialchars($_GET['p']));
} else {
    $currpage = 1;
}


$offset = $totPosts - ($postsOnPage*$currpage);

while ($offset<0) {
    $offset++;
    $postsOnPage--;
}


$content = array_slice($content, $offset, $postsOnPage);
// Header generation
$pageTitle = "Home";
$pageName = "Home";
$twitter = array($pageTitle, $indexDescriptionTwitter);
require 'header.php';

    echo '<div class="section"><div class="container">';
//                while ($i>$stopLimit && $i>0) {
                    foreach(array_reverse($content) as $c) {
                    $number = preg_split("/[\s,.]+/", $c);
                    $path = $dir . $c;

                    $firstline = fgets(fopen($path, 'r'));
                    
                    $title = getPostData($path, "title");
                    if (getPostData($path, "isLinked")) {
                        $title = '' . getPostData($path, "title");
                    }
                    
                    $dateStamp = getPostData($path, "date");
                    $linkToPost = getPostData($path, "link");
                    $isLinked = getPostData($path, "isLinked");
                echo '<div class="row">
                    <div class="col-md-12">
                        ';
                    if ($isLinked) {
                        $url = getPostData($path, "linkedURL");
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
                                $images = getPostData($path, "images");
                    $output .= $Parsedown->text(getPostData($path, "content"));

                                echo '<p>';
                                echo $output;
                                echo '</p>';
                                echo '
                            </div>
                        </div>
                    </div>
                    </div>';
                                echo '<hr class="ArticSep">';
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
