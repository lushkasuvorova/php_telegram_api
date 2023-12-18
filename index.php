<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

class Telebot
{
    public $offset = 0;

    function getUpdates()
    {
        $url = "https://api.telegram.org/bot" . $_ENV['BOT_TOKEN'] . "/getUpdates?offset=" . $this->offset;
        $data = json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
        if ($data["result"]) {
            $last = end($data["result"]);
            $this->offset = $last["update_id"] + 1;
            $messages = array();
            foreach ($data["result"] as $message) {
                $chat_id = $message["message"]["chat"]["id"];
                $text = $message["message"]["text"];
                if ($messages[$chat_id]) {
                    $messages[$chat_id] .= "&$text";
                } else {
                    $messages[$chat_id] = $text;
                }
            }
            return $messages;
        }
    }
    function sendMessage($chat_id, $text)
    {
        $data = [
            "chat_id" => $chat_id,
            "text" => $text
        ];
        $ch = curl_init("https://api.telegram.org/bot" . $_ENV['BOT_TOKEN'] . "/sendMessage");
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10
        ]);
        curl_exec($ch); //$result = json_decode(curl_exec($ch), true);
        curl_close($ch);
    }
}
$Omar = new Telebot;
do {
    $messages = $Omar->getUpdates();
    if($messages){
        foreach($messages as $message){
            //ответить на сообщение
        }
    }
} while ($messages);
