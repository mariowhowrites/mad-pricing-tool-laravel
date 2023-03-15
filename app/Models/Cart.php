<?php

namespace App\Models;

use App\Models\Traits\HasBatches;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasBatches;

    protected $fillable = ['session_id', 'converted'];

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
        return static::firstOrCreate([
            'session_id' => session()->getId(),
            'converted' => false
        ]);
    }
}
