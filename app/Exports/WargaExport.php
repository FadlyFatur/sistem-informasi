<?php

namespace App\Exports;

use App\warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WargaExport implements ShouldAutoSize, WithHeadings, FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
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
