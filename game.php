<?php
require 'lib/game.inc.php';
$view = new Steampunked\View($steampunked);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Steampunked</title>
    <link href="project1.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php echo $view->createGrid(); ?>
    <?php echo $view->presentTurn(); ?>
    <?php echo $view->createRadioButtons(); ?>
    <?php echo $view->createOptionButtons(); ?>
</body>
</html>