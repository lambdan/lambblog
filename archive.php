<?php
require 'Parsedown.php';
require 'helpers.php';

$starttime = explode(' ', microtime());
$starttime = $starttime[1] + $starttime[0];
?>


<html>
<head>
<?php echo "<title>Blog Archive - ${site_title}</title>"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo '<link rel="stylesheet" type="text/css" href="' . $css_url . '">'; ?>

<?php faviconHeaders(); ?>
<meta charset="utf-8">

</head>

<body>

<?php generateNavigation(); ?>

<div class="article">

<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

// List them
$prevMonth = "";
//$prevYear = date("Y");
$prevYear = 0;
foreach($files as $txt) {
    // Check if file has no number yet
    if (is_numeric(substr(basename($txt),0,1)) == false) {
        $new_number = get_number($files[1]) + 1;
        $new_name = $path_to_txts . $new_number . ' ' . basename($txt);
        rename($txt, $new_name);
        $txt = $new_name;
        print '<h1><font color="red">New post added!</font></h1>';
    }
    
    $currYear = get_date($txt, "Y");
    //$currMonth = get_date($txt, "F Y");
    
    if ($currYear != $prevYear) {
        echo '</ul><h1 class="ArchiveYear">' . $currYear . '</h1>';
        $prevYear = $currYear;
    }
	/*if ($currMonth != $prevMonth) {
		print "</ul><h2>" . $currMonth . "</h2><ul>";
		$prevMonth = $currMonth;
    } */
    print '<li>';
    if (isLinked($txt)) {
        print '<a href="' . linkedURL($txt) . '">';
        print $linkedSymbol;
        print '</a>';
    }
//    print '<a href="./' . get_display_filename($txt) . '" style="text-decoration:none;">' . get_title($txt) . '</a> - ' . get_date($txt, "j M Y") . '</li>';

    print '<a href="./' . get_display_filename($txt) . '" style="text-decoration:none;">' . get_title($txt) . '</a></li>';
}

?>
</ul>
</div>
<footer>
<p>Have you checked out the <a href="stats">Stats</a> page yet?</p>
</footer>
</body>
</html>
