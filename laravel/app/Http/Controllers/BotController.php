<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram;

class BotController extends Controller
{
    public function webhook()
    {
      $response = Telegram::setWebhook(['url' => 'https://ditoraharjo.co/siatmabot/300623684:AAGw6xd1e-caYMpzlucNosb8Nncg-2AMilw/webhook']);

      echo $response;
    }
}
