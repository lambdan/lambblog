<?php
require_once 'config.php';

// End URL with .text to display Markdown
if(isset($_GET['mdown'])) {
if($_GET['mdown']=="true") {
    if(isset($_GET['post'])) {
        $number = intval(htmlspecialchars($_GET['post']));
        $path = glob($dir . '' . $number . '*.txt');

        header('Content-type: text/plain');
        echo file_get_contents($path[0]);
        die();
    }
}
}

require_once 'compressImage.php';
require_once 'Parsedown.php';
require_once 'class.PaginationLinks.php';
require_once 'getPostData.php';

if(isset($_GET['post'])) {
    $Parsedown = new Parsedown();

    $number = intval(htmlspecialchars($_GET['post']));
    $path = glob($dir . '' . $number . '*.txt');

    $title = getPostData($path[0], "title");
    if (getPostData($path[0], "isLinked")) {
        $title = '>>> ' . getPostData($path[0], "title");
    }

    $dateStamp = getPostData($path[0], "date");
    $link = getPostData($path[0], "link");
    $output = $Parsedown->text(getPostData($path[0], "content"));
    $images = getPostData($path[0], "images");
} else {
    die("No post id");
}

// Header generation
$pageTitle = $title;
$pageName = "Post";
$twitter = array($title, getPostData($path[0], "actualTeaser"));
require 'header.php';

echo '<div class="section"><div class="container">';
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
echo $output;
?>
</div>
</div>
</div>
</div>

<?php require 'footer.php'; ?>
