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

    /**
     * This function determines which measurement in a given snapshot is closest to the provided square inches.
     */
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
        // get all price measurements
        $results = DB::table('price_measurements')
            ->select(['id', 'price_per_square_inch', 'square_inches', 'variant', DB::raw("ABS(square_inches - {$squareInches}) AS distance")])
            // where the snapshot id matches
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

    public static function getVariantPriceBySquareInches($variant, $squareInches, $snapshotID, $closestDistance, $wholesale = false)
    {
        // get all price measurements
        $result = DB::table('price_measurements')
            ->select(['id', 'price_per_square_inch', 'square_inches', 'variant', DB::raw("ABS(square_inches - {$squareInches}) AS distance")])
            // where the snapshot id matches
            ->where('variant', '=', $variant)
            ->where('price_snapshot_id', '=', $snapshotID)
            ->having('distance', '=', $closestDistance)
            ->orderBy('distance')
            ->get()
            ->first();
                    
        return number_format($result->price_per_square_inch * $squareInches / 100, 2);
    }
}
