<?php
    namespace Bot;
    require_once "config.php";
    require_once "Handler.php";
    
    switch($_GET['platform']){
        case "vk":
            new Bot($vk->confirmation_token, $vk->token_group, $vk->token_user, $vk->status);
        break;
        
        case "fb":
            new Bot($facebook->confirmation_token, $facebook->token, $facebook->group_id, $facebook->status);
        break;
        
        case "tg":
            new Bot($telegram->token, false, $telegram->proxy, $telegram->status);
        break;
        
        case "inst":
            new Bot($facebook->confirmation_token, $facebook->token, $facebook->group_id, $facebook->status);
        break;
    }