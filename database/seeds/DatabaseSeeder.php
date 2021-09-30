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
        // $this->call(userTableSeeder::class);
        // factory(App\User::class, 10)->create();
        // factory(App\staff::class, 10)->create();
        factory(App\warga::class, 15)->create();
        factory(App\acara::class, 25)->create();
        factory(App\beranda::class)->create();

        $this->call(jabatanSeeder::class);
        $this->call(KerjaSeeder::class);
    }
}
