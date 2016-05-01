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
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="jslib/Steampunked.js"></script>
    <script>
        $(document).ready(function() {
            new Steampunked("form");
        });
    </script>
</head>
<body>
    <?php echo $view->createGrid(); ?>
    <?php echo $view->presentTurn(); ?>
    <?php echo $view->createRadioButtons(); ?>
    <?php echo $view->createOptionButtons(); ?>
</body>
</html>