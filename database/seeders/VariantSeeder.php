<?php

namespace Database\Seeders;

use App\Importer\CSV;
use App\Models\Variant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for now, since we only have one product, we can just use product_id == 1

        foreach(CSV::rowsFromPath(storage_path('db/price_measurements.csv')) as $rows) {
            $this->insertVariants($rows);
        }
    }

    public function insertVariants($rows)
    {
        $variants = [];

        foreach($rows as $row) {
            if (!in_array($row['variant'], $variants)) {
                $variants[] = $row['variant'];
            }
        }

        foreach($variants as $variant) {
            Variant::firstOrCreate(['name' => $variant, 'product_id' => 1]);
        }
    }
}
