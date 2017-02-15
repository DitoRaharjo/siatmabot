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

      if($text == "hai")
      {
        $response = Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => 'Hai juga :D'
        ]);
      }
    }
}
