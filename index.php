<?php 
session_start();
include('config/config.php');
define("CURRENT_PAGE", "home");

$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class

include('includes/other-settings.php');
require('includes/page-properties.php');
?>
