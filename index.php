<?php 
session_start();
include('config/config.php');
define("CURRENT_PAGE", "home");

$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj, 'webpage'); //Create new instance of webPage class

include('includes/other-settings.php');
require('includes/page-properties.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
/**
 * Note that the salt here is randomly generated.
 * Never use a static salt or one that is not randomly generated.
 *
 * For the VAST majority of use-cases, let password_hash generate the salt randomly for you
 */
$options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
echo password_hash("sweepstake", PASSWORD_BCRYPT, $options)."\n";
?>
    </body>
</html>
