<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    protected $table = 'sesi';

    protected $fillable = [
      'hari',
      'sesi',
      'created_at',
      'updated_at',
      'deleted_at',
      'created_by',
      'updated_by',
      'deleted_by',
  ];

  public function sesiprodi() {
    return $this->hasMany('App\SesiProdi', 'sesi_id');
  }

  public function userCreate()
  {
      return $this->belongsTo('App\User', 'created_by');
  }

  public function userUpdate()
  {
      return $this->belongsTo('App\User', 'updated_by');
  }

  public function userDelete()
  {
      return $this->belongsTo('App\User', 'deleted_by');
  }
}
