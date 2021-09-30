<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
  protected $table = 'staffs';
  
  protected $fillable = [
      'no_pegawai','nama', 'no_hp', 'alamat','jabatan_id','user_id', 'foto', 'url'
    ];
  
  public function jabatan()
  {
    return $this->belongsTo('App\jabatan');
  }

  public function user()
  {
    return $this->belongsTo('App\user');
  }
}
