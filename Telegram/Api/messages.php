<?php
namespace TG;

trait Messages{
    
    public function send($text_message, $user_id = false){
        $this->user_id = $user_id? $user_id: $this->user_id;
        $array_parametrs = ["chat_id"=>$this->user_id, "text"=>$text_message, "disable_web_page_preview"=>true];
        if($this->keyboard) $array_parametrs['reply_markup'] = $this->keyboard;
        if($this->files_upload){
            $array_parametrs['photo'] =  new \CURLFile($this->files_upload);
            $response = $this->send_photo($array_parametrs);
        }else{
            
            if(!is_null($this->message_id)){
                $array_parametrs["message_id"] = $this->message_id;
                $response = $this->apiCall("editMessageText", $array_parametrs);
            }else{
               $response = $this->apiCall("sendMessage", $array_parametrs); 
            }
        }
        
        //sleep(1);
        return var_export($response, true);
    }
    
    public function construct_keyboard($button_array, $type_keyboard = "inline"){
        
        if(in_array("location", $button_array)) $type_keyboard = "normal";
        if($type_keyboard == "inline")  $name_keyboard = "inline_keyboard";
        
        elseif($type_keyboard == "normal"){
            
            $name_keyboard = "keyboard";
            $keyboard["resize_keyboard"] = true;
            $keyboard["one_time_keyboard"] = true;
        }
        
        foreach($button_array as $i => $buttons){
            
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