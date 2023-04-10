<?php

namespace Database\Seeders;

use App\Models\PriceSnapshot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSnapshotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceSnapshot::create([
            'id' => 2,
            'product_id' => 1,
            'url' => 'https://zugmonster.com/collections/custom-stickers/products/custom-die-cut-stickers',
            'created_at' => '2022-05-18 06:39:27',
            'updated_at' => '2022-05-18 06:39:27',
        ]);
    }
}
