<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$contestObj = new Contest($dbObj); // Create an object of Contest class
$errorArr = array(); //Array of errors
$oldHeader = ""; $newHeader =""; $oldImage=""; $newImage =""; $contestLogoFil="";

if(!isset($_SESSION['SWPLoggedInAdmin']) || !isset($_SESSION["SWPadminEmail"])){ 
    $json = array("status" => 0, "msg" => "You are not logged in."); 
    header('Content-type: application/json');
    echo json_encode($json);
}
else{
    if(filter_input(INPUT_POST, "fetchContests") != NULL){
        $requestData= $_REQUEST;
        $columns = array(0 => 'status', 1 => 'status', 2 => 'id', 3 => 'title', 4 => 'intro', 5 => 'description', 6 => 'header', 7 => 'logo', 8 => 'start_date', 9 => 'end_date', 10 => 'announcement_date', 11 => 'winners', 12 => 'question', 13 => 'answer', 14 => 'point', 15 => 'bonus_point', 16 => 'rules', 17 => 'prize', 18 => 'message', 19 => 'css', 20 => 'date_added', 21 => 'announce_winner', 22 => 'restart', 23 => 'restart_interval');

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
    
    if(filter_input(INPUT_GET, "activateContest")!=NULL){
        $postVars = array('id', 'status'); // Form fields names
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'status':  $contestObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar, FILTER_VALIDATE_INT)) :  0; 
                                if($contestObj->$postVar == 1) {$contestObj->$postVar = 0;} 
                                elseif($contestObj->$postVar == 0) {$contestObj->$postVar = 1;}
                                break;
                default     :   $contestObj->$postVar = filter_input(INPUT_GET, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_GET, $postVar)) :  ''; 
                                if($contestObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        if(count($errorArr) < 1)   {
            echo Contest::updateSingle($dbObj, ' status ',  $contestObj->status, $contestObj->id); 
        }
        else{ 
            $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($errorArr)); 
            $dbObj->close();//Close Database Connection
            header('Content-type: application/json');
            echo json_encode($json);
        }

    }
    
    if(filter_input(INPUT_POST, "deleteThisContest")!=NULL){
        $postVars = array('id', 'header', 'logo'); // Form fields names
        $contestHeader = ""; $contestLogo = '';
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'header':   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                $contestHeader = $contestObj->$postVar;
                                if($contestObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
                case 'logo':   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                $contestLogo = $contestObj->$postVar;
                                //if($contestObj->$postVar === "") {array_push ($errorArr, "Please enter $postVar ");}
                                break;
                default     :   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($contestObj->$postVar === "") {array_push ($errorArr, " $postVar ");}
                                break;
            }
        }
        if(count($errorArr) < 1)   {
            $HeaderDelParam = true; $logoDelParam = true;
            if($contestHeader!='' && file_exists(MEDIA_FILES_PATH."contest-header/".$contestHeader)){
                if(unlink(MEDIA_FILES_PATH."contest-header/".$contestHeader)){ $HeaderDelParam = true;}
                else $HeaderDelParam = false;
            }
            if($contestLogo!='' && file_exists(MEDIA_FILES_PATH."contest-logo/".$contestLogo)){
                if(unlink(MEDIA_FILES_PATH."contest-logo/".$contestLogo)){ $logoDelParam = true;}
                else $logoDelParam = false;
            }
            if($HeaderDelParam == true && $logoDelParam ==true){ echo $contestObj->delete(); }
            else{ 
                $json = array("status" => 0, "msg" => $thisPage->showPlainErrors("Contest Deletion Failed! ERR: Image Problems")); 
                $dbObj->close();//Close Database Connection
                header('Content-type: application/json');
                echo json_encode($json);
            }
        }
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