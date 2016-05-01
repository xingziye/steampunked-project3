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
<div class="screen">
    <p><img src="images/title.png" alt="Steampunked Logo"></p>

    <?php echo $view->showWinner(); ?>

    <!--    <form method="post" action="game-post.php">-->
<!--        <fieldset>-->
<!--            <legend>Game Preferences</legend>-->
<!--            <p>-->
<!--                <label for="player1"> Player 1 Name:</label>-->
<!--                <input type="text" name="player1" id="player1">-->
<!--            </p>-->
<!--            <br>-->
<!--            <p>-->
<!--                <label for="player2"> Player 2 Name:</label>-->
<!--                <input type="text" name="player2" id="player2">-->
<!--            </p>-->
<!--            <br>-->
<!---->
<!--            <br>-->
<!--            <p>-->
<!--                <input type="submit">-->
<!--            </p>-->
<!--        </fieldset>-->
<!--    </form>-->
</div>
</body>
</html>