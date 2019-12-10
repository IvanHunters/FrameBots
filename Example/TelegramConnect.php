<?php
namespace Callback;
require "../../Telegram/CallbackBotLib.php";
require "config.php";
$bot = new BOT($telegram->token, true, $telegram->proxy);
$path = preg_replace("/^(.)+html/","",realpath("Bot.php"))."?platform=tg";
$bot->set_webhook("https://".$_SERVER["HTTP_HOST"].$path);