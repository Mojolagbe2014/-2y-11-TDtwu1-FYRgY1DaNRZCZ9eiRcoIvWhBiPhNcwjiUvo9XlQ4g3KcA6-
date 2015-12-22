<?php 
/** Database Connection Strings */
define("SITE_URL","http://localhost/sweepstake/");
define("DB_NAME","sweepstake"); //iadet910_iadetmobile
define("DB_USER","root");//iadet910_mobile
define("DB_PASSWORD","");//@Kaiste&NstProduct2015
define("DB_SERVER","localhost");
define("__ROOT__",dirname(dirname(__FILE__)));
define("CLASSES_PATH", __ROOT__.'/classes/');
define("DB_CONFIG_FILE", __ROOT__.'/config/Database.php');
define("WEBPAGE_FILE_PATH", CLASSES_PATH.'WebPage.php');
define("MEDIA_FILES_PATH", '../media/');
define("MEDIA_FILES_PATH1", SITE_URL.'media/');
define("TEMPLATE_PATH", SITE_URL.'templates/');
define("TEMPLATE_LOCATION", __ROOT__.'/templates/');

include(DB_CONFIG_FILE); //Include Databse manipulation handler file
require(WEBPAGE_FILE_PATH);

unset($cfg);
global $cfg;
$cfg = new stdClass();//Create Configuration registry

$cfg->dbServer    = DB_SERVER;
$cfg->dbName    = DB_NAME;
$cfg->dbUser    = DB_USER;
$cfg->dbPass    = DB_PASSWORD;
$cfg->templatePath = TEMPLATE_PATH;
$cfg->templateLoc = TEMPLATE_LOCATION;
$cfg->templateName = 'default';
$cfg->templateUrl = $cfg->templatePath.$cfg->templateName.'/';