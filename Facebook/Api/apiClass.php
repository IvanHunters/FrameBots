<?php
namespace FB;

require_once "messages.php";
/*require_once "photos.php";
require_once "audio.php";
require_once "docs.php";*/

class Main{
    
    protected $token;
    public function __construct($token){
        $this->token = $token;
    }
    
    function curl($url,$param){
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
    
    function apiCall($method,$param){
        $url = "https://graph.facebook.com/v2.6/me/{$method}?access_token={$this->token}";
        return $this->curl($url,$param);
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

class API extends Main{
    
    use Messages;
/*  use Photos;
    use Docs;
    use Audio;*/
    
    public function __construct($token) {
        $this->token               = $token;
        
        $this->keyboard            = false;
        $this->attachment_for_send = false;
    }
    
}