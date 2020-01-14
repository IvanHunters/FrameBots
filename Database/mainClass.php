<?php

class DB{
    function __construct($user, $password, $database = false){
        if(!$database) $database = $user;
        $this->mysqli = new mysqli("127.0.0.1", $user, $password, $database);
    }
    
    function exq($query, $flag = false){
        $result = $this->mysqli->query($query);
        if($flag) return $result;
        $result_fin = $result->fetch_assoc();
        $result_fin['count_rows'] = $result->num_rows;
        return $result_fin;
    }
}
?>