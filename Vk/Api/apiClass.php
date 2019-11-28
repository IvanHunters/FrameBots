<?php
namespace VK;
require "messages.php";
require "photos.php";
require "audio.php";
require "docs.php";


class API extends \VK\Messages{
    
    public function __construct($tokenGroup, $tokenUser) {
        $this->photos      = new Photos;
        $this->audio       = new Audio;
        $this->docs        = new Docs;
    }
    
}
?>