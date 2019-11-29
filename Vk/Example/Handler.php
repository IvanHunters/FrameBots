<?php
namespace Bot;

require "../../Vk/CallbackBotLib.php";

class Bot extends \VKCallback\VKBot{
    
    protected function message_new(){
        $data = $this->data;
        $this->user_id = $data->object->from_id;
    	$this->message_id = $data->object->id;
    	$this->chat_id      = $data->object->peer_id;
    	$this->group_id      = $data->group_id;
    	$this->text    = $data->object->text;
    	$this->text_lower = preg_replace("/\[(.*)\]\s/","",mb_strtolower($this->text));
    	
	    $this->publish_date = $data->object->date;
	    $this->attachments = $attachments = $data->object->attachments;
	    
	    $is_member_request = $this->apiCallGroup("groups.isMember", ["group_id"=>$this->group_id,
	                                                               "user_id"=>$this->user_id]);
	    $is_member = $is_member_request['response'];
    	if($is_member == "0")   $this->send("Ой, ты кажется не подписан на группу.\nПодпишись, пожалуйста");
    	
    	
    	switch ($this->text_lower) {
    	    case 'ping':
    	        $this->construct_keyboard(["Ping"]);
    	        $attach = $this->photos->upload("https://sun9-49.userapi.com/c857420/v857420277/1062a3/4Be5unjEtxU.jpg");
    	        $this->send("pong",$attach);
    	    break;
    	}
    	
    	
        file_put_contents("log",print_r($this, true));
    }
    
    protected function message_reply(){
        //Таким же образом расписываем события, приходящие от Вконтакте
    }
}