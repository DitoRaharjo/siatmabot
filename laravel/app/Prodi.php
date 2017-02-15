<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodi';

    protected $fillable = [
      'fakultas_id',
      'nama',
      'created_at',
      'updated_at',
      'deleted_at',
      'created_by',
      'updated_by',
      'deleted_by',
  ];

  public function fakultas() {
    return $this->belongsTo('App\Fakultas');
  }

  public function sesiprodi() {
    return $this->hasMany('App\SesiProdi', 'prodi_id');
  }

  public function user() {
    return $this->hasMany('App\User', 'prodi_id');
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
