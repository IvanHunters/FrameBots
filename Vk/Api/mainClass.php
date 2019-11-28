<?php
namespace VK;
class Main{
    
    protected $token_user, $token_group, $messages;
    
    public function __construct($tokenGroup, $tokenUser) {
        $this->token_group = $tokenGroup;
        $this->token_user  = $tokenUser;
    }

    function get_token ($why){
        echo $this->$why;
    }

    function curl($link, $param,$flag=false){
        usleep(334000);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $link);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    	if($flag)
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); // отключить валидацию ssl
    	curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
    	curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:')); // это необходимо, чтобы cURL не высылал заголовок на ожидание
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $param); // Данные для отправки
    	$data = curl_exec($ch); // Выполняем запрос
    	curl_close($ch); // Закрываем соединение
    	return json_decode($data,true); // Парсим JSON и отдаем
    
    }
    
    function apiCallGroup($method,$param){
        $param['access_token']= $this->token_group;
        return $this->curl("https://api.vk.com/method/$method?v=5.85", $param);
    }
    
    function apiCallUser($method,$param){
        $param['access_token']= $this->token_user;
        return $this->curl("https://api.vk.com/method/$method?v=5.103", $param);
    }
}