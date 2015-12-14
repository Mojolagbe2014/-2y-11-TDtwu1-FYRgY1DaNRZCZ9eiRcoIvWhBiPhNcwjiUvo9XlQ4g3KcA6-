<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$adminObj = new Admin($dbObj); // Create an object of Admin class
$errorArr = array(); //Array of errors

if(filter_input(INPUT_POST, "loginstuff")!=NULL){
    $postVars = array('email','passWord'); // Form fields names
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'passWord':$adminObj->$postVar = filter_input(INPUT_POST, $postVar) ? md5(mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar))) :  ''; 
                            if($adminObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
            default     :   $adminObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if($adminObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                            break;
        }
    }
    //If validated and not empty submit it to database
    if(count($errorArr) < 1)   {
        $logingInAdmin = json_decode($adminObj->fetch("*", "  email = '".$adminObj->email."' AND password =  '".$adminObj->passWord."' ", " id "));
        if($logingInAdmin->status === 1){
            $_SESSION['SWPLoggedInAdmin'] = true; $_SESSION['SWPAdminName'] = $logingInAdmin->info[0]->userName;
            $_SESSION['SWPadminId'] = $logingInAdmin->info[0]->id; $_SESSION['SWPadminEmail'] = $logingInAdmin->info[0]->email;
            $_SESSION['SWPadminRole'] = $logingInAdmin->info[0]->role;
            header('Content-type: application/json');
            echo json_encode($logingInAdmin);
        }
        else{ 
            echo json_encode(array("status" => $logingInAdmin->status, "msg" => "Login Failed! Either username or password is incorrect."));    
        }
    }
    else{ 
        $json = array("status" => 0, "msg" => $errorArr); 
        $dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
    }
} else{ 
        $json = array("status" => 0, "msg" => "Login Failed. Unrecognized attempt."); 
        $dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        echo json_encode($json);
}