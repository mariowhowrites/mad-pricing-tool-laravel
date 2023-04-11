<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\PriceMeasurement;
use App\Models\PriceSnapshot;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PriceCalculator extends Component
{
    public $wholesale = false;

    public $height = 1.0;
    public $width = 1.0;
    public $quantity = 50;
    public $price = 0;
    public $product;
    public $variant;

    protected $rules = [
        'width' => 'numeric|min:1|max:36',
        'height' => 'numeric|min:1|max:36',
        'quantity' => 'integer|min:50|max:10000',
    ];

    public function render()
    {
        return view('livewire.price-calculator');
    }

    public function updatedWidth()
    {
        $this->validateOnly('width');
    }

    public function updatedHeight()
    {
        $this->validateOnly('height');
    }

    public function updatedQuantity()
    {
        $this->validateOnly('quantity');
    }

    public function getSquareInchesProperty()
    {
        return floatval($this->width) * floatval($this->height) * intval($this->quantity);
    }

    public function getVariantPriceProperty()
    {
        return $this->product->getVariantPriceBySquareInches(
            $this->variant->name,
            $this->width,
            $this->height,
            $this->quantity,
            $this->wholesale
        );
    }

    public function goToImageUpload()
    {
        $this->validate();

        if (!$this->getErrorBag()->isEmpty()) {
            return;
        }

        $batch = [
            'width' => floatval($this->width),
            'height' => floatval($this->height),
            'quantity' => intval($this->quantity),
            'variant' => $this->variant->name,
            'product_id' => $this->product->id,
        ];

        if ($this->wholesale) {
            $batch['wholesale'] = true;
        }

        return redirect()->route('upload', $batch);
    }
}
