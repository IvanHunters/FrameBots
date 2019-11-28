<?php
namespace VK;

class Photos{
    public function upload_photo($file){
    $upload_url = $this->apiCallGroup("photos.getMessagesUploadServer", array())['response']['upload_url'];
    $aPost = array(
        'file' => new CURLFile($file)
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $upload_url);
    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $aPost);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = json_decode(curl_exec($ch), true);
    curl_close($ch);
    $attachment = $this->apiCallGroup("photos.saveMessagesPhoto", array("photo"=>$res['photo'], "server"=>$res['server'], "hash"=>$res['hash']))['response'];
    unlink($file);
        return "photo".$attachment[0]['owner_id']."_".$attachment[0]['id'];
    
}
}