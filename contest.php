<?php 
session_start();
include('config/config.php');

$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class
$contestObj = new Contest($dbObj);
$entrantObj = new Entrant($dbObj);
$errorArr = array();

//get the contest id; if failed redirect to contest-home page
$thisContestId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : $thisPage->redirectTo(SITE_URL);

if(count($contestObj->fetchRaw("*", " id = $thisContestId "))<1){$thisPage->redirectTo(SITE_URL);}

foreach ($contestObj->fetchRaw("*", " id = $thisContestId ") as $contest) {
    $contestData = array('status' => 'status', 'id' => 'id', 'title' => 'title', 'intro' => 'intro', 'description' => 'description', 'header' => 'header', 'logo' => 'logo', 'startDate' => 'start_date', 'endDate' => 'end_date', 'announcementDate' => 'announcement_date', 'winners' => 'winners', 'question' => 'question', 'answer' => 'answer', 'point' => 'point', 'bonusPoint' => 'bonus_point', 'rules' => 'rules', 'prize' => 'prize', 'message' => 'message', 'css' => 'css', 'dateAdded' => 'date_added', 'announceWinner' => 'announce_winner', 'restart' => 'restart', 'restartInterval' => 'restart_interval', 'cut_off_point' => 'cut_off_point', 'theme' => 'theme');
    foreach ($contestData as $key => $value){
        switch ($key) { 
            case 'header': $contestObj->$key = MEDIA_FILES_PATH1.'contest-header/'.$contest[$value];break;
            case 'logo': $contestObj->$key = MEDIA_FILES_PATH1.'contest-logo/'.$contest[$value];break;
            default     :   $contestObj->$key = $contest[$value]; break; 
        }
    }
}

$cfg->templateName = $contestObj->theme ? $contestObj->theme : 'default';
$cfg->templateUrl = $cfg->templatePath.$cfg->templateName.'/';
$thisPage->title = $contestObj->title;
$thisPage->description = $contestObj->description;

//Invitation Handler
if(filter_input(INPUT_POST, "email")!= NULL){
    $postVars = array('email','friends','names', 'answer', 'contest', 'point'); // Form fields names
    $thisEntrantAnswer='';
    //Validate the POST variables and add up to error message if empty
    foreach ($postVars as $postVar){
        switch($postVar){
            case 'answer':  $thisEntrantAnswer = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  '';
                            break;
            case 'contest': $entrantObj->$postVar = $thisContestId; break;
            case 'point':   $entrantObj->$postVar = $contestObj->point; break;
            case 'email':   $entrantObj->$postVar = filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL)) :  ''; 
                            if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, $postVar);}
                            break;
            case 'friends': $entrantObj->$postVar = filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_EMAIL)) :  ''; 
                            if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, $postVar);}
                            break;
                            
            default     :   $entrantObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                            if(filter_input(INPUT_POST, $postVar) === "") {array_push ($errorArr, $postVar);}
                            break;
        }
    }
    if(count($errorArr) < 1)   {
        $returnAction="";
        //Existing Entrant handler
        if($entrantObj->emailExists()==true){ 
            $returnAction = $entrantObj->updateRaw(); 
        }
        //New Entrant Handler
        else{  
            echo $thisEntrantAnswer . "=>" .$contestObj->answer;
            if($thisEntrantAnswer == $contestObj->answer){ $entrantObj->point = Number::getNumber($entrantObj->point)+Number::getNumber($entrantObj->bonusPoint); }
            $returnAction = $entrantObj->addRaw();   
        }
        
        if($returnAction == 'success') {
            $cfg->infoMessage = $thisPage->messageBox('Contest successfully entered and invitation sent.', 'success');
        } 
        else {
            $cfg->infoMessage = $thisPage->messageBox('Contest invitation failed. '.$returnAction, 'error');
        }
    }
    else{ $cfg->infoMessage = $thisPage->showError($errorArr); }
}

include('includes/other-settings.php');
$thisPage->author = $cfg->author;

include($cfg->templateLoc.$cfg->templateName.'/index.php');