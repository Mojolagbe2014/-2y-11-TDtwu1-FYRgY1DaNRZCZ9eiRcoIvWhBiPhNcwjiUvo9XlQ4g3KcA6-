<?php 
session_start();
include('config/config.php');

$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class
$contestObj = new Contest($dbObj);

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

include('includes/other-settings.php');
$thisPage->author = $cfg->author;

include($cfg->templateLoc.$cfg->templateName.'/index.php');