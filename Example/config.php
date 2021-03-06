<?php

    ini_set('log_errors', 'On');
    ini_set('error_log', 'php_errors.log');
    
    
    $platforms                      = ["vk"=>"Vk", "tg"=>"Telegram", "fb"=>"Facebook"];
    $debug                          = false; // Статус дебага

    $db                             = false;
    
//  OR

//  include                         "../../Database/mainClass.php";
//  $db                             = new \DB("username","pass","database"); 
    
    /*------------------------------------------------------------------*/
    /*---------------------Настройки бота Вконтакте---------------------*/
    /*------------------------------------------------------------------*/
    
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!---ВАЖНО---!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    /*-------------------Для включения бота для Вконтакте,----------------
      Укажите в поле Callback-сервера ссылку на файл Bot.php?platform=vk
      -----------------------------в БРАУЗЕРЕ---------------------------*/
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!!---ВАЖНО---!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    
    $vk                             = (object)[];
    
    // Статус бота
    $vk->status                     = true;
    
    // Тут confirmation_token, который должен вернуть сервер
    $vk->confirmation_token         = '';
    
    // Тут токен группы со всеми разрешениями
    $vk->token_group                = '';
    
    // Тут токен личной страницы Вконтакте (если нужен)
    $vk->token_user                 = '';
    
    
    /*----------------------------------------------------------------*/
    /*--------------------Настройки бота Телеграмм--------------------*/
    /*----------------------------------------------------------------*/
    
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!---ВАЖНО---!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    /*-----------------Для включения бота для Телеграмм,---------------
      ----------------запустите файл TelegramConnect.php---------------
      ----------------------------в БРАУЗЕРЕ--------------------------*/
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!---ВАЖНО---!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    
    
    $telegram                       = (object)[];
    
    // Статус бота
    $telegram->status               = true;
    
    // Токен телеграмм-бота
    $telegram->token                = '';
    
    // Прокси-сервер
    $telegram->proxy                = "163.172.152.52:8811";
    
    /*----------------------------------------------------------------*/
    /*--------------------Настройки бота Фейсбука---------------------*/
    /*----------------------------------------------------------------*/
    
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!---ВАЖНО---!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    /*-----------------Для включения бота для Фейсбук,-----------------
      Укажите в поле Callback-сервера ссылку на файл Bot.php?platform=fb
      ----------------------------в БРАУЗЕРЕ--------------------------*/
    /*!!!!!!!!!!!!!!!!!!!!!!!!!!!---ВАЖНО---!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    
    $facebook                       = (object)[];
    
    // Статус бота
    $facebook->status               = true;
    
    // Токен для подключения бота в фейсбуке
    $facebook->confirmation_token   = '';
    
    // Токен фейсбук-бота
    $facebook->token                = '';
    
    // Идентификатор группы
    $facebook->group_id             = '';
    
    
    
    
    