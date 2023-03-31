<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        $this->call([
            PriceSnapshotSeeder::class,
            PriceMeasurementSeeder::class
        ]);

        User::create([
            'name' => 'Mario Vega',
            'email' => 'mariovegadev@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
