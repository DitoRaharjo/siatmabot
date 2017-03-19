<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

use Carbon\Carbon;

use Hash;
use Response;
use Input;
use DB;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Prodi;
use App\Fakultas;
use App\ChatLog;
use App\ChatLogFb;
use Telegram;

class SocialAuthController extends Controller
{
  public function redirect()
  {
      return Socialite::driver('facebook')->redirect();
  }

  public function callback()
  {
      $providerUser = Socialite::driver('facebook')->user();

      $fbId = $providerUser->getId();
      $fbName = $providerUser->getName();
      $fbEmail = $providerUser->getEmail();

      $user_data = array();

      $user_data['fullname'] = $fbName;
      $user_data['email'] = $fbEmail;
      $user_data['npm'] = "0";
      $user_data['prodi_id'] = 13;
      $user_data['password'] = "123";

      if(!isset($request['telegram_username']) ) {
        $user_data['telegram_username'] = "";
      }

      if($this->checkEmailDuplicate($user_data['email']) == true ) {
        $fakultasId = Prodi::find($user_data['prodi_id'])->fakultas->id;

        $user_data['fakultas_id'] = $fakultasId;
        $user_data['password'] = bcrypt($user_data['password']);
        $user_data['role'] = "Mahasiswa";
        $user_data['registerdate'] = Carbon::now();

        $checkChatLog = ChatLog::select('id')->where('username', $user_data['telegram_username'])->get();
        $checkCount = $checkChatLog->count();
        if($checkCount != 0) {
          $chatLogId = ChatLog::find($checkChatLog)->id;
          $chatId = ChatLog::find($checkChatLog)->chat_id;
          $user_data['chat_log_id'] = $chatLogId;
          $user_data['chat_id'] = $chatId;
        }

        DB::beginTransaction();

        try {
          $user = User::create($user_data);
          $userId = $user->id;

          if($checkCount != 0) {
            $chatLog = ChatLog::find($checkChatLog);
            $chatLog->user_id = $userId;
            $chatLog->save();
          }

          DB::commit();

          Auth::login($user);

          alert()->success('Akun anda berhasil di register', 'Berhasil!');
          return redirect()->route('dashboard.mahasiswa');
        } catch (\Exception $e) {
          DB::rollback();

          throw $e;
        }
      } else {
        $userCheck = User::select('id')->where('email', $user_data['email'])->get();
        $user = User::find($userCheck);

        Auth::login($user);

        if($this->checkLoginFb() == true) {
          if(strcasecmp($user->role, "admin")==0) {
            return redirect()->route('dashboard.admin');
          } else {
            return redirect()->route('dashboard.mahasiswa');
          }
        } else {
          $semuaProdi = Prodi::all();
          $semuaFakultas = Fakultas::all();
          $emailUser = $user->email;

          return view('front.dashboard.updatePassFb', compact('emailUser', 'semuaProdi', 'semuaFakultas'));
        }
      }
  }

  public function login(Request $request) {
    $this->validate($request, [
        'npm' => 'required',
        'prodi_id' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'password_confirmation' => 'required',
    ]);

    $user_data = $request->except('_token');

    if(!isset($request['telegram_username']) ) {
      $user_data['telegram_username'] = "";
    }

    $fakultasId = Prodi::find($user_data['prodi_id'])->fakultas->id;

    $user_data['fakultas_id'] = $fakultasId;

    DB::beginTransaction();

    try {
      $userId = User::select('id')->where('email', '=', $user_data['email'])->get();

      $user = User::find($userId[0]->id);

      $passwordBaru = bcrypt($user_data['password']);

      $user->update($user_data);

      DB::commit();

      alert()->success('Data berhasil diperbaharui', 'Berhasil!');
      if(strcasecmp($user->role, "admin")==0) {
        return redirect()->route('dashboard.admin');
      } else {
        return redirect()->route('dashboard.mahasiswa');
      }
    } catch (\Exception $e) {
      DB::rollback();

      throw $e;
    }
  }

  public function checkLoginFb() {
    $user = Auth::user();
    $password = "123";
    if(Hash::check($password, $user->password)) {
      return false;
    } else {
      return true;
    }
  }

  public function checkEmailDuplicate($email) {
    $userCheck = User::select('id')->where('email', $email)->get()->count();

    if($userCheck == 0) {
      return true;
    } else {
      return false;
    }
  }
}
