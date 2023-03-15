<?php

namespace App\Models\Traits;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasBatches
{
    public function batches()
    {
        return $this->hasMany(Batch::class);
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
