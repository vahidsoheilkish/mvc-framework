<?php
require_once("config.php");
class Db{
    private $con;
    private static $mysqli;

    public static function getConnect(){
        if(self::$mysqli == null){
            self::$mysqli = new Db();
        }
        return self::$mysqli;
    }

    public function __construct(){
        global $config;
        $host = $config['db']['host'];
        $user = $config['db']['user'];
        $pass = $config['db']['pass'];
        $name = $config['db']['name'];

        $this->con = new mysqli("$host" , "$user" , "$pass" , "$name");
        $this->con->query("SET NAMES UTF8");
        if($this->con->connect_error){
            echo "connection failed";
            exit;
        }
    }

    public function succesConnect(){
        if(!$this->con->connect_error){
            echo "successfully connect";
        }
    }

    private function safeQuery(&$sql , $data = array() ){
        foreach ($data as $key=>$value){
            $value = $this->con->real_escape_string($value);
            $value = "'$value'";

            $sql = str_replace(":$key" , $value , $sql);

        }
        return $this->con->query($sql);
    }

    public function query($sql , $data = array()){
        $result = $this->safeQuery($sql , $data);
        if(!$result){
            echo "Query : " . $sql . " Failed due to " . mysqli_error($this->con);
            exit;
        }
        $records = array();
        $result = $this->safeQuery($sql , $data );

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                $records[] = $row;
            }
            return $records;
        }else{
            return null;
        }
    }

    public function query2($sql){
        $records = array();
        $result = $this->con->query($sql);

        if($result->num_rows > 0){
            while ($row = $result->fetch_array()) {
                $records[] = $row;
            }
            return $records;
        }else{
            return 0;
        }
    }

    public function hasExist($sql , $data = array() ){
        $res = $this->safeQuery($sql , $data);
        if($res->num_rows > 0 ){
            return true;
        }
        return false;
    }

    public function insert($sql , $data = array() ){
        $done = $this->safeQuery($sql , $data);
        return $done;
    }

    public function last_insert_id(){
        $last = $this->con->insert_id;
        return $last;
    }

    public function first($sql , $data = array()){
        $record = $this->safeQuery($sql , $data);
        if($record == null){
            return null;
        }
        return $record[0];
    }

    public function modify($sql , $data = array() ){
        $rowAffected = $this->safeQuery($sql , $data);
        return $rowAffected;
    }

    public function connect(){
        return $this->con;
    }

    public function close(){
        return $this->con->close();
    }


} // end of class
?>