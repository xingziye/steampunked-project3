<?php
require '../lib/game.inc.php';

$controller = new Steampunked\Controller($steampunked, $_POST);
header("location: " . $controller->getRedirect());
//echo $controller->linkRedirect();
