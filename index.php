<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

class Telebot
{
    function getUpdates()
    {
        $url = "https://api.telegram.org/bot" . $_ENV['BOT_TOKEN'] . "/getUpdates";
        $data = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
        $i = 0;
        foreach ($data["result"] as $message) {
            $messages[$i]["update_id"] = $message["update_id"];
            $messages[$i]["message_id"] = $message["message"]["message_id"];
            $messages[$i]["chat_id"] = $message["message"]["chat"]["id"];
            $messages[$i]["text"] = $message["message"]["text"];
            $i++;
        }
        //print_r($messages);
        return $messages;
    }
    function sendMessage()
    {
        $data = [
            "chat_id" => 1140339250,
            "text" => "Test"
        ];
        $ch = curl_init("https://api.telegram.org/bot" . $_ENV['BOT_TOKEN'] . "/sendMessage");
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10
        ]);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        //print_r($result);
    }
}
$Omar = new Telebot;
$messages = $Omar->getUpdates();
$Omar->sendMessage();
