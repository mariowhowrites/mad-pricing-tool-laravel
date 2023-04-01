<?php

namespace App\Models;

use App\Models\Enums\AssetStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => AssetStatus::class
    ];

    public function batches()
    {
        return $this->belongsToMany(Batch::class);
    }

    // in our boot function, we want to move all temporary assets to the customer_assets disk
    // we create an `updated` event listener in our `boot` method, and if the status changes to `customer_assets`, we move the file

    public static function boot()
    {
        parent::boot();

        static::updated(function ($asset) {
            if ($asset->status === AssetStatus::Customer) {
                $asset->moveToCustomerAssetsDisk();
            }
        });
    }

    // here, we need to retrieve the image stored at `upload_path` and move it to the `customer_assets` disk
    public function moveToCustomerAssetsDisk()
    {
        $file = Storage::disk('temp')->get($this->upload_path);
        
        Log::info('Moving upload to customer_assets disk: ' . $this->upload_path);
        $success = Storage::disk('customer_assets')->put($this->upload_path, $file);
        
        if ($success) {
            Log::info('Deleting upload from temp disk: ' . $this->upload_path);
            $this->deleteTemporaryUpload();
        }

        return $success;
    }

    public static function createTemporaryAsset($file, $batch)
    {
        $upload_path = $file->store($batch->id, 'temp');

        if (!$upload_path) {
            return false;
        }

        $asset = static::create([
            'upload_path' => $upload_path,
            'status' => AssetStatus::Temporary
        ]);

        $batch->assets()->attach($asset);

        return $asset;    
    }

    public function getTemporaryFileURL()
    {
        if ($this->status !== AssetStatus::Temporary) {
            return;
        }

        return Storage::url($this->upload_path);
    }

    public function deleteTemporaryUpload()
    {
        $success = Storage::disk('temp')->delete($this->upload_path);
        $directory = explode('/', $this->upload_path)[0];
        Storage::disk('temp')->deleteDirectory($directory);

        return $success;
    }

    public function deleteAndClearUploads()
    {
        if ($this->status !== AssetStatus::Temporary) {
            return;
        }

        $success = $this->deleteTemporaryUpload();

        if ($success) {
            $this->delete();
        }

        return $success;
    }
}

// assets can belong to many batches
// assets can be temporary -- they are deleted after a batch is created
// assets can be permanent:
// - uploaded by customer
// - uploaded by admin
// assets should be moved automatically based on what happens with carts/orders
// - when a cart is converted to an order, move assets from temporary to 'customer_assets'
// - when an order is completed, move assets from 'customer_assets' to 'archive'
