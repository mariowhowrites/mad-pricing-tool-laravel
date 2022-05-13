<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSnapshot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function priceMeasurements()
    {
        return $this->hasMany(PriceMeasurement::class);
    }
}
