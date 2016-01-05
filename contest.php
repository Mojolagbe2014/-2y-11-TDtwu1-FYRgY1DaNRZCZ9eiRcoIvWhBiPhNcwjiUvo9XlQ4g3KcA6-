<?php 
session_start();
include('config/config.php');
require('swiftmailer/lib/swift_required.php');

$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class
$contestObj = new Contest($dbObj);
$entrantObj = new Entrant($dbObj);
$errorArr = array();

//get the contest id; if failed redirect to contest-home page
$thisContestId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : $thisPage->redirectTo(SITE_URL);

if(count($contestObj->fetchRaw("*", " id = $thisContestId "))<1){$thisPage->redirectTo(SITE_URL);}

foreach ($contestObj->fetchRaw("*", " id = $thisContestId ") as $contest) {
    $contestData = array('status' => 'status', 'id' => 'id', 'title' => 'title', 'intro' => 'intro', 'description' => 'description', 'header' => 'header', 'logo' => 'logo', 'startDate' => 'start_date', 'endDate' => 'end_date', 'announcementDate' => 'announcement_date', 'winners' => 'winners', 'question' => 'question', 'answer' => 'answer', 'point' => 'point', 'bonusPoint' => 'bonus_point', 'rules' => 'rules', 'prize' => 'prize', 'message' => 'message', 'css' => 'css', 'dateAdded' => 'date_added', 'announceWinner' => 'announce_winner', 'restart' => 'restart', 'restartInterval' => 'restart_interval', 'cutOffPoint' => 'cut_off_point', 'theme' => 'theme');
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
include('includes/other-settings.php');
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
            case 'point':   $entrantObj->$postVar = 0; break;//$contestObj->point
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
        $siteUrl = SITE_URL."contest/$contestObj->id/".StringManipulator::slugify($contestObj->title)."/".Entrant::getSingle($dbObj, "id", $entrantObj->email)."/$entrantObj->friends/";
        
        include('includes/invitation-email-template.php');
        
        $subject = "Sweepstakes/Contest Invitation";	
        $transport = Swift_MailTransport::newInstance();
        $message = Swift_Message::newInstance();
        $message->setTo(array($entrantObj->friends => $entrantObj->names));
        $message->setSubject($subject);
        $message->setBody($body);
        $message->setFrom($entrantObj->email, $entrantObj->email);
        $message->setContentType("text/html");
        $mailer = Swift_Mailer::newInstance($transport);
        
        if($entrantObj->emailExists()==true){//Existing Entrant handler 
            $friendNamesList = Entrant::getSingle($dbObj, 'names', $entrantObj->email);
            $friendEmailsList = Entrant::getSingle($dbObj, 'friends', $entrantObj->email);
            
            $friendEmailsArr = explode(",", $friendEmailsList);
            
            if(!in_array(trim($entrantObj->friends), $friendEmailsArr)){
                $entrantObj->friends .= ",".$friendEmailsList; $entrantObj->names .= ",".$friendNamesList;
                if($mailer->send($message) > 0) { $returnAction = $entrantObj->updateRaw(); }
                //$returnAction = $entrantObj->updateRaw();
            }
        }
        else{//New Entrant Handler
            if($thisEntrantAnswer == $contestObj->answer){ $entrantObj->point = Number::getNumber($contestObj->bonusPoint); }//Number::getNumber($contestObj->point)+Number::getNumber($contestObj->bonusPoint);
            if($mailer->send($message) > 0) { $entrantObj->friends .= ","; $entrantObj->names .= ","; $returnAction = $entrantObj->addRaw(); }
//            $entrantObj->friends .= ","; $entrantObj->names .= ",";
//            $returnAction = $entrantObj->addRaw();
        }
        
        if($returnAction == 'success') {
            $cfg->infoMessage = 'Contest successfully entered and invitation sent.';
        } 
        else {
            $cfg->infoMessage = '<h3>Contest invitation failed!</h3> <p>Please try again later.</p>';
        }
    }
    else{ $cfg->infoMessage = $thisPage->showError($errorArr); }
}

//Refered Visitor's Handler
if(filter_input(INPUT_GET, "referer")!= NULL && filter_input(INPUT_GET, "invitee")!= NULL){
    $entrantObj->email = Entrant::getSingle($dbObj, 'email', filter_input(INPUT_GET, "referer", FILTER_VALIDATE_INT));
    $entrantObj->friends = filter_input(INPUT_GET, "invitee") ? filter_input(INPUT_GET, "invitee"): "";
    
    $friendNamesList = Entrant::getSingle($dbObj, 'names', $entrantObj->email);
    $friendEmailsList = Entrant::getSingle($dbObj, 'friends', $entrantObj->email);
    
    $friendEmailsArr = explode(",", $friendEmailsList);
    $friendNamesArr = explode(",", $friendNamesList);
    $inviteeName = $friendNamesArr[array_search(trim($entrantObj->friends), $friendEmailsArr)];//strrpos($friendNamesList, $friendNamesArr[array_search(trim($entrantObj->friends), $friendEmailsArr)]."[m]");
    
    if(in_array(trim($entrantObj->friends), $friendEmailsArr) && !strrpos($inviteeName, "[m]")){
        if($entrantObj->emailExists()==true){//Existing Entrant handler 
            $entrantObj->point = Number::getNumber($contestObj->point) + Entrant::getSingle($dbObj, 'point', $entrantObj->email);//fetch current point
            $entrantObj->updateSingleRaw($dbObj, "point", $entrantObj->point, $entrantObj->email); 
            $entrantObj->updateSingleRaw($dbObj, "names", str_ireplace($inviteeName, $inviteeName."[m]", $friendNamesList), $entrantObj->email); 
        }
    }
    $thisPage->redirectTo(SITE_URL."contest/$contestObj->id/".StringManipulator::slugify($contestObj->title)."/");
}

include('includes/other-settings.php');
$thisPage->author = $cfg->author;

include($cfg->templateLoc.$cfg->templateName.'/index.php');