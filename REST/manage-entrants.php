<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$entrantObj = new Entrant($dbObj); // Create an object of Entrant class
$errorArr = array(); //Array of error

if(!isset($_SESSION['SWPLoggedInAdmin']) || !isset($_SESSION["SWPadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_GET, "fetchEntrants") != NULL){
        $requestData= $_REQUEST;
        $columns = array(0 => 'id', 1 => 'id', 2 => 'id', 3 => 'contest', 4 => 'email', 5 => 'friends', 6 => 'names', 7 => 'time_entered', 8 => 'point');

        // getting total number records without any search
        $query = $dbObj->query("SELECT * FROM ".$entrantObj::$tableName);
        $totalData = mysqli_num_rows($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        $sql = "SELECT * FROM ".$entrantObj::$tableName." WHERE 1=1 ";
        if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                $sql.=" AND ( email LIKE '%".$requestData['search']['value']."%' ";   
                $sql.=" OR contest = '".Contest::getSingle($dbObj, 'id', $requestData['search']['value'])."' ) ";
        }
        $query = $dbObj->query($sql);
        $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

        echo $entrantObj->fetchForJQDT($requestData['draw'], $totalData, $totalFiltered, $sql);
    }
    
    if(filter_input(INPUT_GET, "sendEmail")!=NULL){
        $postVars = array('email'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $entrantObj->$postVar = filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_EMAIL) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_EMAIL)) :  ''; 
                                if($entrantObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        if(count($errorArr) < 1)   { }
        else{ 
            $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($errorArr)); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    
    if(filter_input(INPUT_POST, "deleteThisEntrant")!=NULL){
        $postVars = array('id'); // Form fields names
        $entrantHeader = ""; $entrantLogo = '';
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                default     :   $entrantObj->$postVar = filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_INT) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar, FILTER_VALIDATE_INT)) :  ''; 
                                if($entrantObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        if(count($errorArr) < 1)   { echo $entrantObj->delete(); }
        else{ 
            $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($errorArr)); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }
    }  
}