<?php
/**
 * Created by PhpStorm.
 * User: Santoro
 * Date: 2/5/16
 * Time: 9:25 PM
 */

require __DIR__ . "/../vendor/autoload.php";

// Start the PHP session system
session_start();

define("STEAMPUNKED_SESSION", 'steampunked');

// If there is a session, use that. Otherwise, create one
if(!isset($_SESSION[STEAMPUNKED_SESSION])) {
    $_SESSION[STEAMPUNKED_SESSION] = new Steampunked\Steampunked();
}

$steampunked = $_SESSION[STEAMPUNKED_SESSION];

