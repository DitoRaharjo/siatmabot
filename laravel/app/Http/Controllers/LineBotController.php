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
use App\ChatLogLine;
use Telegram;

use \LINE\LINEBot\SignatureValidator as SignatureValidator;

class LineBotController extends Controller
{
    public function updates(Request $request) {
      // get request body and line signature header
    	$body 	   = file_get_contents('php://input');
    	$signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];

    	// log body and signature
    	file_put_contents('php://stderr', 'Body: '.$body);

    	// is LINE_SIGNATURE exists in request header?
    	if (empty($signature)){
    		return $response->withStatus(400, 'Signature not set');
    	}

    	// is this request comes from LINE?
    	if(env('PASS_SIGNATURE') == false && ! SignatureValidator::validateSignature($body, env('CHANNEL_SECRET'), $signature)){
    		return $response->withStatus(400, 'Invalid signature');
    	}

    	// init bot
    	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
    	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);

    	$data = json_decode($body, true);

    	foreach ($data['events'] as $event)
    	{
    		if ($event['type'] == 'message')
    		{
    			if($event['message']['type'] == 'text')
    			{
            $userId = $event['source']['userId'];
            $replyToken = $event['replyToken'];

            //To save chat log
            $this->getUser($userId);

            $textReceived = $event['message']['text'];

            if($this->checkLogin($userId) == true) {
              if(strcasecmp($textReceived, "halo")==0) {
                $opts = array(
                  'http'=>array(
                    'method'=>"GET",
                    'header'=>"Authorization: Bearer ".env('CHANNEL_ACCESS_TOKEN')
                  )
                );
                $context = stream_context_create($opts);

                $website = "https://api.line.me/v2/bot/profile/".$userId;
                $user = file_get_contents($website, false, $context);

                $user = json_decode($user, true);
                $userName = $user['displayName'];

                $textSend = "Hai juga, salam kenal ".$userName;
              } else {
                $textSend = "Maaf perintah tidak ditemukan.";
              }

              // $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textSend);
              // $result = $bot->pushMessage($userId, $textMessageBuilder);
              //
              // return $result->getHTTPStatus() . ' ' . $result->getRawBody();
            } else {
              if (($check = strpos($textReceived, "-")) !== FALSE) {
                $email = strtok($textReceived, '-');
                $password = substr($textReceived, strpos($textReceived, "-") +1);

                if($this->checkEmail($email) == true) {
                  if($this->checkPassword($userId, $email, $password)== true ) {
                    $textSend = "Selamat anda berhasil login, sekarang anda sudah bisa menggunakan fitur kuliah SIATMA Bot";
                  } else {
                    $textSend = "salah password";
                    // $textSend = "Maaf email atau password anda salah". PHP_EOL .
                    // "atau anda belum terdaftar". PHP_EOL .
                    // "jika anda belum mendaftar, silahkan daftarkan diri anda di : http://ditoraharjo.co/siatmabot/register";
                  }

                  // $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textSend);
                  // $result = $bot->pushMessage($userId, $textMessageBuilder);
                  //
                  // return $result->getHTTPStatus() . ' ' . $result->getRawBody();
                } else {
                  $textSend = "salah email";
                  // $textSend = "Maaf email atau password anda salah". PHP_EOL .
                  // "atau anda belum terdaftar". PHP_EOL .
                  // "jika anda belum mendaftar, silahkan daftarkan diri anda di : http://ditoraharjo.co/siatmabot/register";
                }
                // $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textSend);
                // $result = $bot->pushMessage($userId, $textMessageBuilder);
                //
                // return $result->getHTTPStatus() . ' ' . $result->getRawBody();
              } else {
                $textSend = "Maaf anda perlu login terlebih dahulu".PHP_EOL.
                "silahkan kirimkan chat email dan password yang sudah anda daftarkan di http://ditoraharjo.co/siatmabot/register". PHP_EOL .
                "dengan format : email-password". PHP_EOL .
                "contoh: asdf@gmail.com-1234 ";
              }
            }

            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textSend);
            $result = $bot->pushMessage($userId, $textMessageBuilder);

            return $result->getHTTPStatus() . ' ' . $result->getRawBody();

    			}
    		}
    	}
    }

    //CANNOT BE USED, HAVE TO DO IT IN MAIN BODY RIGHT AFTER RECEIVING UPDATES FROM WEBHOOKS
    public function sendMessage($userId, $textSend) {
      // or we can use pushMessage() instead to send reply message
      $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($textSend);
      $result = $bot->pushMessage($userId, $textMessageBuilder);

      return $result->getHTTPStatus() . ' ' . $result->getRawBody();
    }

    //CANNOT BE USED, HAVE TO DO IT IN MAIN BODY RIGHT AFTER RECEIVING UPDATES FROM WEBHOOKS
    public function sendReply($replyToken, $textSend) {
      // send same message as reply to user
      $result = $bot->replyText($replyToken, $textSend);
      return $result->getHTTPStatus() . ' ' . $result->getRawBody();
    }

    public function getUser($userId) {
      $check = ChatLogLine::select('id')->where('chat_id', $userId)->get();
      $checkCount = $check->count();

      if($checkCount == 0) {
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"Authorization: Bearer ".env('CHANNEL_ACCESS_TOKEN')
          )
        );
        $context = stream_context_create($opts);

        $website = "https://api.line.me/v2/bot/profile/".$userId;
        $user = file_get_contents($website, false, $context);

        $user = json_decode($user, true);

        $user_data = array();
        $user_data['chat_id'] = $userId;
        $user_data['display_name'] = $user['displayName'];

        DB::beginTransaction();

        try {
          ChatLogLine::create($user_data);

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
        // $text = "chat log baru dan berhasil disimpan";
        // Telegram::sendMessage([
        //   'chat_id' => $chatId,
        //   'text' => $text,
        // ]);
      }
      // else {
      //   $text = "chat log sudah ada";
      //   Telegram::sendMessage([
      //     'chat_id' => $chatId,
      //     'text' => $text,
      //   ]);
      // }
    }

    public function checkLogin($userId) {
      $check = ChatLogLine::select('id')->where('chat_id', $userId)->get();
      $checkCount = $check->count();

      if($checkCount == 1) {
        $chatLog = ChatLogLine::find($check);

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
      $check = User::select('id')->where('email', $email)->get();
      $checkCount = $check->count();

      if($checkCount != 0) {
        return true;
      } else {
        return false;
      }
    }

    public function checkPassword($userId, $email, $password) {
      $check = User::select('id')->where([
        ['email', $email],
        ['password', bcrypt($password)]
        ])->get();
      $checkCount = $check->count();

      if($checkCount != 0) {
        $checkChatLog = ChatLogLine::select('id')->where('chat_id', $userId)->get();
        $checkCountChatLog = $checkChatLog->count();

        if($checkCountChatLog == 1) {
          $user_data = User::find($check);
          $chat_log_data = ChatLogLine::find($checkChatLog);

          DB::beginTransaction();

          try {
            $user_data->chat_log_line_id = $chat_log_data->id;
            $chat_log_data->user_id = $user_data->id;

            $user_data->save();
            $chat_log_data->save();

            DB::commit();
          } catch (\Exception $e) {
            DB::rollback();

            throw $e;
          }
        } else {
          return false;
        }

        return true;
      } else {
        return false;
      }
    }

}
