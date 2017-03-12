<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatLogFb extends Model
{
  protected $table = 'chat_log_fb';

  protected $fillable = [
    'user_id',
    'chat_id',
    'first_name',
    'last_name',
  ];

  public function user()
  {
      return $this->hasOne('App\User');
  }
}
