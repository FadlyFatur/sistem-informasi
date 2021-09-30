<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class beranda extends Model
{
  protected $fillable = [
    'kontak', 'email', 'alamat', 'kordinat', 'misi', 'visi', 'status'
  ];

  public $timestamps = false;
}
