<?php
/**
 * Description of Contest
 *
 * @author Kaiste
 */
class Contest implements ContentManipulator{
    private $id;
    private $title;
    private $intro;
    private $description;
    private $header;
    private $logo;
    private $startDate;
    private $endDate;
    private $announcementDate;
    private $winners;
    private $question;
    private $answer;
    private $point;
    private $bonusPoint;
    private $rules;
    private $prize;
    private $message;
    private $css;
    private $status = 0;
    private $dateAdded = " CURRENT_DATE ";
    private $announceWinner = "Yes";
    private $restart = "No";
    private $restartInterval = 7;
    private $cutOffPoint;
    private $theme = 'default';
    private static $dbObj = null;
    public static $tableName = 'contest';
    
    
    /**
     * @param Object $dbObj Database connectivity and manipulation object
     * @param string $tableName Contest class table name in the database
     */
    public function Contest($dbObj=null, $tableName='contest') {
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
     * Method that adds a contest into the database
     * @return JSON JSON encoded string/result
     */
    function add(){
        $sql = "INSERT INTO ".self::$tableName." (`title`, `intro`, `description`, `header`, `logo`, `start_date`, `end_date`, `announcement_date`, `winners`, `question`, `answer`, `point`, `bonus_point`, `rules`, `prize`, `message`, `css`, `status`, `date_added`, `announce_winner`, `restart`, `restart_interval`, `cut_off_point`, `theme`) "
                ."VALUES ('{$this->title}','{$this->intro}','{$this->description}','{$this->header}','{$this->logo}','{$this->startDate}','{$this->endDate}','{$this->announcementDate}','{$this->winners}','{$this->question}','{$this->answer}','{$this->point}','{$this->bonusPoint}','{$this->rules}','{$this->prize}','{$this->message}','{$this->css}','{$this->status}',$this->dateAdded,'{$this->announceWinner}','{$this->restart}','{$this->restartInterval}','{$this->cutOffPoint}','{$this->theme}')";
        if($this->notEmpty($this->title,$this->header,$this->description,$this->intro)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, contest successfully added!"); }
            else{ $json = array("status" => 2, "msg" => "Error adding contest! ".  mysqli_error(self::$dbObj->connection)); }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted. All fields must be filled."); }
        
        self::$dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** 
     * Method for deleting a contest
     * @return JSON JSON encoded result
     */
    public function delete(){
        $sql = "DELETE FROM ".self::$tableName." WHERE id = $this->id ";
        if($this->notEmpty($this->id)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, contest successfully deleted!"); }
            else{ $json = array("status" => 2, "msg" => "Error deleting contest! ".  mysqli_error(self::$dbObj->connection));  }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        self::$dbObj->close();//Close Database Connection
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches contests from database for JQuery Data Table
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded contest details
     */
    public function fetchForJQDT($draw, $totalData, $totalFiltered, $customSql="", $column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
        if($customSql !=""){ $sql = $customSql; }
        $data = self::$dbObj->fetchAssoc($sql);
        $result =array();  $fetContestStat = 'icon-check-empty'; $fetContestRolCol = 'btn-warning'; $fetContestRolTit = "Activate Contest";
        if(count($data)>0){
            foreach($data as $r){ 
                $multiActionBox = '<input type="checkbox" class="multi-action-box" data-id="'.$r['id'].'" data-status="'.$r['status'].'" data-header="'.$r['header'].'" data-logo="'.$r['logo'].'" />';
                $fetContestStat = 'icon-check-empty'; $fetContestRolCol = 'btn-warning'; $fetContestRolTit = "Activate Contest";
                if($r['status'] == 1){  $fetContestStat = 'icon-check'; $fetContestRolCol = 'btn-success'; $fetContestRolTit = "De-activate Contest";}
                //$result[] = array(utf8_encode($multiActionBox), $r['id'], utf8_encode($r['title']), utf8_encode($r['intro']), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['description'])))), utf8_encode('<img src="../media/contest-header/'.utf8_encode($r['header']).'" width="60" height="50" style="width:60px; height:50px;" alt="Pix">'), utf8_encode('<img src="../media/contest-logo/'.utf8_encode($r['logo']).'" width="60" height="50" style="width:60px; height:50px;" alt="Pix">'), utf8_encode($r['start_date']), utf8_encode($r['end_date']), utf8_encode($r['announcement_date']), utf8_encode($r['winners']), utf8_encode($r['question']), utf8_encode($r['answer']), utf8_encode($r['point']), utf8_encode($r['bonus_point']), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['rules'])))), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['prize'])))), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['message'])))), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['css'])))), utf8_encode($r['date_added']), utf8_encode($r['announce_winner']), utf8_encode($r['restart']), utf8_encode($r['restart_interval']), utf8_encode(' <button data-id="'.$r['id'].'" data-title="'.$r['title'].'" data-intro="'.$r['intro'].'" data-header="'.$r['header'].'" data-logo="'.$r['logo'].'" data-start-date="'.$r['start_date'].'" data-end-date="'.$r['end_date'].'" data-announcement-date="'.$r['announcement_date'].'" data-winners ="'.$r['winners'].'" data-question="'.$r['question'].'" data-answer="'.$r['answer'].'" data-point="'.$r['point'].'" data-bonus-point="'.$r['bonus_point'].'" data-prize ="'.$r['prize'].'" data-message ="'.$r['message'].'"  data-css ="'.$r['css'].'" data-date-added="'.$r['date_added'].'" class="btn btn-info btn-sm edit-contest"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span class="hidden" id="JQDTrulesholder">'.$r['rules'].'</span> </button> <button data-id="'.$r['id'].'" data-title="'.$r['title'].'" data-status="'.$r['status'].'"  class="btn '.$fetContestRolCol.' btn-sm activate-contest"  title="'.$fetContestRolTit.'"><i class="btn-icon-only '.$fetContestStat.'"> </i></button> <button data-id="'.$r['id'].'" data-header="'.$r['header'].'"  data-logo="'.$r['logo'].'"  data-title="'.$r['title'].'" class="btn btn-danger btn-sm delete-contest" title="Delete"><i class="btn-icon-only icon-trash"> </i></button>'));//
                $result[] = array(utf8_encode($multiActionBox), utf8_encode('<div style="white-space:nowrap"> <button data-id="'.$r['id'].'" data-title="'.$r['title'].'" data-intro="'.$r['intro'].'" data-header="'.$r['header'].'" data-logo="'.$r['logo'].'" data-start-date="'.$r['start_date'].'" data-end-date="'.$r['end_date'].'" data-announcement-date="'.$r['announcement_date'].'" data-winners ="'.$r['winners'].'" data-question="'.$r['question'].'" data-answer="'.$r['answer'].'" data-point="'.$r['point'].'" data-bonus-point="'.$r['bonus_point'].'" data-prize ="'.$r['prize'].'" data-message ="'.$r['message'].'"  data-css ="'.$r['css'].'" data-date-added="'.$r['date_added'].'" class="btn btn-info btn-sm edit-contest"  title="Edit"><i class="btn-icon-only icon-pencil"> </i> <span class="hidden" id="JQDTrulesholder">'.$r['rules'].'</span> </button> <button data-id="'.$r['id'].'" data-title="'.$r['title'].'" data-status="'.$r['status'].'"  class="btn '.$fetContestRolCol.' btn-sm activate-contest"  title="'.$fetContestRolTit.'"><i class="btn-icon-only '.$fetContestStat.'"> </i></button> <button data-id="'.$r['id'].'" data-header="'.$r['header'].'"  data-logo="'.$r['logo'].'" data-title="'.$r['title'].'" class="btn btn-danger btn-sm delete-contest" title="Delete"><i class="btn-icon-only icon-trash"> </i></button></div>'), $r['id'], utf8_encode($r['title']), utf8_encode($r['intro']), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['description'])))), utf8_encode('<img src="../media/contest-header/'.utf8_encode($r['header']).'" width="60" height="50" style="width:60px; height:50px;" alt="Pix">'), utf8_encode('<img src="../media/contest-logo/'.utf8_encode($r['logo']).'" width="60" height="50" style="width:60px; height:50px;" alt="Pix">'), utf8_encode($r['start_date']), utf8_encode($r['end_date']), utf8_encode($r['announcement_date']), utf8_encode($r['winners']), utf8_encode($r['question']), utf8_encode($r['answer']), utf8_encode($r['point']), utf8_encode($r['bonus_point']), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['rules'])))), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['prize'])))), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['message'])))), StringManipulator::trimStringToFullWord(60, utf8_encode(stripcslashes(strip_tags($r['css'])))), utf8_encode($r['date_added']), utf8_encode($r['announce_winner']), utf8_encode($r['restart']), utf8_encode($r['restart_interval']), utf8_encode($r['cut_off_point']), utf8_encode($r['theme']));
            }
            $json = array("status" => 1,"draw" => intval($draw), "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error(self::$dbObj->connection), "draw" => intval($draw),  "recordsTotal"    => intval($totalData), "recordsFiltered" => intval($totalFiltered), "data" => false); }
        self::$dbObj->close();
        //header('Content-type: application/json');
        return json_encode($json);
    }
    
    /** Method that fetches contests from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return JSON JSON encoded contest details
     */
    public function fetch($column="*", $condition="", $sort="id"){
        $sql = "SELECT $column FROM ".self::$tableName." ORDER BY $sort";
        if(!empty($condition)){$sql = "SELECT $column FROM ".self::$tableName." WHERE $condition ORDER BY $sort";}
        $data = self::$dbObj->fetchAssoc($sql);
        $result =array(); 
        if(count($data)>0){
            foreach($data as $r){
                $result[] = array("id" => $r['id'], "title" =>  utf8_encode($r['title']), "intro" =>  utf8_encode($r['intro']), 'description' =>  utf8_encode($r['description']), 'header' => utf8_encode($r['header']), 'logo' => utf8_encode($r['logo']), 'startDate' =>  utf8_encode($r['start_date']), 'endDate' =>  utf8_encode($r['end_date']), 'announcementDate' =>  utf8_encode($r['announcement_date']), 'winners' =>  utf8_encode($r['winners']), 'question' =>  utf8_encode($r['question']), 'answer' =>  utf8_encode($r['answer']), 'point' =>  utf8_encode($r['point']), 'bonusPoint' =>  utf8_encode($r['bonus_point']), 'rules' =>  utf8_encode($r['rules']), 'prize' =>  utf8_encode($r['prize']), 'message' =>  utf8_encode($r['message']), 'css' =>  utf8_encode($r['css']), 'status' =>  utf8_encode($r['status']), 'dateAdded' => utf8_encode($r['date_added']), 'announceWinner' => utf8_encode($r['announce_winner']), 'restart' => utf8_encode($r['restart']), 'restartInterval' => utf8_encode($r['restart_interval']), 'cutOffPoint' => utf8_encode($r['cut_off_point']), 'theme' => utf8_encode($r['theme']));
            }
            $json = array("status" => 1, "info" => $result);
        } 
        else{ $json = array("status" => 2, "msg" => "Necessary parameters not set. Or empty result. ".mysqli_error(self::$dbObj->connection)); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that fetches contests from database
     * @param string $column Column name of the data to be fetched
     * @param string $condition Additional condition e.g category_id > 9
     * @param string $sort column name to be used as sort parameter
     * @return Array Contests list
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
    
    /** Method that update single field detail of a contest
     * @param string $field Column to be updated 
     * @param string $value New value of $field (Column to be updated)
     * @param int $id Id of the post to be updated
     * @return JSON JSON encoded success or failure message
     */
    public static function updateSingle($dbObj, $field, $value, $id){
        $sql = "UPDATE ".self::$tableName." SET $field = '{$value}' WHERE id = $id ";
        if(!empty($id)){
            $result = $dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, contest successfully update!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating contest! ".  mysqli_error($dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        $dbObj->close();
        header('Content-type: application/json');
        return json_encode($json);
    }

    /** Method that update details of a contest
     * @return JSON JSON encoded success or failure message
     */
    public function update() {
        $sql = "UPDATE ".self::$tableName." SET title = '{$this->title}', intro = '{$this->intro}', description = '{$this->description}', header = '{$this->header}', logo = '{$this->logo}', start_date = '{$this->startDate}', end_date = '{$this->endDate}', announcement_date = '{$this->announcementDate}', winners = '{$this->winners}', question = '{$this->question}', answer = '{$this->answer}', point = '{$this->point}', bonus_point = '{$this->bonusPoint}', rules = '{$this->rules}', prize = '{$this->prize}', message = '{$this->message}', css = '{$this->css}', announce_winner = '{$this->announceWinner}', restart = '{$this->restart}', restart_interval = '{$this->restartInterval}', cut_off_point = '{$this->cutOffPoint}', theme = '{$this->theme}' WHERE id = $this->id ";
        if(!empty($this->id)){
            $result = self::$dbObj->query($sql);
            if($result !== false){ $json = array("status" => 1, "msg" => "Done, contest successfully updated!"); }
            else{ $json = array("status" => 2, "msg" => "Error updating contest! ".  mysqli_error(self::$dbObj->connection));   }
        }
        else{ $json = array("status" => 3, "msg" => "Request method not accepted."); }
        self::$dbObj->close();
        header('Content-type: application/json');
        return json_encode($json); 
    }
    
    /** getName() fetches the name of a contest using the contest $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param int $id Category id of the category whose name is to be fetched
     * @return string Name of the category
     */
    public static function getName($dbObj, $id) {
        $thisContestName = '';
        $thisContestNames = $dbObj->fetchNum("SELECT title FROM ".self::$tableName." WHERE id = '{$id}' LIMIT 1");
        foreach ($thisContestNames as $thisContestNames) { $thisContestName = $thisContestNames[0]; }
        return $thisContestName;
    }

    
    /** getSingle() fetches the title of an contest using the contest $id
     * @param object $dbObj Database connectivity and manipulation object
     * @param string $column Table's required column in the datatbase
     * @param int $id Contest id of the contest whose name is to be fetched
     * @return string Name of the contest
     */
    public static function getSingle($dbObj, $column, $id) {
        $field = intval($id) ? "id = '{$id}' " : " title LIKE '%{$id}%' ";
        $thisAsstReqVal = '';
        $thisAsstReqVals = $dbObj->fetchNum("SELECT $column FROM ".self::$tableName." WHERE $field ORDER BY id LIMIT 1");
        foreach ($thisAsstReqVals as $thisAsstReqVals) { $thisAsstReqVal = $thisAsstReqVals[0]; }
        return $thisAsstReqVal;
    }
    
    /**
     * Method that returns count/total number of a particular contest
     * @param Object $dbObj Datatbase connectivity object
     * @return int Number of contests
     */
    public static function getRawCount($dbObj){
        $sql = "SELECT * FROM ".self::$tableName." ";
        $count = "";
        $result = $dbObj->query($sql);
        $totalData = mysqli_num_rows($result);
        if($result !== false){ $count = $totalData; }
        return $count;
    }
    
    /**
     * getWinners gets all winners of the contest 
     * @return string List of winners or error message
     */
    public function getWinners(){
        $d1 = new DateTime(date('j F Y H:i'));
        $d2 = new DateTime(str_replace(" - ", " ", $this->endDate));
        
        if($d1>=$d2){
            if($this->announceWinner == "Yes")
                return Entrant::getWinners($this->id, $this->cutOffPoint, $this->winners);
            else if($this->announceWinner == "No"){
                $dd1 = new DateTime(date('j F Y H:i'));
                $dd2 = new DateTime(str_replace(" - ", " ", $this->announcementDate));
                if($dd1>=$dd2) return Entrant::getWinners($this->id, $this->cutOffPoint, $this->winners);
                else return "<em style='color:red;font-weight:bold;'>Winners are yet to be announced!</em> <p>Please check back. Winner announcement date is $this->announcementDate </p>";
            }
        } else{
            return "<p>The contest/sweepstakes is still ongoing please check back. This contest will end on <strong>".str_replace("-", "at", $this->endDate)."</strong></p>";
        }
    }
}
