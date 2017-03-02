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
    public function privacyPolicy() {
      return view('facebookPrivacyPolicy.index');
    }
    public function updates() {
      /* ---------------- For Verifying FB Messenger API Webhook ---------------- */
      // $local_verify_token = env('FB_WEBHOOK_VERIFY_TOKEN');
      // $hub_verify_token = Input::get('hub_verify_token');
      //
      // if($local_verify_token == $hub_verify_token) {
      //   return Input::get('hub_challenge');
      // } else {
      //   return "Bad verify token";
      // }
      /* ---------------- For Verifying FB Messenger API Webhook ---------------- */

      $responses = file_get_contents("php://input");
      $responses = json_decode($responses);

      $userId = $responses->entry[0]->messaging[0]->sender->id;

      $data = array(
        'recipient'=>array('id'=>$userId),
        'message'=>array('text'=>"Halo juga :D")
      );

      $opts = array(
        'http'=>array(
          'method'=>"POST",
          'content'=>json_encode($data),
          'header'=>"Content-Type: application/json"
        )
      );
      $context = stream_context_create($opts);

      $website = "https://graph.facebook.com/v2.6/me/messages?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      file_get_contents($website, false, $context);
    }
}
