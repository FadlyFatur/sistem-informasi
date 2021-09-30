<?php

use Illuminate\Database\Seeder;
use App\kerjas;

class KerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Belum/Tidak Bekerja'
            ],
            [
                'nama' => 'Mengurus Rumah Tangga'
            ],
            [
                'nama' => 'Pelajar/Mahasiswa'
            ],
            [
                'nama' => 'Pensiunan'
            ],
            [
                'nama' => 'Pegawai Negeri Sipil'
            ],
            [
                'nama' => 'TNI'
            ],
            [
                'nama' => 'Polisi'
            ],
            [
                'nama' => 'Perdagangan'
            ],
            [
                'nama' => 'Petani/Pekebun'
            ],
            [
                'nama' => 'Peternak'
            ],
            [
                'nama' => 'Nelayan/Perikanan'
            ],
            [
                'nama' => 'Industri'
            ],
            [
                'nama' => 'Kontruksi'
            ],
            [
                'nama' => 'Transportasi'
            ],
            [
                'nama' => 'Karyawan Swasta'
            ],
            [
                'nama' => 'Karyawan BUMN'
            ],
            [
                'nama' => 'Karyawan BUMD'
            ],
            [
                'nama' => 'Karyawan Honorer'
            ],
            [
                'nama' => 'Buruh Harian Lepas'
            ],
            [
                'nama' => 'Pembantu Rumah Tangga'
            ],
            [
                'nama' => 'Seniman'
            ],
            [
                'nama' => 'Wartawan'
            ],
            [
                'nama' => 'Dosen'
            ],
            [
                'nama' => 'Guru'
            ],
            [
                'nama' => 'Pengacara'
            ],
            [
                'nama' => 'Arsitek'
            ],
            [
                'nama' => 'Konsultan'
            ],
            [
                'nama' => 'Dokter'
            ],
            [
                'nama' => 'Bidan'
            ],
            [
                'nama' => 'Perawat'
            ],
            [
                'nama' => 'Apoteker'
            ],
            [
                'nama' => 'Pelaut'
            ],
            [
                'nama' => 'Sopir'
            ],
        ];

        \DB::table('kerjas')->insert($data);
    }
}
