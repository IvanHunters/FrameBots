<?php
    namespace Bot;
    include "Handler.php";
    require_once "config.php";
    
    $bot = new Bot($confirmation_token, $token_group, $token_user);