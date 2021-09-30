<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class beranda extends Model
{
  protected $fillable = [
    'kontak', 'email', 'alamat',
  ];

  public $timestamps = false;
}
