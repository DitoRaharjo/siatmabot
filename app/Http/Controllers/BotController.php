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

      $textResponse = $responses["message"]["text"];
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

      if($this->checkAll($responses) == false) {
        $linkRegister = "https://google.com";
        $text = "Maaf sepertinya anda belum terdaftar, silahkan daftarkan diri anda pada link dibawah " . PHP_EOL .
          "<a href='".$linkRegister."'>LINK</a>";
        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
          'parse_mode' => "HTML",
        ]);
        // Apakah anda sudah mendaftar? Kalau belum silahkan daftar
        // atau apakah anda mengganti username? silahkan update username anda di aplikasi
      } else {
        $checkMakulResult = $this->checkMakul($chatId, $textReceived);
        if($checkMakulResult != false) {
          $text = $checkMakulResult;
        } else {
          if(strcasecmp($textResponse, "/start")==0) {
            $text = 'Halo salam kenal ' . $chatName . ', saya SIATMA BOT';
          } else if(strcasecmp($textResponse, "hai")==0) {
            $text = "Hai juga :D";
          } else if(strcasecmp($textResponse, "salam kenal")==0) {
            $text = "Salam kenal ". $chatName;
          } else if(strcasecmp($textResponse, "npm dong")==0) {
            $text = "Under maintenance, please be patient";
          } else if(strcasecmp($textResponse, "chat id dong")==0) {
            $text = "Chat ID : ".$chatId;
          } else if(strcasecmp($textReceived, "makul")==0) {
            $text = $this->getJadwalKuliah($chatId);
          } else {
            $text = "Perintah tidak ditemukan";
          }
        }

        Telegram::sendMessage([
          'chat_id' => $chatId,
          'text' => $text,
        ]);
      }
    }

    public function getJadwalKuliah($userId) {
      $check = ChatLog::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLog::find($check);

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
      $check = ChatLog::select('id')->where('chat_id', $userId)->get();
      $chatLog = ChatLog::find($check);

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

    public function checkAll($responses) {
      if($this->checkUserChatId($responses) == false) {
        if($this->checkUserUsername($responses) == true) {
          $this->updateChatId($responses);
          return true;
        } else if($this->checkUserUsername($responses) == false) {
          return false;
        }
      } else {
        return true;
      }
    }

    public function checkUserChatId($responses) {
      $chatId = $responses["message"]["chat"]["id"];
      $check = User::select('id')->where('chat_id', $chatId)->get();
      $checkCount = $check->count();

      if($checkCount == 0) {
        // $text = "chat_id tidak ditemukan";
        // Telegram::sendMessage([
        //   'chat_id' => $chatId,
        //   'text' => $text,
        // ]);
        return false;
      } else {
        // $text = "chat_id ditemukan";
        // Telegram::sendMessage([
        //   'chat_id' => $chatId,
        //   'text' => $text,
        // ]);
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
        // $text = "username tidak ditemukan";
        // Telegram::sendMessage([
        //   'chat_id' => $chatId,
        //   'text' => $text,
        // ]);
        return false;
      } else {
        // $text = "username ditemukan";
        // Telegram::sendMessage([
        //   'chat_id' => $chatId,
        //   'text' => $text,
        // ]);
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
              // $text = "Berhasil Update chat_log_id, Berhasil update chat_id";
              // Telegram::sendMessage([
              //   'chat_id' => $chatId,
              //   'text' => $text,
              // ]);
            } else {
              $userUpdate->chat_id = $chatId;
              $userUpdate->save();
              // $text = "Gagal Update chat_log_id, Berhasil update chat_id";
              // Telegram::sendMessage([
              //   'chat_id' => $chatId,
              //   'text' => $text,
              // ]);
            }
          } else {
            $userUpdate->chat_id = $chatId;
            $userUpdate->save();
            // $text = "Chat Log ID sudah ada, Berhasil update chat_id";
            // Telegram::sendMessage([
            //   'chat_id' => $chatId,
            //   'text' => $text,
            // ]);
          }

          DB::commit();
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
      }
      else {
        // $text = "Gagal update chat_id";
        // Telegram::sendMessage([
        //   'chat_id' => $chatId,
        //   'text' => $text,
        // ]);
      }
    }
}
