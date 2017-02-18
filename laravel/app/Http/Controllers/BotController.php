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
use App\ChatLog;
use Telegram;

class BotController extends Controller
{
    public function updates()
    {
      $responses = Telegram::getWebhookUpdates();

      $this->getUser($responses);

      $text = $responses["message"]["text"];
      $chatId = $responses["message"]["chat"]["id"];
      $first_name = "";
      $last_name = "";
      $username = "";
      if(isset($responses["message"]["chat"]["first_name"])) {
        $first_name = $responses["message"]["chat"]["first_name"];
      }
      if(isset($responses["message"]["chat"]["last_name"])) {
        $last_name = $responses["message"]["chat"]["last_name"];
      }
      if(isset($responses["message"]["chat"]["username"])) {
        $username = $responses["message"]["chat"]["username"];
      }
      $chatName = $first_name . " " . $last_name;

      if($this->checkUserChatId($responses) == false) {
        if($this->checkUserUsername($responses) == true) {
          $this->updateChatId($responses);
        } else if($this->checkUserUsername($responses) == false) {
          $text = "Maaf sepertinya anda belum terdaftar, silahkan daftarkan diri anda pada link dibawah";
          $parseMode = "<a href='https://www.google.co.id'>LINK</a>";
          Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => $parseMode,
          ]);
          // Apakah anda sudah mendaftar? Kalau belum silahkan daftar
          // atau apakah anda mengganti username? silahkan update username anda di aplikasi
        }
      } else {
        if(strcasecmp($text, "/start")==0) {
          $text = 'Halo salam kenal ' . $chatName . ', saya SIATMA BOT';
        } else if(strcasecmp($text, "hai")==0) {
          $text = "Hai juga :D";

        } else if(strcasecmp($text, "salam kenal")==0) {
          $text = "Salam kenal ". $chatName;
        } else if(strcasecmp($text, "npm dong")==0) {
          $text = "Under maintenance, please be patient";
        } else if(strcasecmp($text, "chat id dong")==0) {
          $text = "Chat ID : ".$chatId;
        }
        $parseMode = "<a href='https://www.google.co.id'>LINK</a>";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
          'parse_mode' => $parseMode,
        ]);
      }
    }

    public function getUser($responses) {
      $chatId = $responses["message"]["chat"]["id"]; ///////////////////////////////////////////

      $user_data['chat_id'] = $responses["message"]["chat"]["id"];
      if(isset($responses["message"]["chat"]["first_name"])) {
        $user_data['first_name'] = $responses["message"]["chat"]["first_name"];
      }
      if(isset($responses["message"]["chat"]["last_name"])) {
        $user_data['last_name'] = $responses["message"]["chat"]["last_name"];
      }
      if(isset($responses["message"]["chat"]["username"])) {
        $user_data['username'] = $responses["message"]["chat"]["username"];
      }

      $check = ChatLog::select('id')->where('chat_id', $user_data['chat_id'])->get();
      $checkCount = $check->count();

      if($checkCount == 0) {
        DB::beginTransaction();

        try {
          ChatLog::create($user_data);

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
        $text = "chat log baru dan berhasil disimpan";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
      } else {
        $text = "chat log sudah ada";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
      }
    }

    public function checkUserChatId($response) {
      $chatId = $responses["message"]["chat"]["id"];
      $check = User::select('id')->where('chat_id', $chatId)->get();
      $checkCount = $check->count();

      if($checkCount == 0) {
        $text = "chat_id tidak ditemukan";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
        return false;
      } else {
        $text = "chat_id id ditemukan";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
        return true;
      }
    }

    public function checkUserUsername($responses) {
      $chatId = $responses["message"]["chat"]["id"]; //////////////////////////////////////////////

      $username = "-";
      if(isset($responses["message"]["chat"]["username"])) {
        $username = $responses["message"]["chat"]["username"];
      }

      $check = User::select('id')->where('telegram_username', $username)->get();
      $checkCount = $check->count();

      if($checkCount == 0) {
        $text = "username tidak ditemukan";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
        return false;
      } else {
        $text = "username ditemukan";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
        return true;
      }
    }

    public function updateChatId($responses) {
      $chatId = $responses["message"]["chat"]["id"];
      $username = "-";
      if(isset($responses["message"]["chat"]["username"])) {
        $username = $responses["message"]["chat"]["username"];
      }
      $userId = User::select('id')->where('telegram_username', $username)->get();
      $checkCount = $userId->count();

      if($checkCount == 1) {

        DB::beginTransaction();

        try {
          $userUpdate = User::find($userId);
          $chatId = $responses["message"]["chat"]["id"];

          if($userUpdate->chat_log_id == NULL) {
            $chatLogId = ChatLog::select('id')->where('chat_id', $chatId)->get();
            $chatLogCount = $chatLogId->count();

            if($chatLogCount == 1) {
              $chatLogUpdate = ChatLog::find($chatLogId);
              $chatLogUpdate->user_id = $userUpdate->id;
              $chatLogUpdate->save();

              $userUpdate->chat_log_id = $chatLogUpdate->id;
              $userUpdate->chat_id = $chatId;
              $userUpdate->save();
              $text = "Berhasil Update chat_log_id, Berhasil update chat_id";
              Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
              ]);
            } else {
              $userUpdate->chat_id = $chatId;
              $userUpdate->save();
              $text = "Gagal Update chat_log_id, Berhasil update chat_id";
              Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
              ]);
            }
          } else {
            $userUpdate->chat_id = $chatId;
            $userUpdate->save();
            $text = "Chat Log ID sudah ada, Berhasil update chat_id";
            Telegram::sendMessage([
              'chat_id' => $chatId,
              'text' => $text,
            ]);
          }

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
      } else {
        $text = "Gagal update chat_id";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
      }
    }
}
