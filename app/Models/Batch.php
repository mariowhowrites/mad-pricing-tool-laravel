<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Batch extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function priceSnapshot()
    {
        return $this->belongsTo(PriceSnapshot::class);
    }

    public function squareInches(): Attribute
    {
        return Attribute::make(get: fn ($value) => $this->width * $this->height * $this->quantity);
    }

    public function readablePrice(): Attribute
    {
        return Attribute::make(get: function($value) {
            $variantPrices = $this->priceSnapshot->getVariantPricesBySquareInches(
                $this->squareInches,
                $this->wholesale
            );

            Log::info($this->variant);
            Log::info($variantPrices);
    
            if (key_exists($this->variant, $variantPrices->toArray())) {
                return "$" . $variantPrices[$this->variant];
            }
    
            return "Variant not found, cannot determine price";
        });
    }
}
