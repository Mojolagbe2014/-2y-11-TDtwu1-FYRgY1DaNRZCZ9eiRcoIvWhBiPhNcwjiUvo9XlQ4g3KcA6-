<?php
/**
 * Description of General Setting
 *
 * @author Kaiste
 */
class Setting implements ContentManipulator{
    private $name;
    private $value;
    private static $dbObj = null;
    public static $tableName = "setting";
    
    
    //Class constructor
    public function Setting($dbObj=null, $tableName="setting") {
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
     * Method that adds a  setting into the database
     * @return JSON JSON encoded string/result
     */
    public function add(){
        $sql = "INSERT INTO ".self::$tableName." (name, value) "
                ."VALUES ('{$this->name}','{$this->value}')";
        if($this->notEmpty($this->value,$this->name)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, setting successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding  setting! ".  mysqli_error(self::$dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        self::$dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a  setting
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM ".self::$tableName." WHERE name = '$this->name' ";
        if($this->notEmpty($this->name)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  setting successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting  setting! ".  mysqli_error(self::$dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        self::$dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches settings from database for JQuery Data Table
     * @param string $column Column value of the data to be fetched
     * @param string $condition Additional condition e.g  setting_name > 9
     * @param string $sort column value to be used as sort parameter
     * @return JSON JSON encoded course setting details
     */
    public function fetchForJQDT($draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="name"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = self::$dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){ 
                $deleteActionLink = '<button data-name="'.$r['name'].'" class="btn btn-danger btn-sm delete-setting" title="Delete"><i class="btn-icon-only icon-trash"> </i> <span name="JQDTvalueholder" class="hidden">'.$r['value'].'</span></button>';
                $multiActionBox = '<input type="checkbox" class="multi-action-box" data-name="'.$r['name'].'" />';
                if($r['name']== "MAIN_ADMIN_EMAIL"){ $deleteActionLink = ''; $multiActionBox ='';}
                $result[] = array(utf8_encode($multiActionBox), utf8_encode($r['name']), utf8_encode(StringManipulator::trimStringToFullWord(90, stripcslashes(strip_tags($r['value'])))), utf8_encode(' <button data-name="'.$r['name'].'" class="btn btn-info btn-sm edit-setting"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span id="JQDTvalueholder" class="hidden">'.$r['value'].'</span> </button> '.$deleteActionLink));
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error(self::$dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches settings from database
     * @param string $column Column value of the data to be fetched
     * @param string $condition Additional condition e.g  setting_name > 9
     * @param string $sort column value to be used as sort parameter
     * @return JSON JSON encoded course setting details
     */
    public function fetch($column="*", $condition="", $sort="name"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
        $data = self::$dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("name" => $r['name'], "value" =>  utf8_encode($r['value']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Empty result. ".mysqli_error(self::$dbObj->connection)); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches settings from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_name > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array FAQ list
     */
    public function fetchRaw($column="*", $condition="", $sort="name"){
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
    
    /** Method that update single field detail of a  setting
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $name Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $name){
        $sql = "UPDATE ".self::$tableName." SET $field = '{$value}' WHERE name = $name ";
        if(!empty($name)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  setting successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating  setting! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a  setting
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE ".self::$tableName." SET value = '{$this->value}' WHERE name = '$this->name' ";
        if(!empty($this->name)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done,  setting successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating  setting! ".  mysqli_error(self::$dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }

    /** getValue() fetches the value of a setting using the setting $name
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $name Category name of the  setting whose value is to be fetched
     * @return string Name of the  setting
     */
    public static function getValue($dbObj, $name) {
        $thisSettingValue = ''; $table = Setting::$tableName;
        $thisSettingValues = $dbObj->fetchNum("SELECT value FROM $table WHERE name = '{$name}' LIMIT 1");
        foreach ($thisSettingValues as $thisSettingValues) { $thisSettingValue = $thisSettingValues[0]; }
        return $thisSettingValue;
    }
}
