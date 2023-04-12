<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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

    // todo: clean up this method signature a bit
    public static function getVariantPriceBySquareInches($variant, $width, $height, $quantity, $snapshotID, $closestDistance, $wholesale = false)
    {
        return Cache::rememberForever("variant-price-{$variant}-{$width}-{$height}-{$quantity}-{$snapshotID}-{$closestDistance}-{$wholesale}", function () use ($variant, $width, $height, $quantity, $snapshotID, $closestDistance, $wholesale) {
            $squareInches = $width * $height * $quantity;
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
                        
            return number_format(static::calculatePrice($width, $height, $quantity, $result->price_per_square_inch), 2);
        });
    }

    // we should apply wholesale here if applicable
    protected static function calculatePrice($width, $height, $quantity, $pricePerSquareInch)
    {
        $unitPrice = round($width * $height * $pricePerSquareInch);

        return $unitPrice * $quantity / 100;
    }
}
