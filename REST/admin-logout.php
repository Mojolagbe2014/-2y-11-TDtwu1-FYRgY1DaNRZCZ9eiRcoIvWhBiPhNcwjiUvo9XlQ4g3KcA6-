<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$adminObj = new Admin($dbObj); // Create an object of Admin class
$errorArr = array(); //Array of errors

session_destroy();
$json = array("status" => 1, "msg" => "Logout successful."); 
$dbObj->close();//Close Database Connection
header('Content-type: application/json');
echo json_encode($json);
