<?php

namespace App\Exports;

use App\staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StaffExport implements ShouldAutoSize, WithHeadings, FromCollection

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
            'ID Pegawai',
            'Nama',
            'Jabatan',
            'Nomer Hp',
            'Alamat',
            'Tanggal Dibuat',
            'Akun',
        ];
    }
}
