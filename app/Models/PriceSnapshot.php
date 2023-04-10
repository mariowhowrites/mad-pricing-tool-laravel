<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSnapshot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function priceMeasurements()
    {
        return $this->hasMany(PriceMeasurement::class);
    }

    public static function getByURL($url)
    {
        return static::select('id')
            ->where('url', $url)
            ->latest()
            ->limit(1)
            ->get()
            ->first();
    }

    public function getClosestMeasurementBySquareInches($squareInches)
    {
        return PriceMeasurement::getClosest($squareInches, $this->id);
    }

    /**
     * @param $squareInches
     * @param bool $wholesale
     * @return array
     * 
     * First, this function gets the closest measurement to the square inches
     */
    public function getVariantPricesBySquareInches($squareInches, $wholesale = false)
    {
        $closestMeasurement = $this->getClosestMeasurementBySquareInches($squareInches);

        if (!$closestMeasurement) {
            return [];
        }

        return PriceMeasurement::getVariantPricesBySquareInches(
            $squareInches,
            $this->id,
            $closestMeasurement->distance,
            $wholesale
        );
    }

    public function getVariantPriceBySquareInches($variant, $squareInches, $wholesale = false)
    {
        $closestMeasurement = $this->getClosestMeasurementBySquareInches($squareInches);

        if (!$closestMeasurement) {
            return [];
        }

        return PriceMeasurement::getVariantPriceBySquareInches(
            $variant,
            $squareInches,
            $this->id,
            $closestMeasurement->distance,
            $wholesale
        );
    }
}
