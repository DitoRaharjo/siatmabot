<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesiProdi extends Model
{
  protected $table = 'sesi_prodi';

  protected $fillable = [
    'prodi_id',
    'sesi_id',
    'jam',
    'created_at',
    'updated_at',
    'deleted_at',
    'created_by',
    'updated_by',
    'deleted_by',
  ];

  public function prodi() {
    return $this->belongsTo('App\Prodi');
  }

  public function sesi() {
    return $this->belongsTo('App\Sesi');
  }

  public function jadwal() {
    return $this->hasMany('App\Jadwal', 'sesi_prodi_id');
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
