<?php
require_once 'config.php';
require_once 'resources/Parsedown.php';
require_once 'resources/compressImage.php';
require_once 'resources/getPostData.php';

$Parsedown = new Parsedown();

// Read data from static txt
$path = $aboutTextPath;
$title = getPostData($path, "title");
$dateStamp = getPostData($path, "date");
$output = $Parsedown->text(getPostData($path, "content"));
$images = getPostData($path, "images");

// Header generation
$pageTitle = "About";
$pageName = "About";
$twitter = array($pageTitle, $aboutDescriptionTwitter);
require 'header.php';
?>

<!-- main content -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
<div class="panel-body">
                <h1>
                    <?php
                    echo $title;
                    ?>
                </h1>

                <p>
                    <!-- start text -->
                    <?php echo $output; ?>
                    <!-- end text -->
                </p>
            </div>
        </div>
    </div>
</div>
</div>

<?php require 'footer.php'; ?>
