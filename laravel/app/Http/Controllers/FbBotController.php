<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Carbon\Carbon;

use Input;
use DB;

use App\User;
use App\Prodi;
use App\Fakultas;
use App\ChatLog;
use Telegram;

class FbBotController extends Controller
{
    public function updates() {
      // $local_verify_token = env('FB_WEBHOOK_VERIFY_TOKEN');
      // $hub_verify_token = Input::get('hub_verify_token');
      //
      // if($local_verify_token == $hub_verify_token) {
      //   return Input::get('hub_challenge');
      // } else {
      //   return "Bad verify token";
      // }

      file_put_contents("fb.txt", file_get_contents("php://input"));
    }
}
