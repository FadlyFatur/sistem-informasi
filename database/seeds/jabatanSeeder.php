<?php

use Illuminate\Database\Seeder;
use App\jabatan;

class jabatanSeeder extends Seeder
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
                'nama' => 'Kepala Desa'
            ],
            [
                'nama' => 'Ketua RW 02'
            ],
            [
                'nama' => 'Sekretaris'
            ],
            [
                'nama' => 'Sekretaris 2'
            ],
            [
                'nama' => 'Bendahara'
            ],
            [
                'nama' => 'Ketua PKK RW 02'
            ],
            [
                'nama' => 'Ketua RT 01'
            ],
            [
                'nama' => 'Ketua RT 02'
            ],
            [
                'nama' => 'Ketua RT 03'
            ],
            [
                'nama' => 'Ketua RT 04'
            ],
            [
                'nama' => 'Ketua RT 05'
            ],
            [
                'nama' => 'Ketua RT 06'
            ],
            [
                'nama' => 'Ketua RT 07'
            ],
            [
                'nama' => 'Ketua RT 08'
            ],
            [
                'nama' => 'Ketua RT 09'
            ],
            [
                'nama' => 'Ketua RT 10'
            ],
            [
                'nama' => 'Ketua RT 11'
            ],
            [
                'nama' => 'Ketua RT 12'
            ],
            [
                'nama' => 'Staff'
            ],
            [
                'nama' => 'Karyawan'
            ],
            [
                'nama' => 'Linmas'
            ],
            [
                'nama' => 'Keamanan'
            ],
        ];

        \DB::table('jabatans')->insert($data);
    }
}
