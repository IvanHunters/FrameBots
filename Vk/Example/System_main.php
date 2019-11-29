<?php
namespace VK;
require_once "../config.php";
require "../../../Vk/Api/apiClass.php";
$api = new API($token_group, $token_user);
$attach = $api->photos->upload("https://cs8.pikabu.ru/post_img/big/2016/12/28/1/1482881197192578721.jpg");
$api->send("Test","145567397", $attach);