<?php
namespace TG;
trait Photos{
    
    public function upload_photo($file, $chat_id = false){
        
        if(preg_match("/http|www/", $file)){ 
            $time_unix = time();
            $new_file = "{$time_unix}.jpg";
            file_put_contents($new_file, file_get_contents($file));
            $file = $new_file;
        }
        
        $this->files_upload = $file;
    }
    
    public function send_photo($post_fields){
        $post_fields['caption'] = $post_fields['text'];
        unset($post_fields['text']);
        
        $bot_url    = "https://api.telegram.org/bot{$this->token}/";
        $url        = $bot_url . "sendPhoto?chat_id=" . $this->user_id ;
        
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_PROXY, $this->proxy); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
        $output = curl_exec($ch);
        
        unlink($this->files_upload);
        $this->files_upload = false;
        
        return $output;
    }
    
    
}