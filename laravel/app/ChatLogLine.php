<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatLogLine extends Model
{
  protected $table = 'chat_log_line';

  protected $fillable = [
    'user_id',
    'chat_id',
    'display_name',
  ];

  public function user()
  {
      return $this->hasOne('App\User', 'user_id');
  }
}
