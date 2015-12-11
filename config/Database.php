<?php

/** Database Class 
* It handles connection to database
* and database logic or oprations<br>
* It is a child of DbConfiguration 
*/
class Database {
    //Class data
    var $connection;

    public function Database($configObj=null){
        if($configObj==null) {
            die("Please  supply configuration object ");
        }
        else{
            $this->connection = $this->connect($configObj->dbServer, $configObj->dbUser, $configObj->dbPass,$configObj->dbName);
        } 
    }

    // Connect function for database access 
    public function connect($dbServer, $dbUser, $dbPass, $dbName) { 
       try { 
          return $mysqli = new mysqli($dbServer, $dbUser, $dbPass, $dbName); 
       } catch (mysqli_sql_exception $e) { 
          throw $e; 
       } 
    } 

    
    /** Method for querying database */
    public function query($query){
        $result = mysqli_query($this->connection, $query) or 
        die("Invalid Query: ".mysqli_error($this->connection));
        if($result){
            return $result;
        } else { return false; }
    }

    /** Method for fetching data as associate array( i.e using database field names) */
    public function fetchAssoc($query){
        $result = $this->query($query); 
        $rows = array();
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $rows[] = $row;
        }
        return $rows;
    }

    /** Method for fetching data as numeric array( i.e using database column as $row[0]) */
    public function fetchNum($query){
        $result = $this->query($query); 
        $rows = array();
        while($row = mysqli_fetch_array($result,MYSQLI_NUM)){
                $rows[] = $row;
        }
        return $rows;
    }

    /** Method for closing connection */
    public function close(){/** Method for closing connection */
        //If connection to database is on then close it
        if (isset($this->connection)) {
            mysqli_close($this->connection);
        }
    }
    
}
