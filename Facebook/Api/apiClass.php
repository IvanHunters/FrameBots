<?php

class Facebook{
    
    public function __construct($token){
        $this->token = $token;
    }
    
    private function curl($url,$param){
        usleep(334000);
        $headers = ['Content-Type: application/json',];
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $param); // Данные для отправки
    	$data = curl_exec($ch); // Выполняем запрос
    	curl_close($ch); // Закрываем соединение
    	return $data; // Парсим JSON и отдаем
    }
    
    private function apiCall($method,$param){
        $url = "https://graph.facebook.com/v2.6/me/{$method}?access_token={$this->token}";
        return $this->curl($url,$param);
    }
    
    
    public function construct_keyboard($array_keyboard){
        foreach($array_keyboard as $but){
            if(!is_array($but)) $button['title'] = $but;
            if(!isset($but['type'])) $button['type'] = "postback";
            if(!isset($but['payload'])) $button['payload'] = $button['title'];
            $buttons[]=$button;
        }
        $this->keyboard = $buttons;
    }
    
    public function message_send($text_message, $user_id = false){
        if($this->keyboard)
            $message = ["attachment"=>["type"=>"template","payload"=>["template_type"=>"button","text"=>$text_message, "buttons"=>$this->keyboard]]];
        else 
            $message = array("text"=>$text_message);
        
        if($user_id) $this->sender_id = $user_id;
        $body_request = json_encode(["recipient"=>array("id"=>$this->sender_id),
                                     "message"=>$message]);
        $response = $this->apiCall("messages",$body_request);
        
        return $response;
    }
    
    function set_log($log_message){
        if(isset($this->fp))
            fwrite($this->fp,$log_message);
        else{
            $this->fp = fopen("log","w");
            fwrite($this->fp,$log_message);
        }
    }
}