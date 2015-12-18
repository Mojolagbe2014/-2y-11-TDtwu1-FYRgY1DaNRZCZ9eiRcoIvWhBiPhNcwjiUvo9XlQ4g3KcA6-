<?php
session_start();
include('config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class

$thisTemplate = filter_input(INPUT_GET, 'name') ? filter_input(INPUT_GET, 'name') : '';

if($thisTemplate!=''){
    include($cfg->templateLoc.$thisTemplate.'/index.php');
}else{
    include($cfg->templateLoc.$cfg->templateName.'/index.php');
}