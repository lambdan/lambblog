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

<div class="normal">

<?php
// Add files to array, and natsort it, and reverse it (newest first)
$files = glob('' . $path_to_txts . '*.{txt,md,markdown}', GLOB_BRACE);
natsort($files);
$files = array_reverse($files, false);

// List them
$year = isset($_GET['year']) ? $_GET['year'] : get_date($files[0], "Y");
echo '<h1 style="text-align:center;">' . $year . '</h1>';

if ($year > date("Y")) {
    print 'The future hasn\'t been written yet';
}

$oldestYear=get_date($files[0], "Y");
$prevMonth = "aaa";
foreach($files as $txt) {
    // Check if file has no number yet
    if (is_numeric(substr(basename($txt),0,1)) == false) {
        $new_number = get_number($files[1]) + 1;
        $new_name = $path_to_txts . $new_number . ' ' . basename($txt);
        rename($txt, $new_name);
        $txt = $new_name;
        print '<h1><font color="red">New post added! Refresh to take effect!</font></h1>';
    }
    
    $currYear = get_date($txt, "Y");
    $currMonth = get_date($txt, "F");

    if ($currYear == $year) {

        /*
        if ($currYear != $year) {
            echo '</ul><h1 class="ArchiveYear">' . $currYear . '</h1>';
            $prevYear = $currYear;

        }*/

    	if ($currMonth != $prevMonth) {
    		print "</ul><h3>" . $currMonth . "</h2><ul>";
    		$prevMonth = $currMonth;
        }

        print '<li>';
        if (isLinked($txt)) {
            print '<a href="' . linkedURL($txt) . '">';
            print $linkedSymbol;
            print '</a>';
        }

    //    print '<a href="./' . get_display_filename($txt) . '" style="text-decoration:none;">' . get_title($txt) . '</a> - ' . get_date($txt, "j M Y") . '</li>';

        print '<a href="./' . get_display_filename($txt) . '">' . get_title($txt) . '</a></li>';
    }
    
    if (intval($currYear) < intval($oldestYear)) {
        $oldestYear = $currYear;
        //print 'new oldest year ' . $oldestYear;
    }
}
?>
</ul>
<?php
if (intval($year)-1 >= intval($oldestYear)) {
    print '<hr><a href="archive-' . (intval($year) - 1) . '">' . (intval($year) - 1) . '</a>';
} else {
    print '<hr>You have reached the end of time...';
}
?>
</div>
<footer>
</footer>
</body>
</html>
