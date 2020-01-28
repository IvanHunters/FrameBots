<?php
namespace VK;

trait Messages{
    
    protected $active_color = ["positive", "negative", "default", "primary"], $addButton = false;
    
    public function send($message, $user_id = false, $attachments = ''){
        
        if(!is_null($this->addButton) && !isset($this->callConstructKeyboard)) $this->construct_keyboard(null);
        
        if(is_array($message) || is_object($message)) 
            $message = var_export($message, true);
            
        $status = $this->messageFromGroup($message,$attachments);
        if(!isset($status['response'])) trigger_error(print_r($status, true), E_USER_WARNING);
        return $status;
    }
    
    
    protected function messageFromUser($message, $user = false){
       return print_r($this->apiCallUser("messages.send",array('message'=>$message, "random_id"=>rand(1,100000), 'user_id'=>$user)),true);
    }
    
    protected function messageFromGroup($message, $attachments = false, $flag = false){
        if($this->files_upload)
            $attachments = $this->files_upload;
            
        if($this->user_id != $this->chat_id)
            return $this->apiCallGroup("messages.send",['message'=>"[id".$this->user_id."|Ответ], $message", "random_id"=>rand(1,100000), 'peer_id'=>$this->chat_id, 'keyboard'=>$this->keyboard, 'attachment'=>$attachments]);
    
        $message_param = array('message'=>$message, "random_id"=>rand(1,100000), 'user_id'=>$this->user_id, 'attachment'=>$attachments, 'dont_parse_links'=>1);

        if(!$flag && $this->keyboard != false) $message_param['keyboard'] = $this->keyboard;
        $response = $this->apiCallGroup("messages.send",$message_param);
        $log_info['vk_request'] = $message_param;
        $log_info['vk_response'] = $response;
        //fwrite(fopen("log", "a+"), var_export($log_info, true));
        return $response;
    }
    
    
    
    
    public function close_keyboard(){
       $this->keyboard = '{"buttons":[],"one_time":true}';
    }
    
    
    
    
    public function add_button($arrKeyboard, $color = false){
        
        if(is_null($arrKeyboard)) trigger_error("Не передан параметр arr_keyboard", E_USER_WARNING);
        
        if($color){
            if(is_array($arrKeyboard) || is_object($arrKeyboard) || is_array($color) || is_object($color)) 
                trigger_error("arr_keyboard и color при передаче кнопки c цветом должны быть типа string", E_USER_WARNING);
            if(!in_array($color, $this->active_color)){
                trigger_error("Цвет должен быть одним из ".implode(", ",$this->active_color), E_USER_WARNING);
                $color = $this->active_color[0];
            }
                
         $this->addButton[] = [["text"=>$arrKeyboard, "color"=>$color]];   
        }
        else {
            $this->addButton[] = $arrKeyboard;
        }
        
    }
    
    
    
    
    public function construct_keyboard($arrKeyboard = Array(), $typeKeyboard = "normal"){
        
        $this->callConstructKeyboard = 1;
        
        if(!is_null($this->addButton)){
            
            if(is_null($arrKeyboard)){
                
                $arrKeyboard = $this->addButton;
                
            }else{
                $arrKeyboard = array_merge($arrKeyboard, $this->addButton);
                
            }
        }
        
        if($typeKeyboard == "inline"){
            $keyboard['inline'] = true;
            if(count($arrKeyboard) > 5) $arrKeyboard = array_slice($arrKeyboard, 0, 5);
        }
        $keyboard['buttons']=array();
            
        foreach ($arrKeyboard as $i=>$line) {
        	if(is_array($line)){
        	    if(isset($line['color'])){
        	        $keyboard = $keyboard['buttons'][$i][0] = $this->assoc_keyboard($line['text'],$line['color']);
        	    }elseif(isset($line['type'])){
        	        $keyboard['buttons'][$i][0] = $this->assoc_keyboard($line);
        	    }else{
        	        foreach($line as $buttons){
        	            if(is_array($buttons)){
            	            if(isset($buttons['color']))
            	                $keyboard['buttons'][$i][] = $this->assoc_keyboard($buttons['text'],$buttons['color']);
        	                elseif(!isset($buttons['color']))
            	                $keyboard['buttons'][$i][] = $this->assoc_keyboard(@$buttons[0],@$buttons[1]);
        	            }
        	            else $keyboard['buttons'][$i][] = $this->assoc_keyboard($buttons);
        	        }
        	    }
        	}else{
        	    $keyboard['buttons'][$i][0] = $this->assoc_keyboard($line);
        	}
        }
        $this->keyboard =json_encode($keyboard, JSON_UNESCAPED_UNICODE);
    }
    
    
    
    
    private function assoc_keyboard($value, $color = "primary", $label = false){
        if(!$label){
            if($value == "location") return ['action'=>['type'=>'location']];
            elseif($value == "vk_pay")	return  ['action'=>['type'=>'vkpay','hash'=>"action=transfer-to-group&group_id={$this->group_id}&aid=10"]];
            elseif(isset($value['type']) && $value['type'] == "link")	return  ['action'=>['type'=>'open_link','link'=>$value['link'],"label"=>$value['text']]];
            else return ['action'=>['type'=>'text','label'=>$value],'color'=>$color];
        }
    }
    
    
    
    
    public function keyboard_template($arrKeyboard, $typeKeyboard = 3){
        $a = array();
        $a['buttons']=array();
        $i = 0;
        $i_2 = 0;
    	foreach ($arrKeyboard as $value) {
    	        if($i_2 > $typeKeyboard){
    	            $i_2 = 0;
    	            $i++;
    	        }
    	       $a['buttons'][$i][$i_2]=array('action'=>array('type'=>'text','payload'=>'{"id_button": "'.$i.'"}','label'=>$value),'color'=>'default');
    	       $i_2++;
    	}
    	$this->keyboard =json_encode($a, JSON_UNESCAPED_UNICODE);
    }
}