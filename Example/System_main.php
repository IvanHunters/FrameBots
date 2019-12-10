<?php
namespace VK;
require_once "../config.php";
require "../../../Vk/Api/apiClass.php";
$api = new API($vk->token_group, $vk->token_user);
$api->construct_keyboard(["ping"], "inline");
$attach = $api->upload_photo("https://cs8.pikabu.ru/post_img/big/2016/12/28/1/1482881197192578721.jpg");
print_r($api->send("Test", "145567397"));