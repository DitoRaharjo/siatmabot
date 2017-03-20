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

      // if(isset($responses_convert->entry[0]->messaging[0]->postback->payload)) {
      //   $postback = $responses_convert->entry[0]->messaging[0]->postback->payload;
      //   $userId = $responses_convert->entry[0]->messaging[0]->sender->id;
      //
      //   $this->getUser($userId);
      //
      //   if($this->checkLogin($userId) == false) {
      //     if(strcasecmp($postback, "GET_STARTED")==0) {
      //       $this->setRead($userId);
      //       $this->setTypingOn($userId);
      //       $textSend = "Jika anda belum mendaftarkan diri, silahkan daftar terlebih dahulu";
      //       $this->sendGetStartedMessage($userId, $textSend);
      //       $textSend = "Jika anda sudah mendaftarkan diri, silahkan login dengan format :";
      //       $this->sendMessage($userId, $textSend);
      //       $textSend = "username-password";
      //       $this->sendMessage($userId, $textSend);
      //       $textSend = "contoh : asdf@gmail.com-1234";
      //       $this->sendMessage($userId, $textSend);
      //       $textSend = "untuk info lebih lanjut, kirim perintah 'help' ";
      //       $this->sendMessage($userId, $textSend);
      //       $this->setTypingOff($userId);
      //     }
      //   }
      // } else {
      //   $userId = $responses_convert->entry[0]->messaging[0]->sender->id;
      //   $textReceived = $responses_convert->entry[0]->messaging[0]->message->text;
      //   $registerUrl = "http://www.ditoraharjo.co/siatmabot/register";
      //   $helpCommand = "Halo, berikut perintah-perintah yang dapat digunakan di SIATMA Bot : " . PHP_EOL .
      //   "makul : Untuk menampilkan semua jadwal kuliah" . PHP_EOL .
      //   "(keyword) : Untuk menampilkan informasi jadwal kuliah sesuai dengan keyword yang sudah ditentukan". PHP_EOL .
      //   "logout : Untuk keluar dari akun yang sedang anda gunakan pada platform chat";
      //
      //   $this->getUser($userId);
      //
      //   if($this->checkLogin($userId) == true) {
      //     $checkMakulResult = $this->checkMakul($userId, $textReceived);
      //     if($checkMakulResult != false) {
      //       $textSend = $checkMakulResult;
      //     } else {
      //       if(strcasecmp($textReceived, "hai")==0) {
      //         $textSend = "Halo juga :D";
      //       } else if(strcasecmp($textReceived, "help")==0) {
      //         $textSend = $helpCommand;
      //       } else if(strcasecmp($textReceived, "salam kenal")==0) {
      //         $user_data = $this->getUserProfile($userId);
      //         $textSend = "Salam kenal juga, ".$user_data->first_name." ".$user_data->last_name;
      //       } else if(strcasecmp($textReceived, "makul")==0) {
      //         $textSend = $this->getJadwalKuliah($userId);
      //       } else if(strcasecmp($textReceived, "logout")==0) {
      //         $this->chatLogout($userId);
      //         $textSend = "Logout berhasil";
      //       } else {
      //         $textSend = "Maaf perintah tidak ditemukan";
      //       }
      //     }
      //     $this->setSendCondition($userId, $textSend);
      //   } else if(strcasecmp($textReceived, "help")==0) {
      //     $textSend = $helpCommand;
      //     $this->setSendCondition($userId, $textSend);
      //     // $this->sendButtonMessage($userId, $textSend);
      //   } else {
      //     if (($check = strpos($textReceived, "-")) !== FALSE) {
      //       $email = strtok($textReceived, '-');
      //       $password = substr($textReceived, strpos($textReceived, "-") +1);
      //
      //       if($this->checkEmail($email) == true) {
      //         if($this->checkPassword($userId, $email, $password)== true ) {
      //           $textSend = "Selamat anda berhasil login, sekarang anda sudah bisa menggunakan fitur kuliah SIATMA Bot";
      //           $this->sendMessage($userId, $textSend);
      //         } else {
      //           $this->setRead($userId);
      //           $this->setTypingOn($userId);
      //           $textSend = "Maaf email atau password anda salah";
      //           $this->sendMessage($userId, $textSend);
      //           $textSend = "Jika anda belum mendaftarkan diri, silahkan daftar terlebih dahulu";
      //           $this->sendGetStartedMessage($userId, $textSend);
      //           $this->setTypingOff($userId);
      //         }
      //       } else {
      //         $this->setRead($userId);
      //         $this->setTypingOn($userId);
      //         $textSend = "Maaf email atau password anda salah";
      //         $this->sendMessage($userId, $textSend);
      //         $textSend = "Jika anda belum mendaftarkan diri, silahkan daftar terlebih dahulu";
      //         $this->sendGetStartedMessage($userId, $textSend);
      //         $this->setTypingOff($userId);
      //       }
      //     } else {
      //       // $textSend = "Maaf anda perlu login terlebih dahulu".PHP_EOL.
      //       // "silahkan kirimkan chat email dan password yang sudah anda daftarkan di ". PHP_EOL .$registerUrl. PHP_EOL .
      //       // "dengan format : email-password". PHP_EOL .
      //       // "contoh: asdf@gmail.com-1234 " . PHP_EOL .
      //       // "Jika anda kesulitan, silahkan gunakan perintah 'help' ";
      //       $this->setRead($userId);
      //       $this->setTypingOn($userId);
      //       $textSend = "Jika anda belum mendaftarkan diri, silahkan daftar terlebih dahulu";
      //       $this->sendGetStartedMessage($userId, $textSend);
      //       $textSend = "Jika anda sudah mendaftarkan diri, silahkan login dengan format :";
      //       $this->sendMessage($userId, $textSend);
      //       $textSend = "username-password";
      //       $this->sendMessage($userId, $textSend);
      //       $textSend = "contoh : asdf@gmail.com-1234";
      //       $this->sendMessage($userId, $textSend);
      //       $textSend = "untuk info lebih lanjut, kirim perintah 'help' ";
      //       $this->sendMessage($userId, $textSend);
      //       $this->setTypingOff($userId);
      //     }
      //     // $this->setSendCondition($userId, $textSend);
      //   }
      // }

      try {
        if(isset($responses_convert->entry[0]->messaging[0]->postback->payload)) {
          $postback = $responses_convert->entry[0]->messaging[0]->postback->payload;
          $userId = $responses_convert->entry[0]->messaging[0]->sender->id;

          $textSend = $postback;
          $this->setSendCondition($userId, $textSend);
        } else {
          $userId = $responses_convert->entry[0]->messaging[0]->sender->id;
          $textReceived = $responses_convert->entry[0]->messaging[0]->message->text;

          $textSend = $textReceived;
          $this->setSendCondition($userId, $textSend);
        }
      } catch(\Exception $e) {
        $chatId = 253128578;
        $textTelegram = $e;

        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $textTelegram,
        ]);
      }

      $chatId = 253128578;
      $textTelegram = $responses;

      Telegram::sendMessage([
        'chat_id' => $chatId,
        'text' => $textTelegram,
      ]);

      return response()->json("OK");
    }

    public function chatLogout($userId) {
      $check = ChatLogFb::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLogFb::find($check);

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

    public function checkMakul($userId, $textReceived) {
      $check = ChatLogFb::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLogFb::find($check);

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

    public function getJadwalKuliah($userId) {
      $check = ChatLogFb::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLogFb::find($check);

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

    public function sendGetStartedMessage($userId, $textSend) {
        $data = array(
          'recipient'=>array('id'=>"$userId"),
          'message'=>array('attachment'=>array(
              'type'=>"template",
              'payload'=>array(
                'template_type'=>"button",
                'text'=>"$textSend",
                'buttons'=>array(
                  [
                    'type'=>"web_url",
                    'url'=>"http://ditoraharjo.co/siatmabot/register",
                    'title'=>"Register"
                  ]
                )
              )
            )
          )
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

    public function sendLoginButton($userId, $textSend) {
        $data = array(
          'recipient'=>array('id'=>"$userId"),
          'message'=>array('attachment'=>array(
              'type'=>"template",
              'payload'=>array(
                'template_type'=>"button",
                'text'=>"$textSend",
                'buttons'=>array(
                  [
                    'type'=>"account_link",
                    'url'=>"https://ditoraharjo.co/siatmabot/fb-callback",
                  ]
                )
              )
            )
          )
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

    public function sendButtonMessage($userId, $textSend) {
        $data = array(
          'recipient'=>array('id'=>"$userId"),
          'message'=>array('attachment'=>array(
              'type'=>"template",
              'payload'=>array(
                'template_type'=>"button",
                'text'=>"What do you want to do next?",
                'buttons'=>array(
                  [
                    'type'=>"web_url",
                    'url'=>"http://ditoraharjo.co/siatmabot/register",
                    'title'=>"Register"
                  ],
                  [
                    'type'=>"postback",
                    'title'=>"Start Chatting",
                    'payload'=>"USER_START_CHATTING"
                  ]
                )
              )
            )
          )
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
