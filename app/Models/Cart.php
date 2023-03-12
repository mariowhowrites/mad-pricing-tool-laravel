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

    // $dimensions has `height`, `width`, and `quantity`
    // side effect -- creates a cart, probably should inherit this 
    public static function addBatchFromDimensions($dimensions)
    {
        Batch::create(
            array_merge(
                $dimensions,
                ['cart_id' => static::getFromSession()->id]
            )
        );
    }
    
    public static function getFromSession()
    {
        return static::firstOrCreate(['session_id' => session()->getId()]);
    }
}
