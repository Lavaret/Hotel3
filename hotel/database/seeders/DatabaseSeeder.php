<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'Demo user',
            'email' => 'demo@mail.pl',
            'password' => Hash::make('demo')
        ]);

        //create 2 vip rooms
        for ($i = 1; $i <= 2; $i++) {
            Room::create([
                'beds' => 5,
                'has_bathroom' => true,
                'has_balcony' => true,
                'has_wifi' => true,
                'is_vip' => true,
                'price' => 1500
            ]);
        }

        //create 4 2/per rooms
        for ($i = 1; $i <= 4; $i++) {
            Room::create([
                'beds' => 2,
                'has_bathroom' => true,
                'has_balcony' => true,
                'has_wifi' => true,
                'is_vip' => false,
                'price' => 250
            ]);
        }

        //create 5 3/per rooms
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'beds' => 3,
                'has_bathroom' => true,
                'has_balcony' => $i%2 === 0,
                'has_wifi' => $i%2 === 0,
                'is_vip' => false,
                'price' => 200
            ]);
        }

        //create 5 4/per rooms
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'beds' => 4,
                'has_bathroom' => true,
                'has_balcony' => $i%2 === 0,
                'has_wifi' => $i%2 === 0,
                'is_vip' => false,
                'price' => 150
            ]);
        }
    }
}
