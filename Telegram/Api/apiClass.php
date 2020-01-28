<?php
namespace TG;

require_once "messages.php";
require_once "photos.php";
require_once "docs.php";
/*require "audio.php";*/

class Main{
    
    protected $token;
    
    public function __construct($token, $proxy = false) {
        $this->token                = $token;
    }

    public function curl($url,$param){
        usleep(334000);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HEADER, false);
    	curl_setopt ($ch, CURLOPT_PROXY, $this->proxy); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	$data = curl_exec($ch); // Выполняем запрос
    	curl_close($ch); // Закрываем соединение
    	return $data; // Парсим JSON и отдаем
    }
    
    public function apiCall($method,$param){
        $url = "https://api.telegram.org/bot{$this->token}/{$method}";
        $return = $this->curl($url,$param);
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
    use Photos;
    use Docs;
    
    public function __construct($token, $proxy = false) {
        $this->token                = $token;
        $this->proxy                = $proxy;
        $this->keyboard             = false;
        $this->files_upload         = false;
    }
}
