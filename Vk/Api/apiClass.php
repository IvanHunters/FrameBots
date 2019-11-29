<?php
namespace VK;
require "messages.php";
require "photos.php";
require "audio.php";
require "docs.php";


class API extends \VK\Messages{
    
    public function __construct($tokenGroup, $tokenUser = false) {
        $this->photos      = new Photos($tokenGroup, $tokenUser);
        $this->audio       = new Audio($tokenGroup, $tokenUser);
        $this->docs        = new Docs($tokenGroup, $tokenUser);
        $this->keyboard    = false;
        $this->token_group = $tokenGroup;
        $this->token_user = $tokenUser;
    }
    
}
?>