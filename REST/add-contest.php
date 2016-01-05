<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$contestObj = new Contest($dbObj); // Create an object of Contest class
$errorArr = array(); //Array of errors
$contestLogoImg =""; $contestHeaderImg ="";

if(!isset($_SESSION['SWPLoggedInAdmin']) || !isset($_SESSION["SWPadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in.");
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "addNewContest") != NULL){
        $postVars = array('title','intro','description','header','logo','startDate','endDate','announcementDate','winners', 'question', 'answer', 'point', 'bonusPoint', 'rules', 'prize', 'message', 'css', 'announceWinner', 'restart', 'restartInterval', 'cutOffPoint'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'header':   $contestObj->$postVar = basename($_FILES["header"]["name"]) ? rand(100000, 1000000)."_". StringManipulator::slugify(filter_input(INPUT_POST, 'title')).".".pathinfo(basename($_FILES["header"]["name"]),PATHINFO_EXTENSION): ""; 
                                $contestHeaderImg = $contestObj->$postVar;
                                if($contestObj->$postVar == "") {array_push ($errorArr, " $postVar ");}
                                break;
                case 'logo':   $contestObj->$postVar = basename($_FILES["logo"]["name"]) ? rand(100000, 1000000)."_". StringManipulator::slugify(filter_input(INPUT_POST, 'title')).".".pathinfo(basename($_FILES["logo"]["name"]),PATHINFO_EXTENSION): ""; 
                                $contestLogoImg = $contestObj->$postVar;
                                break;
                case 'css':    $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                break;
                default     :   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($contestObj->$postVar == "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        //If validated and not empty submit it to database
        if(count($errorArr) < 1)   {
            $targetLogo = MEDIA_FILES_PATH."contest-logo/". $contestLogoImg;
            $targetHeader = MEDIA_FILES_PATH."contest-header/". $contestHeaderImg;
            $uploadOk = 1; $msg = '';
            $imageFileType = pathinfo($targetLogo,PATHINFO_EXTENSION);
            if (file_exists($targetHeader)) { $msg .= " Contest header already exists."; $uploadOk = 0; }
            if ($_FILES["logo"]["size"] > 800000000 || $_FILES["header"]["size"] > 80000000) { $msg .= " Contest media is too large."; $uploadOk = 0; }
            if($contestLogoImg !=''){ move_uploaded_file($_FILES["logo"]["tmp_name"], $targetLogo);}
            if($contestHeaderImg !=''){ move_uploaded_file($_FILES["header"]["tmp_name"], $targetHeader);}
            if ($uploadOk == 0) {
                $msg = "Sorry, your contest media was not uploaded. ERROR: ".$msg;
                $json = array("status" => 0, "msg" => $msg); 
                $dbObj->close();//Close Database Connection
                header('Content-type: application/json');
                echo json_encode($json);
            } 
            else { echo $contestObj->add(); }
        }
        else{ 
            $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($errorArr)); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}