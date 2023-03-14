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
        return Attribute::make(get: fn () => $this->width * $this->height * $this->quantity);
    }

    public function priceInDollars(): Attribute
    {
        return Attribute::make(get: function() {
            $variantPrices = $this->priceSnapshot->getVariantPricesBySquareInches(
                $this->squareInches,
                $this->wholesale
            );

                
            if (key_exists($this->variant, $variantPrices->toArray())) {
                return $variantPrices[$this->variant];
            }
    
            return "Variant not found, cannot determine price";
        });
    }

    public function priceInCents(): Attribute
    {
        return Attribute::make(get: function() {
            return $this->price_in_dollars * 100;
        });
    }

    public function unitPrice(): Attribute
    {
        return Attribute::make(get: function() {
            return $this->price_in_cents / $this->quantity;
        });
    }

    public function convertToLineItem()
    {
        return [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $this->variant,
                ],
                'unit_amount' => $this->unit_price
            ],
            'quantity' => $this->quantity
        ];
    }
}
