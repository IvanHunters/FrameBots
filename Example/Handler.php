<?php
namespace Bot;
$platform = $platforms[$_GET['platform']];
require "../../{$platform}/CallbackBotLib.php";

class Bot extends \Callback\BOT{
    
    protected function message_new(){
    	switch ($this->text_lower) {
    	    case 'ping':
    	        $this->set_log($this);
    	        $this->construct_keyboard(["Ping", "Test"]);
    	        $this->upload_photo("https://web-zoopark.ru/wp-content/uploads/2018/06/2-428.jpg");
    	        $this->send("pong");
    	    break;
    	    
    	    default:
    	        $this->set_log($this);
    	        $this->send("ok");
    	    break;
    	}
    }
    
    protected function message_reply(){
        //Таким же образом расписываем события
    }
    
    function __tostring(){
        return var_export($this, true);
    }
}