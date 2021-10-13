<?php

namespace App\Exports;

use App\warga;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WargaExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $warga =  warga::all();
        $data = [];

        foreach ($warga as $d) {
            $data[] = [
                'nik' => $d->nik,
                'nama' => $d->nama,
                'jk' => $d->jk,
                'tempat_lahir' => $d->tempat_lahir,
                'tanggal_lahir' => $d->tanggal_lahir,
                'alamat' => $d->alamat,
                'kel' => $d->kel,
                'kec' => $d->kec,
                'kota' => $d->kota,
                'rw' => $d->rw,
                'rt' => $d->rt,
                'agama' => $d->agama,
                'kerja' => $d->kerja->nama,
                'kawin' => $d->kawin,
            ];
        }

        return $data;
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
