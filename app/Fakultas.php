<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';

    protected $fillable = [
      'nama',
      'created_at',
      'updated_at',
      'deleted_at',
      'created_by',
      'updated_by',
      'deleted_by',
  ];

  public function prodi() {
    return $this->hasMany('App\Prodi', 'fakultas_id');
  }

  public function user() {
    return $this->hasMany('App\User', 'fakultas_id');
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
