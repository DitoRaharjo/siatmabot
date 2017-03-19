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
      $providerUser = \Socialite::driver('facebook')->user();

      echo $providerUser->getId() . "</br>";
      echo $providerUser->getNickname() . "</br>";
      echo $providerUser->getName() . "</br>";
      echo $providerUser->getEmail() . "</br>";
  }
}
