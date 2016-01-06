<?php
/**
 * Description of Entrant
 *
 * @author Kaiste
 */
class Entrant implements ContentManipulator{
    private $id;
    private $email;
    private $friends;
    private $names;
    private $timeEntered;
    private $contest;
    private $point;
    private static $dbObj;
    public static $tableName = __CLASS__;

    //Class constructor
    public function Entrant($dbObj=null, $tableName=__CLASS__) {
        self::$dbObj = $dbObj;        
        self::$tableName = $tableName;
    }
    
    //Using Magic__set and __get
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    
    /**  
     * Method that adds a entrant into the database
     * @return JSON JSON encoded string/result
     */
    function add(){
        $sql = "INSERT INTO ".self::$tableName." (email, friends, names, time_entered, contest, point) "
                ."VALUES ('{$this->email}','{$this->friends}','{$this->names}','". time()."','{$this->contest}','{$this->point}')";
        if($this->notEmpty($this->friends,$this->email,$this->contest)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, entrant successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding entrant! ".  mysqli_error(self::$dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        self::$dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /**  
     * Method that adds a entrant into the database
     * @return string Sucess|Error
     */
    function addRaw(){
        $sql = "INSERT INTO ".self::$tableName." (email, friends, names, time_entered, contest, point) "
                ."VALUES ('{$this->email}','{$this->friends}','{$this->names}','". time()."','{$this->contest}','{$this->point}')";
        if($this->notEmpty($this->friends,$this->email,$this->contest)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** 
     * Method for deleting a entrant
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM ".self::$tableName." WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, entrant successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting entrant! ".  mysqli_error(self::$dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        self::$dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches entrants from database for JQuery Data Table
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded entrant details
     */
    public function fetchForJQDT($draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = self::$dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){ 
                $actionButtons = '<div style="white-space:nowrap"> <button data-id="'.$r['id'].'" data-email="'.$r['email'].'" class="btn btn-danger btn-sm delete-entrant" title="Delete"><i class="btn-icon-only icon-trash"> </i></button> </div>';//'<button data-email="'.$r['email'].'" data-id="'.$r['id'].'" class="btn btn-success btn-sm message-entrant"  title="Send Message"><i class="btn-icon-only icon-envelope"> </i></button> ';
                $multiActionBox = '<input type="checkbox" class="multi-action-box" data-id="'.$r['id'].'" />';
                $result[] = array(utf8_encode($multiActionBox), utf8_encode($actionButtons), $r['id'],  utf8_encode(Contest::getName(self::$dbObj, $r['contest'])), utf8_encode($r['email']), utf8_encode(str_replace(",", ", ", $r['friends'])), utf8_encode($r['names']),  utf8_encode($r['time_entered']), utf8_encode($r['point']));
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error(self::$dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches entrants from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded entrant details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM entrant WHERE $condition ORDER BY $sort";}
        $data = self::$dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "email" =>  utf8_encode($r['email']), 'friends' =>  utf8_encode($r['friends']), 'names' =>  utf8_encode($r['names']), 'timeEntered' =>  utf8_encode($r['time_entered']), 'contest' =>  utf8_encode($r['contest']), 'point' =>  utf8_encode($r['point']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error(self::$dbObj->connection)); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches entrant from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Entrant list
     */
    public function fetchRaw($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
        $result = self::$dbObj->fetchAssoc($sql);
        return $result;
    }
    
    /** Empty string checker  
     * @return Booloean True|False
     */
    public function notEmpty() {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) { return false; } 
            else {continue; }
        }
        return true;
    }
    
    /** Method that update single field detail of a entrant
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id or email of the entrant to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $det = intval($id) ? "id" : "email";
        $sql = "UPDATE ".self::$tableName." SET $field = '{$value}' WHERE $det = '$id' ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, entrant successfully updated!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating entrant! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that update single field detail of a entrant
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id or email of the entrant to be updated
     * @return string success|error
     */
    public static function updateSingleRaw($dbObj, $field, $value, $id){
        $det = intval($id) ? "id" : "email";
        $sql = "UPDATE ".self::$tableName." SET $field = '{$value}' WHERE $det = '$id' ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    /** Method that update details of a entrant
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE ".self::$tableName." SET friends = '{$this->friends}', names = '{$this->names}', point = '{$this->point}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, entrant successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating entrant! ".  mysqli_error(self::$dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }
    
    /** Method that update details of a entrant
     * @return string Sucess|Error
     */
    public function updateRaw() {
        $sql = "UPDATE ".self::$tableName." SET friends = '{$this->friends}', names = '{$this->names}', point = '{$this->point}' WHERE email = '{$this->email}' ";
        if(!empty($this->email)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ return 'success'; }
            else{ return 'error';    }
        }
        else{return 'error'; }
    }

    
    /** emailExists checks if an email truely exists in the database
     * @return Boolean True for exists, while false for not
     */
    public function emailExists(){//password_verify($password, $hash)
        $sql =  "SELECT * FROM ".self::$tableName." WHERE email = '$this->email' AND contest = '$this->contest' LIMIT 1 ";
        $storedEmail = '';
        $results = self::$dbObj->fetchAssoc($sql);
        foreach ($results as $result) {
            $storedEmail = $result['email'];
        }
        if($this->email == $storedEmail){ return true; }
        else{ return false;    }
    } 
    
    /** getSingle() fetches a single column of an entrant using $email or $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param string $email Entrant email or ID of the entrant whose name is to be fetched
     * @return string Name of the entrant
     */
    public static function getSingle($dbObj, $column, $email) {
        $field = intval($email) ? "id" : "email";
        $thisReqVal = '';
        $thisReqVals = $dbObj->fetchNum("SELECT $column FROM ".self::$tableName." WHERE $field = '{$email}' ");
        foreach ($thisReqVals as $thisReqVals) { $thisReqVal = $thisReqVals[0]; }
        return $thisReqVal;
    }
    
    
    /**
     * getWinners method fetches winners based on the setted criteria using contest id - $contest
     * @param string $contest Contest id
     * @param int $cutOffPoint Point Limit
     * @param int $noOfWinners Number of winners required
     * @return string List of winner's email
     */
    public static function getWinners($contest, $cutOffPoint, $noOfWinners){
        $returnVal = "<ul>"; $sn=1;
        
        $winners = self::$dbObj->fetchAssoc("SELECT * FROM ".self::$tableName." WHERE contest = $contest AND point >= $cutOffPoint ORDER BY point DESC LIMIT $noOfWinners");
        if(count($winners)>0){
            foreach($winners as $winner){ $returnVal .= "<li>$sn. ".$winner['email']." [".$winner['point']." points] </li>"; $sn++;}
        } else{ $returnVal .= "<li>No winners chosen because minimum point ($cutOffPoint) is not reached.</li>"; }
        return $returnVal."</ul>";
    }
}
//$date=date_create("2013-03-15 23:40:00");