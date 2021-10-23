<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class staff extends Model
{
  protected $table = 'staffs';

  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'id_pegawai', 'nama', 'no_hp', 'alamat', 'jabatan_id', 'user_id', 'foto', 'url', 'status'
  ];

  public function jabatan()
  {
    return $this->belongsTo('App\jabatan');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
