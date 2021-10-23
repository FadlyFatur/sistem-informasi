<?php

namespace App\Exports;

use App\Apirasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AspirasiExport implements WithHeadings, FromCollection

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
            'Pengirim',
            'Aspirasi',
            'Status',
            'Tanggal Dikirim',
        ];
    }
}
