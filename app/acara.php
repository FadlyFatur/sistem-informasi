<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class acara extends Model
{
    protected $fillable = [
        'slug', 'judul', 'deskripsi', 'foto', 'url', 'status',
      ];
}
