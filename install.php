<?php
$name_bot = readline("Введите название для бота: ");
    if(!file_exists($name_bot)){
        mkdir("Bots/".$name_bot, 0777, true);
        mkdir("Bots/".$name_bot."/System", 0777, true);
        file_put_contents("Bots/".$name_bot."/config.php", file_get_contents("Example/config.php"));
        file_put_contents("Bots/".$name_bot."/Bot.php", file_get_contents("Example/Bot.php"));
        file_put_contents("Bots/".$name_bot."/Handler.php", file_get_contents("Example/Handler.php"));
        file_put_contents("Bots/".$name_bot."/System/Main.php", file_get_contents("Example/System_main.php"));
        file_put_contents("Bots/".$name_bot."/TelegramConnect.php", file_get_contents("Example/TelegramConnect.php"));
        chmod("Bots/".$name_bot."/config.php", 0777);
        chmod("Bots/".$name_bot."/Bot.php", 0777);
        chmod("Bots/".$name_bot."/Handler.php", 0777);
        chmod("Bots/".$name_bot."/System/Main.php", 0777);
        echo "Бот успешно создан\n";
    }else
        die("Такой бот уже существует");
?>