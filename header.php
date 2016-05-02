<?php
require 'config.php';
?>
<html><head>

<title><?php echo $pageTitle; echo $titleSuffix;?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Twitter card -->
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="<?php echo $twitterUsername;?>" />
<meta name="twitter:title" content="<?php echo $twitter[0]; ?>" />
<meta name="twitter:description" content="<?php echo $twitter[1]; ?>" />

<?php
if (isset($images)) { 
    if ($images) {
        $pic = $images[0];
        if (get_headers($pic, 1)["Content-Length"] > 900000) {
            $pic = compress($pic, 80);
        }
        echo '<meta name="twitter:image" content="' . $pic . '" />';
    } else {
        echo '<meta name="twitter:image" content="' . $placeholderImage . '" />';
    }
}
?>
<!-- End twitter card -->


<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/readable/bootstrap.min.css" rel="stylesheet" integrity="sha384-/x/+iIbAU4qS3UecK7KIjLZdUilKKCjUFVdwFx8ba7S/WvxbrYeQuKEt0n/HWqTx" crossorigin="anonymous">
<link href="<?php echo $customBootstrapCSS;?>" rel="stylesheet" type="text/css">
</head><body>
<div id="customNavbar" class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $rootURL;?>"><?php echo $brandName; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($pageName=="Home") {
                    echo '<li class="active">';
                } else {
                    echo '<li>';
                }
                ?>
                <a href="<?php echo $rootURL;?>">Home</a>
            </li>
            
            <?php
            if ($pageName=="All Posts") {
                echo '<li class="active">';
            } else {
                echo '<li>';
            }
            ?>
            <a href="<?php echo $rootURL;?>/list">Archive</a>
        </li>
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Other Pages<span class="caret"></span></a>
            <ul class="dropdown-menu">

                <?php echo $navDropdownMenu; ?>
            </ul>
        </li>

        <?php
        if ($pageName=="About") {
            echo '<li class="active">';
        } else {
            echo '<li>';
        }
        ?>
        <a href="<?php echo $rootURL;?>/about">About</a>
    </li>
</ul>
</div>
</div>
</div>