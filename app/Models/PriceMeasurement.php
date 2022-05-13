<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceMeasurement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function priceSnapshot()
    {
        return $this->belongsTo(PriceSnapshot::class);
    }
}
