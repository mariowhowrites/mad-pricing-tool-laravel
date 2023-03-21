<?php

namespace App\Models;

use App\Models\Traits\HasBatches;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasBatches;

    protected $guarded = [];
}