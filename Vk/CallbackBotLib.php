<?php
include "Api/apiClass.php";

class Vkbot extends Vk{
    function __construct($confirm, $t_group, $t_user = false, $t_db = false){
        $this->varchar_init($confirm, $t_group, $t_user, $t_db);
    }
    
    function return_ok($return){
        
        ob_start();
        if(is_null($return))    echo "ok";
        else echo $return;
        $size = ob_get_length();
        header("Content-Encoding: none");
        header("Content-Length: {$size}");
        header("Connection: close");
        ob_end_flush();
        ob_flush();
        flush();
        if(session_id()) session_write_close();
    }
    
    function varchar_init($confirm, $t_group, $t_user, $t_db){
        
        $this->data = $data = json_decode(file_get_contents('php://input'));
        $type = $data->type;
        
        if($type != "confirmation")
            $this->return_ok();
            
        $this->db = $t_db;
        $this->confirm  = $confirm;
        
        $this->token_user   = $t_user;
        $this->token_group  = $t_group;
        
        if(!is_null($type))
        $this->$type();
    }
    
    function type($type_name){
        if($this->data->type == $type_name){
            return true;
        } 
        else return false;
    }
    
    function confirmation(){
        $this->return_ok($this->confirm);
    }
    
}

?>