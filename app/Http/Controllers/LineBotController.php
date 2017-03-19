<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Carbon\Carbon;

use Hash;
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
            $registerUrl = "http://ditoraharjo.co/siatmabot/register";
            // $registerUrl = "UNDER MAINTENANCE";
            $userId = $event['source']['userId'];
            $replyToken = $event['replyToken'];

            //To save chat log
            $this->getUser($userId);

            $textReceived = $event['message']['text'];
            $helpCommand = "Halo, berikut perintah-perintah yang dapat digunakan di SIATMA Bot : " . PHP_EOL .
            "makul : Untuk menampilkan semua jadwal kuliah" . PHP_EOL .
            "(keyword) : Untuk menampilkan informasi jadwal kuliah sesuai dengan keyword yang sudah ditentukan" . PHP_EOL .
            "logout : Untuk keluar dari akun yang sedang anda gunakan pada platform chat". PHP_EOL .
            PHP_EOL . "Jika anda belum pernah melakukan login sebelumnya, maka anda perlu login terlebih dahulu di platform chat dengan mengetikkan email dan password anda dengan format :". PHP_EOL ."email-password". PHP_EOL ."contoh : asd@gmail.com-asdfghj";

            if($this->checkLogin($userId) == true) {
              $checkMakulResult = $this->checkMakul($userId, $textReceived);
              if($checkMakulResult != false) {
                $textSend = $checkMakulResult;
              } else {
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
                } else if(strcasecmp($textReceived, "makul")==0) {

                  $textSend = $this->getJadwalKuliah($userId);

                } else if(strcasecmp($textReceived, "help")==0) {
                  $textSend = $helpCommand;
                } else if(strcasecmp($textReceived, "logout")==0) {
                  $this->chatLogout($userId);
                  $textSend = "Logout berhasil";
                } else {
                  $textSend = "Maaf perintah tidak ditemukan.";
                }
              }

            } else if(strcasecmp($textReceived, "help")==0) {
              $textSend = $helpCommand;
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
                    "jika anda belum mendaftar, silahkan daftarkan diri anda di : ". PHP_EOL .$registerUrl . PHP_EOL .
                    "Jika anda kesulitan, silahkan gunakan perintah 'help' ";
                  }
                } else {
                  $textSend = "Maaf email atau password anda salah". PHP_EOL .
                  "atau anda belum terdaftar". PHP_EOL .
                  "jika anda belum mendaftar, silahkan daftarkan diri anda di : ". PHP_EOL .$registerUrl . PHP_EOL .
                  "Jika anda kesulitan, silahkan gunakan perintah 'help' ";
                }
              } else {
                $textSend = "Maaf anda perlu login terlebih dahulu".PHP_EOL.
                "silahkan kirimkan chat email dan password yang sudah anda daftarkan di ". PHP_EOL .$registerUrl. PHP_EOL .
                "dengan format : email-password". PHP_EOL .
                "contoh: asdf@gmail.com-1234 " . PHP_EOL .
                "Jika anda kesulitan, silahkan gunakan perintah 'help' ";
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

    public function chatLogout($userId) {
      $check = ChatLogLine::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLogLine::find($check);

      $user = $chatLog->user;

      DB::beginTransaction();

      try {
        $chatLog->user_id = 0;
        $chatLog->save();

        $user->chat_log_fb_id = NULL;
        $user->save();

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();

        throw $e;
      }
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
      }
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
          $checkChatLog = ChatLogLine::select('id')->where('chat_id', $userId)->get();
          $checkCountChatLog = $checkChatLog->count();

          if($checkCountChatLog == 1) {
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

    public function getJadwalKuliah($userId) {
      $check = ChatLogLine::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLogLine::find($check);

      $semuaJadwal = $chatLog->user->jadwal;

      for ($i = 0 ; $i<$semuaJadwal->count(); $i++) {
        for($j = 0 ; $j<$semuaJadwal->count(); $j++) {
          if($semuaJadwal[$i]->sesi_prodi_id < $semuaJadwal[$j]->sesi_prodi_id) {
            $temp = $semuaJadwal[$i];
            $semuaJadwal[$i] = $semuaJadwal[$j];
            $semuaJadwal[$j] = $temp;
          }
        }
      }

      if($semuaJadwal->count() > 0) {
        $senin = "";
        $selasa = "";
        $rabu = "";
        $kamis = "";
        $jumat = "";
        $sabtu = "";

        foreach ($semuaJadwal as $jadwal) {
          $makul = $jadwal->makul;
          $kelas = $jadwal->kelas;
          $ruangan = $jadwal->ruangan;
          $sesiMulai = $jadwal->sesi->sesi->sesi;
          $sesiSelesai = "";
          // if($jadwal->sesi_prodi_id_selesai != 0) {
          //   $sesiSelesai = $jadwal->sesiSelesai->sesi->sesi;
          //
          //   $header = "Mata Kuliah : " . $makul ." (". $kelas . ")";
          //   $middle = "Ruangan : " . $ruangan;
          //   $bottom = "Sesi : " . $sesiMulai;
          // } else {
          //   $header = "Mata Kuliah : " . $makul ." (". $kelas . ")";
          //   $middle = "Ruangan : " . $ruangan;
          //   $bottom = "Sesi : " . $sesiMulai;
          // }
          $header = "Mata Kuliah : " . $makul ." (". $kelas . ")";
          $middle = "Ruangan : " . $ruangan;
          $bottom = "Sesi : " . $sesiMulai;

          $summary = $header . PHP_EOL . $middle . PHP_EOL . $bottom . PHP_EOL . PHP_EOL;

          if(strcasecmp($jadwal->sesi->sesi->hari, "Senin")==0) {
            $senin = $senin . $summary;
          } else if(strcasecmp($jadwal->sesi->sesi->hari, "Selasa")==0) {
            $selasa = $selasa . $summary;
          } else if(strcasecmp($jadwal->sesi->sesi->hari, "Rabu")==0) {
            $rabu = $rabu . $summary;
          } else if(strcasecmp($jadwal->sesi->sesi->hari, "Kamis")==0) {
            $kamis = $kamis . $summary;
          } else if(strcasecmp($jadwal->sesi->sesi->hari, "Jumat")==0) {
            $jumat = $jumat . $summary;
          } else if(strcasecmp($jadwal->sesi->sesi->hari, "Sabtu")==0) {
            $sabtu = $sabtu . $summary;
          }
        }

        if($senin == "") {
          $senin = "KOSONG" . PHP_EOL . PHP_EOL;
        }
        if($selasa == "") {
          $selasa = "KOSONG" . PHP_EOL . PHP_EOL;
        }
        if($rabu == "") {
          $rabu = "KOSONG" . PHP_EOL . PHP_EOL;
        }
        if($kamis == "") {
          $kamis = "KOSONG" . PHP_EOL . PHP_EOL;
        }
        if($jumat == "") {
          $jumat = "KOSONG" . PHP_EOL . PHP_EOL;
        }
        if($sabtu == "") {
          $sabtu = "KOSONG" . PHP_EOL . PHP_EOL;
        }

        $text = "--===Senin===--" . PHP_EOL . $senin . "--===Selasa===--" . PHP_EOL . $selasa . "--===Rabu===--" . PHP_EOL . $rabu . "--===Kamis===--" . PHP_EOL . $kamis . "--===Jumat===--" . PHP_EOL . $jumat;

        return $text;
      } else {
        $text = "Maaf anda belum memasukkan data jadwal kuliah.";
        return $text;
      }
    }

    public function checkMakul($userId, $textReceived) {
      $check = ChatLogLine::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLogLine::find($check);

      $semuaJadwal = $chatLog->user->jadwal;

      $total = "";

      foreach ($semuaJadwal as $jadwal) {
        if(strcasecmp($jadwal->keyword, $textReceived)==0 && $jadwal->sesi_prodi_id_selesai == 0) {
          $makul = $jadwal->makul;
          $kelas = $jadwal->kelas;
          $ruangan = $jadwal->ruangan;
          $sesiMulai = $jadwal->sesi->sesi->sesi;

          $header = "Mata Kuliah : " . $makul ." (". $kelas . ")";
          $middle = "Ruangan : " . $ruangan;
          $bottom = "Sesi : " . $sesiMulai;
          $summary = $header . PHP_EOL . $middle . PHP_EOL . $bottom . PHP_EOL . PHP_EOL;

          $hari = $jadwal->sesi->sesi->hari;
          $text = "--===".$hari."===--". PHP_EOL . $summary;
          return $text;
        } else if(strcasecmp($jadwal->keyword, $textReceived)==0 && $jadwal->sesi_prodi_id_selesai != 0) {
          $hari = $jadwal->sesi->sesi->hari;
          $sesiSelesai = $jadwal->sesiSelesai->sesi->sesi;

          $makul = $jadwal->makul;
          $kelas = $jadwal->kelas;
          $ruangan = $jadwal->ruangan;
          $sesiMulai = $jadwal->sesi->sesi->sesi;

          $header = "Mata Kuliah : " . $makul ." (". $kelas . ")";
          $middle = "Ruangan : " . $ruangan;
          $bottom = "Sesi : " . $sesiMulai . " - " . $sesiSelesai;
          $summary = $header . PHP_EOL . $middle . PHP_EOL . $bottom . PHP_EOL . PHP_EOL;
          $text = "--===".$hari."===--". PHP_EOL . $summary;
          return $text;
        }
      }
      return false;
    }

}
