<?php

class DBController {
    
    private $host = "";
    private $user = "";
    private $password = "";
    private $database = "";
    private $conn;
    
    public function __construct(){
        $get_arguments       = func_get_args();
        $number_of_arguments = func_num_args();
        
        if (method_exists($this, $method_name = '__construct'.$number_of_arguments)) {
            call_user_func_array(array($this, $method_name), $get_arguments);
        }
        else{
           // throw new Exception("Unknown constructor arguments");
           //create instance based on values from config.
            $this->createInstance();
        }
    }
    
    public function createInstance(){
        
        require_once(FS_ROOT . "config.php");
        
        if(!DB_SERVER){
            throw new Exception("Unknown arguments. db_server var not set");
        }
        if(!DB_USER){
            throw new Exception("Unknown arguments. db_user var not set");
        }
        if(!DB_PASS){
            throw new Exception("Unknown arguments. db_pass var not set");
        }
        if(!DB_NAME){
            throw new Exception("Unknown arguments. db_name var not set");
        }
        
        $this->host = DB_SERVER;
        $this->user = DB_USER;
        $this->password = DB_PASS;
        $this->database = DB_NAME;

        $this->conn = $this->connectDB();
    }
    
    public function __construct4($host, $user, $pass, $database) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $pass;
        $this->database = $database;
        
        $this->conn = $this->connectDB();
    }
     
    function connectDB() {
        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $conn;
    }
    
    function runBaseQuery($query) {
        $result = mysqli_query($this->conn,$query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset))
            return $resultset;
    }
    
    
    
    function runQuery($query, $param_type, $param_value_array) {
        
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if(!empty($resultset)) {
            return $resultset;
        }
    }
    
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }
    
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        //$this->conn->commit();
       // $this->conn->close();
    }
    
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
    function getConnection() : mysqli{
        return $this->conn;
    }
    
    function close(){
        $this->getConnection()->close();
    }
}

