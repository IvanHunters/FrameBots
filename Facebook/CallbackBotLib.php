<?php
namespace Callback;
require_once "Api/apiClass.php";

class BOT extends \FB\API{
    
    public $platform = 'fb';
    
    public function __construct($confirm_token, $token, $group_id, $status = true){
        global $db;
        
        $this->token            = $token;
        $this->db               = $db;
        
        if(isset($_GET['hub_mode']) && $_GET['hub_mode'] == "subscribe" && $_GET['hub_verify_token'] == $confirm_token) die($_GET["hub_challenge"]);
        $this->data             = json_decode(file_get_contents('php://input'), true);
    
        $this->message          = $this->data['entry'][0]['messaging'];
        $this->user_id          = $this->message[0]['sender']['id'];
        $this->recipient_id     = $this->message[0]['recipient']['id'];
        $this->group_id         = $group_id? $group_id : "none";
        
        if(isset($this->message[0]['delivery']) || isset($this->message[0]['read'])) die();
        if(!isset($this->message[0]['postback']))
            $this->text         = $this->message[0]['message']['text'];
        else
            $this->text         = $this->message[0]['postback']['title'];
            
        $this->text_lower       = mb_strtolower($this->text);
        
        if($this->sender_id != $this->group_id)
            $this->action       = "message_new";
        else
            $this->action       = "message_reply";
    
        if($status)
            $this->{$this->action}();
        elseif($this->action =="message_new")
            $this->send("Извините, бот выключен по техническим причинам.\nСпасибо за понимание");
    }

}