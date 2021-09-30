<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\warga;

class warga extends Model
{
    protected $fillable = [
      'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat','kelurahan','kecamatan','kota','rw',
      'rt','agama','kerja','perkawinan',
    ];
}
