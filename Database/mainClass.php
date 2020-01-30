<?php

class DB{
    function __construct($user, $password, $database = false, $host = false){
    
        if(!$database) $database = $user;
        if(!$host) $host = "127.0.0.1";
        
        $this->mysqli = new mysqli($host, $user, $password, $database);
        
        mysqli_query($this->mysqli,"SET character_set_client='utf8mb4'");
        mysqli_query($this->mysqli,"SET character_set_connection='utf8mb4'");
        mysqli_query($this->mysqli,"SET character_set_results='utf8mb4'");
        
    }
    
    function exq($query, $flag = false){
    
        $result = $this->mysqli->query($query);
        if($flag || preg_match("/delete|update/imu", $query)) return $result;
        
        if(preg_match("/insert/imu", $query)){
        
            file_put_contents("log", var_export($this->mysqli->insert_id, true));
            $response  = (int)$this->mysqli->insert_id;
            return $response;
            
        }
        $result_fin = $result->fetch_assoc();
        $result_fin['count_rows'] = $result->num_rows;
        
        return $result_fin;
        
    }
}
?>