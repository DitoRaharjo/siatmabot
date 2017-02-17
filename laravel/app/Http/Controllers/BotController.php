<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Carbon\Carbon;

use DB;

use App\User;
use App\Prodi;
use App\Fakultas;
use Telegram;

class BotController extends Controller
{
    public function updates()
    {
      $updates = Telegram::getWebhookUpdates();

      $text = $updates["message"]["text"];
      $chatId = $updates["message"]["chat"]["id"];
      $first_name = "-";
      $last_name = "-";
      if(isset($updates["message"]["chat"]["first_name"])) {
        $first_name = $updates["message"]["chat"]["first_name"];
      }
      if(isset($updates["message"]["chat"]["last_name"])) {
        $last_name = $updates["message"]["chat"]["last_name"];
      }
      $chatName = $first_name . " " . $last_name;
      $username = $updates["message"]["chat"]["username"] ;

      $userId = User::select('id')->where('telegram_username', 'LIKE', $username)->get();
      $count = $userId->count();

      if($count == 0) {
        $response = Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => 'Halo kamu belum daftar lo, daftar dulu yuk di
          ("URL WEB :p ")'
        ]);
      } else {
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
        if(strcasecmp($text, "npm dong")==0) {
          $npmUser = User::find($userId)->npm;
          $response = Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'NPM kamu '.$npmUser
          ]);
        }
        if(strcasecmp($text, "npm dong")==0) {
          $response = Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => 'Chat ID : '.$chatId
          ]);
        }
      }
    }

    public function checkUser($updates) {
      $user_data['chat_id'] = $updates["message"]["chat"]["id"];
      // $user_data['first_name'] = NULL;
      // $user_data['last_name'] = NULL;
      // $user_data['username'] = NULL;
      if(isset($updates["message"]["chat"]["first_name"])) {
        $user_data['first_name'] = $updates["message"]["chat"]["first_name"];
      }
      if(isset($updates["message"]["chat"]["last_name"])) {
        $user_data['last_name'] = $updates["message"]["chat"]["last_name"];
      }
      if(isset($updates["message"]["chat"]["username"])) {
        $user_data['username'] = $updates["message"]["chat"]["username"];
      }
    }
}
