<?php

$entry = $_GET['entry'];

header('Location: http://lambdan.se/index.php?entry=' . $entry);
die();

echo 'Please go to: http://lambdan.se/index.php?entry=' . $entry;


?>