<?php

namespace App\Models;

use App\Models\Traits\HasBatches;
use Illuminate\Database\Eloquent\Model;

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
}