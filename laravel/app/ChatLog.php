<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
  protected $table = 'chat_log';

  protected $fillable = [
    'user_id',
    'chat_id',
    'first_name',
    'last_name',
    'username',
  ];

  public function user()
  {
      return $this->hasOne('App\User', 'user_id');
  }
}
