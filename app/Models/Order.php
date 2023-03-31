<?php

namespace App\Models;

use App\Models\Traits\HasBatches;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasBatches;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function customerUploadPaths()
    {
        return $this->batches->map(function ($batch) {
            return $batch->latestCustomerUploadPath();
        });
    }
}