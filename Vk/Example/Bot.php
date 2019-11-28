<?php
namespace Bot;
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include "Handler.php";

    $confirmation_token = ''; //тут confirmation_token, который должен вернуть сервер
    $token_group  = ''; //Тут токен группы со всеми разрешениями
    $token_user   = false; //Тут токен личной страницы Вконтакте (если нужен)
    
    $bot = new Bot($confirmation_token, $token_group, $token_user);