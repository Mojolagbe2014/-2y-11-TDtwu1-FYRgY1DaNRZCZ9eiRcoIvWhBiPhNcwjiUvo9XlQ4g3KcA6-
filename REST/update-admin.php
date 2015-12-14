<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$adminObj = new Admin($dbObj); // Create an object of Admin class
$errorArr = array(); //Array of errors

if(!isset($_SESSION['SWPLoggedInAdmin']) || !isset($_SESSION["SWPadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "updateThisAdmin") != NULL){
        $postVars = array('id', 'name','email','userName','role'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $adminObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($adminObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            echo $adminObj->update();
        }
        //Else show error messages
        else{ 
            $json = array("status" => 0, "msg" => $errorArr); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}