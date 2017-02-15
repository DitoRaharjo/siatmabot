<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram;

class BotController extends Controller
{
    public function updates()
    {
      $updates = Telegram::getWebhookUpdates();

      $text = $updates["message"]["text"];
      $chatId = $updates["message"]["chat"]["id"];
      $chatName = $updates["message"]["chat"]["first_name"] . " " . $updates["message"]["chat"]["last_name"];

      if(strcasecmp($text, "/start")==0) {
        $response = Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => 'Halo salam kenal ' . $chatName . ', saya SIATMA BOT'
        ]);
      }
      if(strcasecmp($text, "hai")==0) {
        $response = Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => 'Hai juga :D'
        ]);
      }
      if(strcasecmp($text, "salam kenal")==0) {
        $response = Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => 'Salam kenal, namaku SIATMA Bot'
        ]);
      }
    }

    public function cetak()
    {
    }
}
