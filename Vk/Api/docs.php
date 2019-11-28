<?php
namespace VK;

class Docs{
    public function upload_file($file){
        $upload_url = $this->apiCallGroup("docs.getMessagesUploadServer",array('type'=>'doc'))['response']['upload_url'];
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
        $get_data = $this->apiCallGroup("docs.save",array('file'=>$res['file']))['response'][0];
        
        return "doc".$get_data['owner_id']."_".$get_data['id'];
    }
}