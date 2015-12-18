<?php
session_start();
include('../config/config.php');
$dbObj = new Database($cfg);//Instantiate database
$thisPage = new WebPage($dbObj); //Create new instance of webPage class

$contestObj = new Contest($dbObj); // Create an object of Contest class
$errorArr = array(); //Array of errors
$oldHeader = ""; $newHeader =""; $oldLogo=""; $newLogo =""; $contestLogoFil=""; $contestHeaderFil = "";

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
        $postVars = array('id','title','intro','description','header','logo','startDate','endDate','announcementDate','winners', 'question', 'answer', 'point', 'bonusPoint', 'rules', 'prize', 'message', 'css', 'announceWinner', 'restart', 'restartInterval'); // Form fields names
        $oldHeader = $_REQUEST['oldHeader']; $oldLogo = $_REQUEST['oldLogo'];
        //Validate the POST variables and add up to error message if empty
        foreach ($postVars as $postVar){
            switch($postVar){
                case 'header':  $newHeader = basename($_FILES["header"]["name"]) ? rand(100000, 1000000)."_".  StringManipulator::slugify(filter_input(INPUT_POST, 'title')).".".pathinfo(basename($_FILES["header"]["name"]),PATHINFO_EXTENSION): ""; 
                                $contestObj->$postVar = $newHeader;
                                if($contestObj->$postVar == "") { $contestObj->$postVar = $oldHeader;}
                                $contestHeaderFil = $newHeader;
                                break;
                case 'logo':    $newLogo = basename($_FILES["logo"]["name"]) ? rand(100000, 1000000)."_".  StringManipulator::slugify(filter_input(INPUT_POST, 'title')).".".pathinfo(basename($_FILES["logo"]["name"]),PATHINFO_EXTENSION): ""; 
                                $contestObj->$postVar = $newLogo;
                                if($contestObj->$postVar == "") { $contestObj->$postVar = $oldLogo;}
                                $contestLogoFil = $newLogo;
                                break;
                case 'css':     $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                break;
                default     :   $contestObj->$postVar = filter_input(INPUT_POST, $postVar) ? mysqli_real_escape_string($dbObj->connection, filter_input(INPUT_POST, $postVar)) :  ''; 
                                if($contestObj->$postVar == "") {array_push ($errorArr, " $postVar ");}
                                break;
                
            }
        }
        if(count($errorArr) < 1)   {
            $targetHeader = MEDIA_FILES_PATH."contest-header/". $contestHeaderFil;
            $targetLogo = MEDIA_FILES_PATH."contest-logo/". $contestLogoFil;
            $uploadOk = 1; $msg = '';
            $imageFileType = pathinfo($targetHeader,PATHINFO_EXTENSION);
            
            if($newHeader !=""){
                if (move_uploaded_file($_FILES["header"]["tmp_name"], MEDIA_FILES_PATH."contest-header/".$contestHeaderFil)) {
                    $msg .= "The file ". basename( $_FILES["header"]["name"]). " has been uploaded.";
                    $status = 'ok'; if($oldHeader!='' && file_exists(MEDIA_FILES_PATH."contest-header/".$oldHeader)) unlink(MEDIA_FILES_PATH."contest-header/".$oldHeader); $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
            if($newLogo !=""){
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], MEDIA_FILES_PATH."contest-logo/".$contestLogoFil)) {
                    $msg .= "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
                    $status = 'ok'; if($oldLogo!='' && file_exists(MEDIA_FILES_PATH."contest-logo/".$oldLogo))unlink(MEDIA_FILES_PATH."contest-logo/".$oldLogo); $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
            
            if($uploadOk == 1){ echo $contestObj->update(); }
            else {
                $msg = " Sorry, there was an error uploading your contest header. ERROR: ".$msg;
                $json = array("status" => 0, "msg" => $thisPage->showPlainErrors($msg)); 
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
}