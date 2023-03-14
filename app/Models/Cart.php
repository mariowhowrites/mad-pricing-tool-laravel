<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['session_id'];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    // $dimensions has `height`, `width`, and `quantity` 
    public static function addBatchFromDimensions($dimensions, $cart = null)
    {
        if ($cart === null) {
            $cart = static::getFromSession();
        }

        Batch::create(
            array_merge(
                $dimensions,
                ['cart_id' => $cart->id]
            )
        );
    }

    public static function getFromSession()
    {
        return static::firstOrCreate(['session_id' => session()->getId()]);
    }

    public function priceInDollars(): Attribute
    {
        return Attribute::make(get: function() {
            return $this->batches->reduce(function (float $total, Batch $batch) {
                return $total + $batch->price_in_dollars;
            }, 0);
        });
    }
}
