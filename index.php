<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

class Telebot
{
    function getUpdates()
    {
        $url = "https://api.telegram.org/bot".$_ENV['BOT_TOKEN']."/getUpdates";
        $data = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
        $i = 0;
        foreach ($data["result"] as $message) {
            $messages[$i][] = $message["update_id"];
            $messages[$i][] = $message["message"]["message_id"];
            $messages[$i][] = $message["message"]["chat"]["id"];
            $messages[$i][] = $message["message"]["text"];
            $i++;
        }
        //print_r($messages);
        return $messages;
    }
    function sendMessage(){

    }
}
$Omar=new Telebot;
$messages=$Omar->getUpdates();

