<?php

class Messages{
    
    public function send($message , $attachments = ''){
        return $this->messageFromGroup($message,$attachments);
    }
    function messageFromUser($user,$message){
       return print_r($this->apiCallUser("messages.send",array('message'=>$message, 'user_id'=>$user)),true);
    }
    function messageFromGroup($message, $attachments = false, $flag = false){
        if($this->user_id != $this->chat)
            return $this->apiCallGroup("messages.send",['message'=>"[id".$this->user_id."|Ответ], $message", 'peer_id'=>$this->chat, 'keyboard'=>$this->keyboard, 'attachment'=>$attachments]);
    
        $mass = array('message'=>$message, 'user_id'=>$this->chat, 'dont_parse_links'=>1, 'attachment'=>$attachments, 'dont_parse_links'=>1, 'keyboard'=>$this->keyboard);
       
        if($flag) unset($mass['keyboard']);
        
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