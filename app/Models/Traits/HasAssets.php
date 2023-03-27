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

    public function getTemporaryAsset()
    {
        $tempAsset = $this->assets()->where('status', 'temporary')->first(); 

        if (!$tempAsset) {
            return;
        }

        return $tempAsset;
    }

    public function getTemporaryAssetURL()
    {
        return route('assets.temp', ['token' => Crypt::encrypt($this->id)]);
    }
}