<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prodi_id',
        'fakultas_id',
        'fullname',
        'password',
        'lupa_pass',
        'npm',
        'role',
        'email',
        'telegram_username',
        'status',
        'registerdate',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function jadwal() {
      return $this->hasMany('App\Jadwal');
    }

    public function prodi() {
      return $this->belongsTo('App\Prodi', 'prodi_id');
    }

    public function fakultas() {
      return $this->belongsTo('App\Fakultas', 'fakultas_id');
    }

    public function userCreate() {
        return $this->belongsTo('App\User', 'created_by');
    }
    public function userUpdate() {
        return $this->belongsTo('App\User', 'updated_by');
    }
    public function userDelete() {
        return $this->belongsTo('App\User', 'deleted_by');
    }

    /* --------------- User --------------- */
    public function userCreated() {
        return $this->hasMany('App\User', 'created_by');
    }
    public function userUpdated() {
        return $this->hasMany('App\User', 'updated_by');
    }
    public function userDeleted() {
        return $this->hasMany('App\User', 'deleted_by');
    }
    /* --------------- User --------------- */

    /* --------------- Sesi Prodi --------------- */
    public function sesiprodiCreate() {
        return $this->hasMany('App\SesiProdi', 'created_by');
    }
    public function sesiprodiUpdate() {
        return $this->hasMany('App\SesiProdi', 'updated_by');
    }
    public function sesiprodiDelete() {
        return $this->hasMany('App\SesiProdi', 'deleted_by');
    }
    /* --------------- Sesi Prodi --------------- */


    /* --------------- Sesi --------------- */
    public function sesiCreate() {
        return $this->hasMany('App\Sesi', 'created_by');
    }
    public function sesiUpdate() {
        return $this->hasMany('App\Sesi', 'updated_by');
    }
    public function sesiDelete() {
        return $this->hasMany('App\Sesi', 'deleted_by');
    }
    /* --------------- Sesi --------------- */


    /* --------------- Prodi --------------- */
    public function prodiCreate() {
        return $this->hasMany('App\Prodi', 'created_by');
    }
    public function prodiUpdate() {
        return $this->hasMany('App\Prodi', 'updated_by');
    }
    public function prodiDelete() {
        return $this->hasMany('App\Prodi', 'deleted_by');
    }
    /* --------------- Prodi --------------- */


    /* --------------- Fakultas --------------- */
    public function fakultasCreate() {
        return $this->hasMany('App\Fakultas', 'created_by');
    }
    public function fakultasUpdate() {
        return $this->hasMany('App\Fakultas', 'updated_by');
    }
    public function fakultasDelete() {
        return $this->hasMany('App\Fakultas', 'deleted_by');
    }
    /* --------------- Fakultas --------------- */


    /* --------------- Jadwal --------------- */
    public function jadwalCreate() {
        return $this->hasMany('App\Jadwal', 'created_by');
    }
    public function jadwalUpdate() {
        return $this->hasMany('App\Jadwal', 'updated_by');
    }
    public function jadwalDelete() {
        return $this->hasMany('App\Jadwal', 'deleted_by');
    }
    /* --------------- Jadwal --------------- */
}
