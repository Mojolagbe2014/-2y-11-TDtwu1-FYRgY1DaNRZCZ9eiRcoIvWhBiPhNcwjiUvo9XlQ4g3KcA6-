<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$contestObj = new Contest($dbObj); // Create an object of Contest class
$errorArr = array(); //Array of errors

if(!isset($_SESSION['SWPLoggedInAdmin']) || !isset($_SESSION["SWPadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchContests") != NULL){
        $requestData= $_REQUEST;
        $columns = array(0 => 'id', 1 => 'title', 2 => 'intro', 3 => 'description', 4 => 'header', 5 => 'logo', 6 => 'startDate', 7 => 'endDate', 8 => 'announcementDate', 9 => 'winners', 10 => 'question', 11 => 'answer', 12 => 'point', 13 => 'bonusPoint', 14 => 'rules', 15 => 'prize', 16 => 'message', 17 => 'css', 18 => 'announceWinner', 19 => 'restart', 20 => 'restartInterval', 21 => 'status');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM ".$contestObj::$tableName);
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM ".$contestObj::$tableName." WHERE 1=1 ";
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( title LIKE '%".$requestData['search']['value']."%' ";   
                $sql.=" OR intro LIKE '%".$requestData['search']['value']."%' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

        echo $contestObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    
    if(filter_input(INPUT_POST, "deleteThisContest")!=NULL){
        $postVars = array('name'); // Form fields names
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($contestObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        if(count($errorArr) < 1)   { echo $contestObj->delete(); }
        else{ 
            $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($errorArr)); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    } 
    
    if(filter_input(INPUT_POST, "editContest") != NULL){
        $postVars = array('value', 'name'); // Form fields names
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($contestObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        if(count($errorArr) < 1)   { echo $contestObj->update(); }
        else{ 
            $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($errorArr)); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    } 
}