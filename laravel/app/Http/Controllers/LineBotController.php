<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use  LINE\LINEBot\HTTPClient\GuzzleHTTPClient ;
use  LINE\LINEBot\Message\RichMessage\Markup ;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Carbon\Carbon;

use DB;

use App\User;
use App\Prodi;
use App\Fakultas;
use App\ChatLog;
use Telegram;

class LineBotController extends Controller
{
    public function updates(Request $request) {

      $channelSecret = "5b0495e91e9257f8a212bc594ddf1eb8"; // Channel secret string
      $httpRequestBody = $request; // Request body string
      $hash = hash_hmac('sha256', $httpRequestBody, $channelSecret, true);
      $signature = base64_encode($hash);
      // Compare X-Line-Signature request header string and the signature

      $chatId = 253128578;
      Telegram::sendMessage([
        'chat_id' => $chatId,
        'text' => "asdf",
      ]);

      return Response::json(['status' => 'OK'],200);

      // Get "from" from information sent from user

      // $from  =  $request['result'][0]['Content']['from'];
      //
      //  // Of the channel and the like setting
      //  $config  =  [
      //          'channelId'  =>  env('LINE_channelId') ,
      //          'ChannelSecret'  =>  env('LINE_ChannelSecret') ,
      //          'ChannelMid'  =>  env('LINE_ChannelMid') ,
      //  ] ;
      //  $Bot  =  new  LINEBot ( $config ,  new  GuzzleHTTPClient ( $config ));
      //
      //  //markup  rich message
      //  $markup =  ( new  Markup ( 1040 ))
      //      // open example.com when the top half of the rich message is tapped
      //      -> setAction ( 'OpenExampleCom' ,  'openexamplecom' ,  'https: //example.com/ ' )
      //      -> addListener ( ' OpenExampleCom ' ,  0 ,  0 ,  1040 ,  520 )
      //      // send the message' user message 'to the user when the lower half of the rich message is tapped
      //      -> SetAction ( 'GetUserToSendMessage' ,  'user message' ,  '',  'SendMessage' )
      //      -> addListener ( 'GetUserToSendMessage' ,  0 ,  520 ,  1040 ,  1040 );
      //
      //  // Generate the base URL of the image dynamically
      //  $img_base_url  =  'https://myapp.com/img/'  .  Urlencode ( $request['result'][0]['content'] ['text']) ;
      //  // send rich message
      //  $bot -> sendRichMessage ( $from ,  $img_base_url ,  'Alt text' ,  $markup );
    }
}
