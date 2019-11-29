<?php
namespace VK;
class Photos  extends \VK\Main{
    
    public function upload($file, $group = true){
        
        if(preg_match("/http|www/", $file)){ 
            $time_unix = time();
            $new_file = "{$time_unix}.jpg";
            file_put_contents($new_file, file_get_contents($file));
            $file = $new_file;
        }
        if($group) $method = "apiCallGroup";
        else       $method = "apiCallUser";
        
        $upload_url = $this->{$method}("photos.getMessagesUploadServer", array())['response']['upload_url'];
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
        $attachment = $this->{$method}("photos.saveMessagesPhoto", array("photo"=>$res['photo'], "server"=>$res['server'], "hash"=>$res['hash']))['response'];
        unlink($file);
            return "photo".$attachment[0]['owner_id']."_".$attachment[0]['id'];
    
}
}