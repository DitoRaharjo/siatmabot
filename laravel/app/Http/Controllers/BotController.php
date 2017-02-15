<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram;

class BotController extends Controller
{
    public function webhook(Request $request)
    {
      $updates = Telegram::getWebhookUpdates();

      $text = $updates["message"]["text"];

      echo $text;

    }
}
