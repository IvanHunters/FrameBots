<?php
namespace Callback;
require_once "Api/apiClass.php";

class BOT extends \TG\API{
    
    public $platform = 'tg';
    
    public function __construct($token, $set_webhook = false, $proxy = false, $status = true){
        global $db;
        
        $this->proxy                        = $proxy;
        $this->token                        = $token;
        $this->db                           = $db;
        $this->keyboard                     = false;
        
        parent::__construct($this->token, $this->proxy);
        if($set_webhook) return $this->token;
        
        $data = $this->data = json_decode(file_get_contents('php://input'), true);
        
        if(isset($data["callback_query"])) $this->method_require = "keyboard_message";
        elseif(isset($data['message'])) $this->method_require = "message";
        else{
            print_r($this);
            die("\nFor Debug");
        }
        
        if($this->method_require == "message"){
            $this->message                  = $this->data["message"];
            $this->message_id               = $this->message['message']['message_id'];
            $this->text                     = $this->message["text"];
            $this->text_lower               = preg_replace("/\//","",mb_strtolower($this->text));
            
        }elseif ($this->method_require == "keyboard_message") {
            $this->message                  = $this->data["callback_query"];
            $this->message_id               = $this->message['message']['message_id'];
            $this->message["chat"]["id"]    = $this->message["from"]["id"];
            $this->text                     = $this->message["data"];
            $this->text_lower               = preg_replace("/\//","",mb_strtolower($this->text));
        }
        
        $this->user_id                      = $this->message["from"]["id"];
        $this->chat_id                      = $this->message["chat"]["id"];
        
        if($this->user_id == $this->chat_id){
            $this->action                   = "message_new";
        }else{
            $this->action                   = "message_reply";
            $this->chat_id                  = $this->message["chat"]["id"];
        }
        if($status)
            $this->{$this->action}();
        elseif($this->action =="message_new")
            $this->send("Извините, бот выключен по техническим причинам.\nСпасибо за понимание");
    }
    
    public function set_webhook($url){
        var_dump($this->curl("https://api.telegram.org/bot{$this->token}/setWebhook", array("url"=>$url)));
    }
}