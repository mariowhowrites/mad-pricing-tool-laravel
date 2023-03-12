<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PriceMeasurement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function priceSnapshot()
    {
        return $this->belongsTo(PriceSnapshot::class);
    }

    public static function getClosest($squareInches, $snapshotID)
    {
        return DB::table('price_measurements')->select([
            'id', DB::raw("ABS(square_inches - {$squareInches}) AS distance")
        ])
            ->where('price_snapshot_id', '=', $snapshotID)
            ->orderBy('distance')
            ->distinct()
            ->limit(1)
            ->get()
            ->first();
    }

    public static function getVariantPricesBySquareInches($squareInches, $snapshotID, $closestDistance, $wholesale = false)
    {
        $results = DB::table('price_measurements')
            ->select(['id', 'price_per_square_inch', 'square_inches', 'variant', DB::raw("ABS(square_inches - {$squareInches}) AS distance")])
            ->where('price_snapshot_id', '=', $snapshotID)
            ->having('distance', '=', $closestDistance)
            ->orderBy('distance')
            ->get();

        // testing
        // $this->closestMeasurementID = $closestMeasurement->id;
        // $this->closestDistance = $closestDistance;
        // $this->results = $results;
                    
        return $results->flatMap(function ($result) use ($squareInches, $wholesale) {
            $price = $result->price_per_square_inch * $squareInches / 100;

            // take 30% off for wholesale
            if ($wholesale) {
                $price = $price * 0.7;
            }

            return [$result->variant => number_format($price, 2)];
        });
    }
}
