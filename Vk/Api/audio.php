<?php
namespace VK;

class Audio  extends \VK\Main{
    public function send(){
      $upload_file = $this->docs->upload_file("voice_{$this->user_id}.mp3");
      $get_data = $this->apiCallGroup("docs.save",array('file'=>$upload_file,'title'=>'test'));
      $data = $get_data['response'][0];
      $attachment = "doc".$data['owner_id']."_".$data['id'];
      return $attachment;
    }
}