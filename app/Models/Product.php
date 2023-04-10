<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function priceSnapshots()
    {
        return $this->hasMany(PriceSnapshot::class);
    }

    public function latestPriceSnapshot()
    {
        return $this->priceSnapshots()->latest()->get()->first();
    }

    public function getVariantPriceBySquareInches($variant, $squareInches, $wholesale)
    {
        return $this->latestPriceSnapshot()->getVariantPriceBySquareInches($variant, $squareInches, $wholesale);
    }

    public function getVariantPricesBySquareInches($squareInches, $wholesale)
    {
        return $this->latestPriceSnapshot()->getVariantPricesBySquareInches($squareInches, $wholesale);
    }
}