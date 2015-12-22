<?php
session_start();
include('config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class
$contestObj = new Contest($dbObj);

$thisTemplate = filter_input(INPUT_GET, 'name') ? filter_input(INPUT_GET, 'name') : '';

$cfg->templateName = $thisTemplate ? $thisTemplate : 'default';
$cfg->templateUrl = $cfg->templatePath.$cfg->templateName.'/';

include('includes/other-settings.php');
include($cfg->templateLoc.$cfg->templateName.'/index.php');