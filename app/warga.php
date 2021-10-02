<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class warga extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'nik', 'nama', 'jk', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'kel', 'kec', 'kota', 'rw',
    'rt', 'agama', 'kerja_id', 'kawin'
  ];

  public function kerja()
  {
    return $this->belongsTo('App\kerjas');
  }
}
