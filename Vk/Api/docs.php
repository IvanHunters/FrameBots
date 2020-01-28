<?php
namespace VK;

trait Docs{
    
    public function upload_file($file, $group = true){
        
        if(preg_match("/^doc/imu", $file)){
            
            $this->files_upload[] = $file;
            return "none";
            
        }
        
        if(preg_match("/http|www/", $file)){
            
            preg_match("/[^.]+$/", $file, $ext);
            $time_unix = time();
            $new_file = "{$time_unix}.{$ext[0]}";
            file_put_contents($new_file, file_get_contents($file));
            $file = $new_file;
            
        }
        
        if($group) $method = "apiCallGroup";
        else       $method = "apiCallUser";
        
        $upload_url = $this->{$method}("docs.getMessagesUploadServer",array('type'=>'doc', 'peer_id'=>$this->user_id))['response']['upload_url'];
        $aPost = array(
            'file' => new \CURLFile($file)
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $upload_url);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $aPost);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $attachment = $this->{$method}("docs.save",array('file'=>$res['file']))['response'];
        $attach = "doc".$attachment[$attachment['type']]['owner_id']."_".$attachment[$attachment['type']]['id'];
        
        $this->files_upload[] = $attach;
        if(file_exists($file))  unlink($file);
            return $attach;
    }
}