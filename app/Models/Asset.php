<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    protected $guarded = [];

    public function batches()
    {
        return $this->belongsToMany(Batch::class);
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
// - when a cart is converted to an order, move assets from temporary to 'customer_upload'
// - when an order is completed, move assets from 'customer_upload' to 'archive'
