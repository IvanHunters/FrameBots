<?php
namespace TG;

trait Messages{
    
    protected $addButton = false;
    public $type_upload = false;
    
    public function send($text_message, $user_id = false){
        
        if($this->addButton && !isset($this->callConstructKeyboard)) $this->construct_keyboard(null);
        
        $this->user_id = $user_id? $user_id: $this->user_id;
        $array_parametrs = ["chat_id"=>$this->user_id, "text"=>$text_message, "disable_web_page_preview"=>true];
        
        if($this->keyboard) $array_parametrs['reply_markup'] = $this->keyboard;
        
        if($this->files_upload){
            switch($this->type_upload){
                case 'photo':
                    $array_parametrs['photo'] =  new \CURLFile($this->files_upload);
                    $response = $this->send_photo($array_parametrs);
                break;
                
                case 'file':
                    $array_parametrs['document'] =  new \CURLFile($this->files_upload);
                    $response = $this->send_file($array_parametrs);
                break;
            }
        }else{
            
            if(!is_null($this->message_id)){
                
                $array_parametrs["message_id"] = $this->message_id;
                $response = $this->apiCall("editMessageText", $array_parametrs);
                
            }else{
                
               $response = $this->apiCall("sendMessage", $array_parametrs); 
               
            }
        }
        
        return var_export($response, true);
    }
    
    public function add_button($arrKeyboard, $color = false){
        
        if(is_null($arrKeyboard)) trigger_error("Не передан параметр arr_keyboard", E_USER_WARNING);
        
        if($color){
            if(is_array($arrKeyboard) || is_object($arrKeyboard) || is_array($color) || is_object($color)) 
                trigger_error("arr_keyboard и color при передаче кнопки c цветом должны быть типа string", E_USER_WARNING);
                
         $this->addButton[] = [["text"=>$arrKeyboard, "color"=>$color]];   
        }else{
            $this->addButton[] = $arrKeyboard;
        }
        
    }
    
    public function construct_keyboard($arrKeyboard = Array(), $typeKeyboard = "inline"){
        
        $this->callConstructKeyboard = 1;
        
        
        if($this->addButton){
            
            if(count($arrKeyboard) == 0){
                
                $arrKeyboard = $this->addButton;
                
            }else{
                
                $arrKeyboard = array_merge($arrKeyboard, $this->addButton);
                
            }
        }
        
        if(in_array("location", $arrKeyboard)) $typeKeyboard = "normal";
        
        if($typeKeyboard == "inline")  $name_keyboard = "inline_keyboard";
        
        elseif($typeKeyboard == "normal"){
            
            $name_keyboard = "keyboard";
            $keyboard["resize_keyboard"] = true;
            $keyboard["one_time_keyboard"] = true;
        }
        
        foreach($arrKeyboard as $i => $buttons){
            
            if(!is_array($buttons)){
                
                $text = $data = $buttons;
                if($text == "location"){
                    
                    $keyboard[$name_keyboard][$i][0] = ["text"=>"Отправить местоположение","request_location"=>true];
                    
                }else{
                    
                    $keyboard[$name_keyboard][$i][0] = ["text"=>$text, "callback_data"=>$data];
                    
                }
                
            }else{
                
                if(isset($buttons['color'])){
                    
                    $text = isset($buttons['text'])? $buttons['text']: $buttons[0];
                    $keyboard[$name_keyboard][$i][0] = ["text"=>$text, "callback_data"=>$text];
                    
                }else{
                    
                    if(isset($buttons['type'])){
                        switch ($buttons['type']) {
                            case 'link':
                                    $keyboard[$name_keyboard][$i][0] = ["text"=>$buttons['text'], "url"=>$buttons['link']];
                                break;
                        }
                    }else{
                        
                        foreach($buttons as $i2 => $button){
                            
                            if(is_array($button)){
                                
                                $text = isset($button['text'])? $button['text']: $button[0];
                                $data = $text;
                                
                            }else{
                                
                                $text = $data = $button;
                            }
                            
                            if($text == "location"){
                                
                               $keyboard[$name_keyboard][$i][$i2] = ["text"=>"Отправить местоположение","request_location"=>true];
                            }else{
                                
                               $keyboard[$name_keyboard][$i][$i2] = ["text"=>$text, "callback_data"=>$data];
                               
                            }
                        }
                    }
                }
            }
        }
        $this->keyboard = json_encode($keyboard);
    }
}