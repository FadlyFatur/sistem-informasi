<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class warga extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'nik', 'nama', 'jk', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'kel', 'kec', 'kota', 'rw', 'rt', 'agama', 'kerja_id', 'kawin'
  ];

  public function kerja()
  {
    return $this->belongsTo('App\kerjas');
  }

  public function setNikAttribute($value)
  {
    $this->attributes['nik'] = Crypt::encryptString($value);
  }

  public function getNikAttribute($value)
  {
    try {
      if (Auth::user()->verified_at != NULL) {
        return Crypt::decryptString($value);
      }
    } catch (\Throwable $th) {
      return '-';
    }
  }
}
