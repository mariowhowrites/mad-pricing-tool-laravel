<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    protected $guarded = [];

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
            if ($asset->status === 'customer_assets') {
                $asset->moveToCustomerAssetsDisk();
            }
        });
    }

    // here, we need to retrieve the image stored at `upload_path` and move it to the `customer_assets` disk
    public function moveToCustomerAssetsDisk()
    {
        $file = Storage::disk('temp')->get($this->upload_path);
        
        Log::info('Moving asset to customer_assets disk: ' . $this->upload_path);
        $success = Storage::disk('customer_assets')->put($this->upload_path, $file);
        
        if ($success) {
            Log::info('Deleting asset from temp disk: ' . $this->upload_path);
            Storage::disk('temp')->delete($this->upload_path);

            // we can also delete the directory where the temporary asset was stored
            // we can get the directory name from the upload_path
            $directory = explode('/', $this->upload_path)[0];
            Storage::disk('temp')->deleteDirectory($directory);
        }
    }

    public static function createTemporaryAsset($file, $batch)
    {
        $asset = static::create([
            'upload_path' => $file->store($batch->id, 'temp'),
            'status' => 'temporary'
        ]);

        $batch->assets()->attach($asset);

        return $asset;    
    }

    public function getTemporaryFileURL()
    {
        if ($this->status !== 'temporary') {
            return;
        }

        return Storage::url($this->upload_path);
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
