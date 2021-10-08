<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $fillable = [
        'nama'
    ];
    public $timestamps = false;


    public function user()
    {
        return $this->HasMany('App\staff');
    }
}
