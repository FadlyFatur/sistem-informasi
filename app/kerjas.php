<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kerjas extends Model
{
    protected $fillable = [
        'nama'
    ];

    public $timestamps = false;

    public function warga()
    {
        return $this->belongsTo('App\warga');
    }
}
