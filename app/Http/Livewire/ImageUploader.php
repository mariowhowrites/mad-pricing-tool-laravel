<?php

namespace App\Http\Livewire;

use App\Models\Asset;
use App\Models\Cart;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImageUploader extends Component
{
    use WithFileUploads;

    public $image;
    public $batch;

    public function render()
    {
        return view('livewire.image-uploader');
    }

    public function addToCart()
    {
        $this->validate([
            'image' => 'required|image',
        ]);

        $batch = Cart::addBatchFromDimensions($this->batch);

        Asset::createTemporaryAsset($this->image, $batch);

        return redirect()->to(route('cart'));
    }
}
