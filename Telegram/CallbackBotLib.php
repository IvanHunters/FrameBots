<?php
include "Api/apiClass.php";

class TelegramBot extends Telegram{
    
    public function __construct($token, $db_obj = false){
        $this->token = $token;
        $this->db = $db_obj;
        $data = $this->data = json_decode(file_get_contents('php://input'), true);
        
        if(isset($data["callback_query"])) $this->method_require = "keyboard_message";
        if(isset($data['message'])) $this->method_require = "message";
        if($this->method_require == "message"){
            $this->message = $data["message"];
            $this->message_text = $this->message["text"];
            $this->message_text_lower = preg_replace("/\//","",mb_strtolower($this->message_text));
        }elseif ($this->method_require == "keyboard_message") {
            $this->message = $data["callback_query"];
            $this->message["chat"]["id"] = $this->message["from"]["id"];
            $this->message_text = $this->message["data"];
            $this->message_text_lower = preg_replace("/\//","",mb_strtolower($this->message_text));
        }
        
        $this->user_id = $this->message["from"]["id"];
        $this->user->first_name = $this->message["from"]["first_name"];
        $this->user->last_name = $this->message["from"]["last_name"];
        
        if($this->message["from"]["id"] == $this->message["chat"]["id"]){
            $this->actions = "message_new";
        }else{
            $this->actions = "message_reply";
            $this->chat_id = $this->message["chat"]["id"];
        }
        $this->keyboard = false;
        $this->set_log(print_r($this, true));
        $this->{$this->actions}();
    }
    
    public function set_webhook($url){
        var_dump($this->curl("https://api.telegram.org/bot{$this->token}/setWebhook", array("url"=>$url)));
    }
}