<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 10)->create();
        $data = [
            [
                'username'      => 'superadmin',
                'password'      => bcrypt('super-admin'),
                'verified_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'role'          => '3',
                'remember_token' => Str::random(10)
            ],
            [
                'username'      => 'admin',
                'password'      => bcrypt('admin'),
                'verified_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'role'          => '2',
                'remember_token' => Str::random(10)
            ],
            [
                'username'      => 'staff',
                'password'      => bcrypt('staff'),
                'verified_at'   => Carbon::now()->format('Y-m-d H:i:s'),
                'role'          => '1',
                'remember_token' => Str::random(10)
            ],
        ];

        User::insert($data);
    }
}
