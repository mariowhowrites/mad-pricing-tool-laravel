<?php

namespace Database\Seeders;

use App\Importer\CSV;
use App\Models\PriceMeasurement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        
        foreach (CSV::rowsFromPath(storage_path('db/price_measurements.csv'), 5000) as $rows) {
            static::insertPriceMeasurements($rows, $now);
        }
    }

    protected static function insertPriceMeasurements($rows, $now) {
        $items = collect($rows)->map(function ($row) use ($now) {
            return array_merge($row, ['updated_at' => $now]);
        });

        DB::table('price_measurements')->insert($items->toArray());
    }
}
