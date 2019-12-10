<?php
namespace FB;

trait Messages{
    
    public function send($text_message, $user_id = false){
        if($this->keyboard)
            $message = ["attachment"=>["type"=>"template","payload"=>["template_type"=>"button","text"=>$text_message, "buttons"=>$this->keyboard]]];
        else 
            $message = array("text" => $text_message);
        
        if($user_id) $this->user_id = $user_id;
        $body_request = json_encode(["recipient"=>array("id"=>$this->user_id),
                                     "message"=>$message]);
        $response = $this->apiCall("messages",$body_request);
        
        return $response;
    }
    
    public function construct_keyboard($array_keyboard){
        foreach($array_keyboard as $but){
            if(!is_array($but)) $button['title']            = $but;
            if(!isset($but['type'])) $button['type']        = "postback";
            if(!isset($but['payload'])) $button['payload']  = $button['title'];
            $buttons[]                                      = $button;
        }
        $this->keyboard                                     = $buttons;
    }
}