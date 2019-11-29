<?php
namespace VK;
require "mainClass.php";
class Messages extends \VK\Main{
    public function send($message, $user_id = false, $attachments = ''){
        if(preg_match("/\_/",$user_id)) $attachments = $user_id;
        elseif($user_id) $this->user_id = $this->chat_id = $user_id;
        return $this->messageFromGroup($message,$attachments);
    }
    
    function messageFromUser($message, $user = false){
       return print_r($this->apiCallUser("messages.send",array('message'=>$message, 'user_id'=>$user)),true);
    }
    
    function messageFromGroup($message, $attachments = false, $flag = false){
        if($this->user_id != $this->chat_id)
            return $this->apiCallGroup("messages.send",['message'=>"[id".$this->user_id."|Ответ], $message", 'peer_id'=>$this->chat_id, 'keyboard'=>$this->keyboard, 'attachment'=>$attachments]);
    
        $message_param = array('message'=>$message, 'user_id'=>$this->user_id, 'dont_parse_links'=>1, 'attachment'=>$attachments, 'dont_parse_links'=>1);
       
        if(!$flag && $this->keyboard != false) $message_param['keyboard'] = $this->keyboard;
        
        $response = $this->apiCallGroup("messages.send",$message_param);
        print_r($this);
        return $response;
    }
    
    public function close_keyboard(){
       $this->keyboard = '{"buttons":[],"one_time":true}';
    }
    
    public function construct_keyboard($arr_keyboard, $type_keyboard = "normal"){
        if($type_keyboard == "normal"){
            $keyboard['buttons']=array();
            
        	foreach ($arr_keyboard as $i=>$value) {
        		if($value == "location") $a['buttons'][$i][0]=['action'=>['type'=>'location','payload'=>'{"button": "'.$i.'"}']];
        		elseif($value == "vk_pay")	$a['buttons'][$i][0]=['action'=>['type'=>'vkpay','hash'=>"action=transfer-to-group&group_id=$this->group_id&aid=10"]];
        		else $keyboard['buttons'][$i][0]=['action'=>['type'=>'text','payload'=>'{"id_button": "'.$i.'"}','label'=>$value],'color'=>'default'];
        	}
        	
        }
        $this->keyboard =json_encode($keyboard, JSON_UNESCAPED_UNICODE);
    }
    
    public function keyboard_template($arr_keyboard, $type_keyboard = 3){
        $a = array();
        $a['buttons']=array();
        $i = 0;
        $i_2 = 0;
    	foreach ($arr_keyboard as $value) {
    	        if($i_2 > $type_keyboard){
    	            $i_2 = 0;
    	            $i++;
    	        }
    	       $a['buttons'][$i][$i_2]=array('action'=>array('type'=>'text','payload'=>'{"id_button": "'.$i.'"}','label'=>$value),'color'=>'default');
    	       $i_2++;
    	}
    	$this->keyboard =json_encode($a, JSON_UNESCAPED_UNICODE);
    }
}