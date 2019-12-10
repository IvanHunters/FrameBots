<?php
namespace Callback;
require "Api/apiClass.php";

class BOT extends \VK\API{
    
    public function __construct($confirm, $t_group, $t_user = false, $t_db = false){
        parent::__construct($t_group, $t_user);
        $this->varchar_init($confirm, $t_group, $t_user, $t_db);
    }
    
    function return_ok($return = true){
        
        ob_start();
        if($return)    echo "ok";
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
    
    private function varchar_init($confirm, $t_group, $t_user, $t_db){
        
        $this->data = $data = json_decode(file_get_contents('php://input'));
        $this->confirm = $confirm;
        
        if($data->type == "confirmation")   $this->return_ok(false);
        else $this->return_ok();
        
        $this->db = $t_db;
        $this->confirm  = $confirm;
        
        $this->token_user   = $t_user;
        $this->token_group  = $t_group;
        
        $this->chat_id         = $data->object->message->peer_id;
    	$this->user_id      = $data->object->message->from_id;
    	$this->group_id     = $data->group_id;
    	$this->id_message   = $data->object->message->id;
    	$this->text         = $data->object->message->text;
    	$this->text_lower   = preg_replace("/\[(.*)\]\s/","",mb_strtolower($this->text));
	    $this->publish_date = $data->object->message->date;
        
        $this->{$data->type}();
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