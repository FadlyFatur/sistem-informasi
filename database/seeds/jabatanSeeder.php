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
                'nama' => 'Ketua RW 01'
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
                'nama' => 'Ketua RT 01'
            ],
            [
                'nama' => 'Ketua RT 02'
            ],
            [
                'nama' => 'Ketua RT 03'
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
