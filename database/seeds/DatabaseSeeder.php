<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(userTableSeeder::class);
        $this->call(jabatanSeeder::class);
        $this->call(KerjaSeeder::class);
        factory(App\beranda::class)->create();
        factory(App\warga::class, 25)->create();
        factory(App\acara::class, 20)->create();
        factory(App\staff::class, 10)->create();
    }
}
