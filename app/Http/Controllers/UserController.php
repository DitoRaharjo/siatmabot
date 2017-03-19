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

class UserController extends Controller
{
    public function checkLoginFb() {
      $user = Auth::user();
      $password = "123";
      if(Hash::check($password, $user->password)) {
        $emailUser = $user->email;
        return view('front.dashboard.updatePassFb', compact('emailUser'));
      } else {
        return true;
      }
    }

    public function dashboardAdmin() {
      if($this->checkLoginFb() == true) {
        if (strcasecmp(Auth::user()->role,'admin')==0) {
          return view('front.dashboard.admin');
        } else {
          alert()->error('Akun anda tidak memiliki hak untuk melihat halaman ini', 'Pelanggaran Akun!');
          return redirect()->route('dashboard.mahasiswa');
        }
      }
    }

    public function dashboardMahasiswa() {
      if($this->checkLoginFb() == true) {
        if (strcasecmp(Auth::user()->role,'admin')==0 || strcasecmp(Auth::user()->role,'mahasiswa')==0) {
          return redirect()->route('jadwal.index');
          // return view('front.dashboard.mahasiswa');
        } else {
          alert()->error('Akun anda tidak memiliki hak untuk melihat halaman ini', 'Pelanggaran Akun!');
          return redirect()->route('user.login');
        }
      }
    }

    public function register() {
      $semuaProdi = Prodi::all();
      $semuaFakultas = Fakultas::all();

      return view('front.loginregister.register', compact('semuaProdi', 'semuaFakultas'));
    }

    public function checkEmailDuplicate($email) {
      $userCheck = User::select('id')->where('email', $email)->get()->count();

      if($userCheck == 0) {
        return true;
      } else {
        return false;
      }
    }

    public function doRegister(Request $request) {
      $this->validate($request, [
        // 'telegram_username' => 'required',
        'fullname' => 'required',
        'npm' => 'required',
        'prodi_id' => 'required',
        'email' => 'required|email',
        'password' => 'required'
      ]);

      $user_data = $request->except('_token');

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
        alert()->error('Maaf email anda sudah terdaftar', 'Gagal mendaftar!');
        return redirect()->route('user.register');
      }
    }

    public function login()
    {
      if (Auth::check()) {
        if(Auth::user()->status == 1) {
          if(Auth::user()->deleted_at == NULL) {
            if (strcasecmp(Auth::user()->role,'mahasiswa')==0)
            {
              $userlogin = Auth::user();
              return redirect()->route('dashboard.mahasiswa');
            } else if (strcasecmp(Auth::user()->role,'admin')==0) {
              $userlogin = Auth::user();
              return redirect()->route('dashboard.admin');
            } else {
                alert()->error('Maaf Role anda belum ditentukan', 'Gagal Login!');
                Auth::logout();
                return redirect()->route('user.login');
            }
          }
          else {
            Auth::logout();
            alert()->error('Mohon maaf akun anda telah di HAPUS oleh admin, silahkan hubungi admin', 'Akun Dihapus!');
            return redirect()->route('user.login');
          }
        }
        else {
          Auth::logout();
          alert()->error('Mohon maaf akun anda telah di NON-AKTIFKAN oleh admin, silahkan hubungi admin', 'Akun Non-Aktif!');
          return redirect()->route('user.login');
        }
      }
      else
      {
        $semuaProdi = Prodi::all();
        $semuaFakultas = Fakultas::all();

        return view('front.loginregister.login', compact('semuaProdi', 'semuaFakultas'));
      }
    }

    public function doLogin(Request $request)
    {
      $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required'
      ]);

      $user_data = $request->except('_token');

      if($this->checkLupaPass($user_data) == false)
      {
        if(Auth::attempt($user_data))
        {
          if(Auth::user()->status == 1) {
            if(Auth::user()->deleted_at == NULL) {
              if (strcasecmp(Auth::user()->role,'mahasiswa')==0) {
                $userlogin = Auth::user();
                return redirect()->route('dashboard.mahasiswa');
              } else if(strcasecmp(Auth::user()->role,'admin')==0) {
                $userlogin = Auth::user();
                return redirect()->route('dashboard.admin');
              } else {
                alert()->error('Maaf Role anda belum ditentukan', 'Gagal Login!');
                Auth::logout();
                return redirect()->route('user.login');
              }
            }
            else {
              Auth::logout();
              alert()->error('Mohon maaf akun anda telah di HAPUS oleh admin, silahkan hubungi admin', 'Akun Dihapus!');
              return redirect()->route('user.login');
            }
          }
          else {
            Auth::logout();
            alert()->error('Mohon maaf akun anda telah di NON-AKTIFKAN oleh admin, silahkan hubungi admin', 'Akun Non-Aktif!');
            return redirect()->route('user.login');
          }
        }
        else
        {
          alert()->error('Username atau Password anda salah', 'Gagal Login!');
          return redirect()->route('user.login');
        }
      }
      else {
        $emailUser = $user_data['email'];
        return view('front.lupapass.index', compact('emailUser'));
      }
    }

    public function checkLupaPass($user_data)
    {
      $userCount = User::where('email', '=', $user_data['email'])->count();
      $user = User::where('email', '=', $user_data['email'])->get();

      if($userCount == 0) {
        return false;
      }
      else {
        if($user[0]->lupa_pass != NULL) {
          return true;
        }
      }
    }

    public function gantiPassDo(Request $request)
    {
      $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required',
          'password_confirmation' => 'required',
      ]);

      $user_data = $request->except('_token');

      DB::beginTransaction();

      try {
        $userId = User::select('id')->where('email', '=', $user_data['email'])->get();

        $user = User::find($userId[0]->id);

        $passwordBaru = bcrypt($user_data['password']);

        $user->password = $passwordBaru;
        $user->lupa_pass = NULL;
        $user->save();

        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();

        throw $e;
      }

      alert()->success('Password berhasil diperbaharui', 'Berhasil!');
      if(strcasecmp($user->role, "admin")==0) {
        return redirect()->route('dashboard.admin');
      } else {
        return redirect()->route('dashboard.mahasiswa');
      }
    }

    public function doLogout()
    {
      Auth::logout();

      alert()->success('Berhasil Log Out', 'Log Out!');
      return redirect()->route('user.login');
    }
}
