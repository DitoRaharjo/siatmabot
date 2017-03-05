<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Carbon\Carbon;

use Hash;
use Response;
use Input;
use DB;

use App\User;
use App\Prodi;
use App\Fakultas;
use App\ChatLogFb;
use Telegram;

class FbBotController extends Controller
{
    public function privacyPolicy() {
      return view('facebookPrivacyPolicy.index');
    }

    public function webhook() {
      /* ---------------- For Verifying FB Messenger API Webhook ---------------- */
      $local_verify_token = env('FB_WEBHOOK_VERIFY_TOKEN');
      $hub_verify_token = Input::get('hub_verify_token');

      if($local_verify_token == $hub_verify_token) {
        return Input::get('hub_challenge');
      } else {
        return "Bad verify token";
      }
      /* ---------------- For Verifying FB Messenger API Webhook ---------------- */
    }

    public function updates(Request $request) {
      $responses = file_get_contents("php://input");
      $responses_convert = json_decode($responses);

      $userId = $responses_convert->entry[0]->messaging[0]->sender->id;
      $textReceived = $responses_convert->entry[0]->messaging[0]->message->text;
      $registerUrl = "UNDER MAINTENANCE";

      $this->getUser($userId);

      if($this->checkLogin($userId) == true) {
        if(strcasecmp($textReceived, "hai")==0) {
          $textSend = "Halo juga :D";
        } else if(strcasecmp($textReceived, "salam kenal")==0) {
          $user_data = $this->getUserProfile($userId);
          $textSend = "Salam kenal juga, ".$user_data->first_name." ".$user_data->last_name;
        } else {
          $textSend = "Maaf perintah tidak ditemukan";
        }
        $this->setSendCondition($userId, $textSend);
      } else {
        if (($check = strpos($textReceived, "-")) !== FALSE) {
          $email = strtok($textReceived, '-');
          $password = substr($textReceived, strpos($textReceived, "-") +1);

          if($this->checkEmail($email) == true) {
            if($this->checkPassword($userId, $email, $password)== true ) {
              $textSend = "Selamat anda berhasil login, sekarang anda sudah bisa menggunakan fitur kuliah SIATMA Bot";
            } else {
              $textSend = "Maaf email atau password anda salah". PHP_EOL .
              "atau anda belum terdaftar". PHP_EOL .
              "jika anda belum mendaftar, silahkan daftarkan diri anda di : ".$registerUrl;
            }
          } else {
            $textSend = "Maaf email atau password anda salah". PHP_EOL .
            "atau anda belum terdaftar". PHP_EOL .
            "jika anda belum mendaftar, silahkan daftarkan diri anda di : ".$registerUrl;
          }
        } else {
          $textSend = "Maaf anda perlu login terlebih dahulu".PHP_EOL.
          "silahkan kirimkan chat email dan password yang sudah anda daftarkan di ".$registerUrl. PHP_EOL .
          "dengan format : email-password". PHP_EOL .
          "contoh: asdf@gmail.com-1234 ";
        }
        $this->setSendCondition($userId, $textSend);
      }


      // $chatId = 253128578;
      // $textTelegram = $responses;
      //
      // Telegram::sendMessage([
      //   'chat_id' => $chatId,
      //   'text' => $textTelegram,
      // ]);

      return response()->json("OK");
    }

    public function getUser($userId) {
      $check = ChatLogFb::select('id')->where('chat_id', $userId)->get();
      $checkCount = $check->count();

      if($checkCount == 0) {
        $user = $this->getUserProfile($userId);

        $user_data = array();
        $user_data['chat_id'] = $userId;
        $user_data['first_name'] = $user->first_name;
        $user_data['last_name'] = $user->last_name;

        DB::beginTransaction();

        try {
          ChatLogFb::create($user_data);

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
      }
    }

    public function checkLogin($userId) {
      $check = ChatLogFb::select('id')->where('chat_id', $userId)->get();
      $checkCount = $check->count();

      if($checkCount == 1) {
        $chatLog = ChatLogFb::find($check);

        if($chatLog->user_id == 0) {
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }
    }

    public function checkEmail($email) {
      $check = User::select('id')->where('email', 'LIKE', $email)->get();
      $checkCount = $check->count();

      if($checkCount != 0) {
        return true;
      } else {
        return false;
      }
    }

    public function checkPassword($userId, $email, $password) {
      $check = User::select('id')->where([
        ['email', 'LIKE', $email]
        ])->get();
      $checkCount = $check->count();

      if($checkCount != 0) {
        $user_data = User::find($check);

        if(Hash::check($password, $user_data->password) ) {
          $checkChatLog = ChatLogFb::select('id')->where('chat_id', $userId)->get();
          $checkCountChatLog = $checkChatLog->count();

          if($checkCountChatLog == 1) {
            $chat_log_data = ChatLogFb::find($checkChatLog);

            DB::beginTransaction();

            try {
              $user_data->chat_log_fb_id = $chat_log_data->id;
              $chat_log_data->user_id = $user_data->id;

              $user_data->save();
              $chat_log_data->save();

              DB::commit();
            } catch (\Exception $e) {
              DB::rollback();

              throw $e;
            }
            return true;

          } else {
            return false;
          }
        } else {
          return false;
        }
      } else {
        return false;
      }
    }

    public function setSendCondition($userId, $textSend) {
      $this->setRead($userId);
      $this->setTypingOn($userId);
      $this->sendMessage($userId, $textSend);
      $this->setTypingOff($userId);
    }

    public function sendMessage($userId, $textSend) {
        $data = array(
          'recipient'=>array('id'=>"$userId"),
          'message'=>array('text'=>"$textSend")
        );

        $opts = array(
          'http'=>array(
            'method'=>'POST',
            'content'=>json_encode($data),
            'header'=>"Content-Type: application/json\n"
          )
        );
        $context = stream_context_create($opts);

        $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
        file_get_contents($website, false, $context);
    }

    public function setRead($userId) {
      $data = array(
        'recipient'=>array('id'=>"$userId"),
        'sender_action'=>"mark_seen"
      );

      $opts = array(
        'http'=>array(
          'method'=>'POST',
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json\n"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }

    public function setTypingOn($userId) {
      $data = array(
        'recipient'=>array('id'=>"$userId"),
        'sender_action'=>"typing_on"
      );

      $opts = array(
        'http'=>array(
          'method'=>'POST',
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json\n"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }

    public function setTypingOff($userId) {
      $data = array(
        'recipient'=>array('id'=>"$userId"),
        'sender_action'=>"typing_off"
      );

      $opts = array(
        'http'=>array(
          'method'=>'POST',
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json\n"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.8/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }

    public function getUserProfile($userId) {
      $website = "https://graph.facebook.com/v2.8/".$userId."?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      $user_data = file_get_contents($website);

      return json_decode($user_data);
    }

}
