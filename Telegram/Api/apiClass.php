<?php

class Telegram{
    
    public function __construct($token){
        $this->token = $token;
        
    }
    protected function curl($url,$param){
        usleep(334000);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HEADER, false);
    	curl_setopt ($ch, CURLOPT_PROXY, "163.172.152.52:8811"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	$data = curl_exec($ch); // Выполняем запрос
    	curl_close($ch); // Закрываем соединение
    	return $data; // Парсим JSON и отдаем
    }
    
    private function apiCall($method,$param){
        $url = "https://api.telegram.org/bot{$this->token}/{$method}";
        $return = $this->curl($url,$param);
    }
    
    public function message_send($text_message, $user_id = false){
            if($user_id) $this->user_id = $user_id;
            $array_parametrs = array("chat_id"=>$this->user_id, "text"=>$text_message);
            if($this->keyboard) $array_parametrs['reply_markup'] = $this->keyboard;
            $response = $this->apiCall("sendMessage", $array_parametrs);
    }
    
    public function construct_keyboard($buttons, $type_keyboard="inline"){
        if($type_keyboard == "inline")
            $name_keyboard = "inline_keyboard";
        elseif($type_keyboard == "normal"){
            $name_keyboard = "keyboard";
            $keyboard["resize_keyboard"] = true;
            $keyboard["one_time_keyboard"] = true;
        }else
            $this->message_send("Неправильно указан тип клавиатуры.");
        foreach($buttons as $key=>$button)  $keyboard[$name_keyboard][0][] = ["text"=>$button[0], "callback_data"=>$button[1]];
        
        $this->keyboard = json_encode($keyboard);
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