<?php

namespace App\Exports;

use App\warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WargaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return warga::all( 'nik', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat','kelurahan','kecamatan','kota','rw',
        'rt','agama_id','kerja','perkawinan');
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Kelurahan',
            'Kecamatan',
            'Kota',
            'RW',
            'RT',
            'Agama',
            'Pekerjaan',
            'Perkawinan',
        ];
    }
}
