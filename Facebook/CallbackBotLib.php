<?php
include "Api/apiClass.php";

class FacebookBot extends Facebook{
    public function __construct($token, $db_obj = false, $group_id = false){
        $this->token = $token;
        $this->data = json_decode(file_get_contents('php://input'), true);
        $this->db = $db_obj;
    
        $this->message_body = $this->data['entry'][0]['messaging'];
        $this->sender_id = $this->message_body[0]['sender']['id'];
        $this->recipient_id = $this->message_body[0]['recipient']['id'];
        $this->group_id = $group_id? $group_id : "none";
        $this->keyboard = false;
        
        if(!isset($this->message_body[0]['postback']))
            $this->text_message = $this->message_body[0]['message']['text'];
        else
            $this->text_message = $this->message_body[0]['postback']['title'];
            
        $this->text_message_lower = mb_strtolower($this->text_message);
        
        if($this->sender_id == $this->group_id)
            $this->action = "message_new";
        else
            $this->action = "message_reply";
    
        if (isset($this->message_body[0]['delivery']) || isset($this->message_body[0]['read'])) die();
            
        $this->set_log(print_r($this,true));
        
        $this->{$this->actions}();
    }

}