<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

class SocialAuthController extends Controller
{
  public function redirect()
  {
      return Socialite::driver('facebook')->redirect();
  }

  public function callback()
  {
      $providerUser = Socialite::driver('facebook')->user();

      $token = $providerUser->getToken();

      echo $providerUser->getId() . "</br>";
      echo $providerUser->getName() . "</br>";
      echo $providerUser->getEmail() . "</br>";

      $website = "https://graph.facebook.com/v2.8/me?access_token=PAGE_ACCESS_TOKEN\&fields=recipient\&account_linking_token=ACCOUNT_LINKING_TOKEN".$userId."?access_token=".env('FB_PAGE_ACCESS_TOKEN');
      $user_data = file_get_contents($website);

      return json_decode($user_data);

  }
}
