<?php 
include("includes/constants.php");//includes predefined constants
include(DB_CONFIG_FILE); //Include Databse manipulation handler file
require(WEBPAGE_FILE_PATH);

unset($cfg);
global $cfg;
$cfg = new stdClass();

$cfg->dbServer    = DB_SERVER;
$cfg->dbName    = DB_NAME;
$cfg->dbUser    = DB_USER;
$cfg->dbPass    = DB_PASSWORD;