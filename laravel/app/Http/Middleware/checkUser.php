<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class checkUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(Auth::check())
      {
        if(Auth::user()->status == 0) {
          alert()->error('Mohon maaf akun anda telah di NON-AKTIFKAN oleh admin, silahkan hubungi admin', 'Akun Non-Aktif!');
          if(strcasecmp(Auth::user()->role,'admin')==0) {
            Auth::logout();
            return redirect()->route('user.login');
          }
          else {
            Auth::logout();
            return redirect()->route('user.login');
          }
        }
        else if(Auth::user()->deleted_at != NULL) {
          alert()->error('Mohon maaf akun anda telah di HAPUS oleh admin, silahkan hubungi admin', 'Akun Dihapus!');
          if(strcasecmp(Auth::user()->role,'admin')==0) {
            Auth::logout();
            return redirect()->route('user.login');
          }
          else {
            Auth::logout();
            return redirect()->route('user.login');
          }
        }
      } else {
        alert()->error('Mohon maaf anda belum login, silahkan login terlebih dahulu', 'Belum Login!');
        return redirect()->route('user.login');
      }


        return $next($request);
    }
}
