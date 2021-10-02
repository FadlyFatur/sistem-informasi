<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class acara extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  protected $fillable = [
    'slug', 'judul', 'deskripsi', 'foto', 'status', 'penulis_id',
  ];

  public function penulis()
  {
    return $this->belongsTo('App\User');
  }
}
