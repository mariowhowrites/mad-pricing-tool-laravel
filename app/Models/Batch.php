<?php

namespace App\Models;

use App\Models\Traits\HasAssets;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Batch extends Model
{
    use HasFactory, HasAssets;

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
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

    // used to convert Eloquent model into Stripe-compatible line item
    public function convertToLineItem()
    {
        return [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $this->variant,
                ],
                // we are going to round this amount for now... but likely we should round it in the display price as well
                'unit_amount' => round($this->unit_price)
            ],
            'quantity' => $this->quantity
        ];
    }

    public static function deleteAndClearAssets($batchID)
    {
        $batch = static::find($batchID);

        $batch->deleteWithAssets();
    }

    public function deleteWithAssets()
    {
        if ($this->order_id) {
            Log::error("Cannot delete batch {$this->id} because it is associated with order {$this->order_id}");
            return;
        }

        $assets = $this->assets;

        $this->assets()->detach();

        $assets->each(fn ($asset) => $asset->delete());

        $this->delete();
    }
}
