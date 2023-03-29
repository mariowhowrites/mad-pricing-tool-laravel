<?php

namespace App\Models\Traits;

use App\Models\Asset;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

trait HasAssets
{
    public function assets()
    {
        return $this->belongsToMany(Asset::class);
    }

    public function addAsset(Asset $asset)
    {
        $this->assets()->attach($asset);
    }

    public function removeAsset(Asset $asset)
    {
        $this->assets()->detach($asset);
    }

    public function temporaryAssets()
    {
        return $this->assets()->where('status', 'temporary');
    }

    public function getTemporaryAsset()
    {
        $tempAsset = $this->temporaryAssets()->first(); 

        if (!$tempAsset) {
            return;
        }

        return $tempAsset;
    }

    public function getTemporaryAssetURL()
    {
        return route('assets.temp', ['token' => Crypt::encrypt($this->id)]);
    }

    // we need a function that will move assets from temporary to customer_assets once a cart is converted to an order
    // we listen to the `updating` hook, and if there's an order_id change, we move the assets
    public static function bootHasAssets()
    {
        static::updating(function ($model) {
            if ($model->isDirty('order_id')) {
                $model->temporaryAssets()->get()->each(function ($asset) {
                    $asset->update(['status' => 'customer_assets']);
                });
            }
        });
    }

    public function customerAssets()
    {
        return $this->assets()->where('status', 'customer_assets');
    }

    public function latestCustomerAssetPath()
    {
        $asset = $this->customerAssets()->latest()->first();

        Log::info($this->id);

        if (!$asset) {
            return;
        }

        return $asset->upload_path;
    }
}