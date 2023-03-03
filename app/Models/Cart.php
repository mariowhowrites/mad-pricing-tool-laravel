<?php

namespace App\Models;

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

    // $measurements has `height`, `width`, and `quantity`
    // side effect -- creates a cart, probably should inherit this 
    public static function addBatchFromMeasurements($measurements)
    {
        Batch::create([
            'width' => floatval($measurements['width']),
            'height' => floatval($measurements['height']),
            'quantity' => intval($measurements['quantity']),
            'cart_id' => Cart::firstOrCreate(['session_id' => session()->getId()])->id
        ]);
    }
}
