<?php

namespace App\Models;

use App\Models\Traits\HasBatches;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Cart extends Model
{
    use HasFactory, HasBatches;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // $dimensions has `height`, `width`, and `quantity` 
    public static function addBatchFromDimensions($dimensions, $cart = null)
    {
        if ($cart === null) {
            $cart = static::getFromSession();
        }

        Log::info($cart);
        Log::info($dimensions);

        Batch::create(
            array_merge(
                $dimensions,
                ['cart_id' => $cart->id]
            )
        );
    }

    public static function getFromSession()
    {
        $user = Auth::user();

        return static::firstOrCreate([
            'session_id' => session()->getId(),
            'user_id' => $user ? $user->id : null,
            'converted' => false
        ]);
    }
}
