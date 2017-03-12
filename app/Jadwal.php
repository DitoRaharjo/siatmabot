<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
      'user_id',
      'makul',
      'keyword',
      'kelas',
      'sesi_prodi_id',
      'sesi_prodi_id_selesai',
      'ruangan',
      'pengingat',
      'created_at',
      'updated_at',
      'deleted_at',
      'created_by',
      'updated_by',
      'deleted_by',
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }

  public function sesi() {
    return $this->belongsTo('App\SesiProdi', 'sesi_prodi_id');
  }

  public function sesiSelesai() {
    return $this->belongsTo('App\SesiProdi', 'sesi_prodi_id_selesai');
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
