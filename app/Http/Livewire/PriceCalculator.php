<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\PriceMeasurement;
use App\Models\PriceSnapshot;
use Livewire\Component;

class PriceCalculator extends Component
{
    public $wholesale = false;


    public $selectedURL = '';
    public $allURLs = [];

    // testing
    // public $closestMeasurementID;
    // public $closestDistance;
    // public $results;

    public $height = 1.0;
    public $width = 1.0;
    public $quantity = 50;
    public $variant = "";
    public $price = 0;

    protected $rules = [
        'width' => 'numeric|min:1|max:36',
        'height' => 'numeric|min:1|max:36',
        'quantity' => 'integer|min:50|max:10000',
    ];

    public function mount()
    {
        $urls = PriceSnapshot::select(['url'])->orderBy('created_at', 'asc')->get()->pluck('url');

        $this->allURLs = $urls;
        $this->selectedURL = $this->allURLs[0];
        $this->variant = $this->variantPrices->keys()[0];
    }

    public function render()
    {
        return view('livewire.price-calculator');
    }

    public function getSquareInchesProperty()
    {
        return floatval($this->width) * floatval($this->height) * intval($this->quantity);
    }

    public function getPriceSnapshotProperty()
    {
        return PriceSnapshot::getByURL($this->selectedURL);
    }

    public function getVariantPricesProperty()
    {
        return $this->priceSnapshot->getVariantPricesBySquareInches(
            $this->squareInches,
            $this->wholesale
        );
    }

    public function goToImageUpload()
    {
        $batch = [
            'width' => floatval($this->width),
            'height' => floatval($this->height),
            'quantity' => intval($this->quantity),
            'variant' => $this->variant,
        ];

        if ($this->wholesale) {
            $batch['wholesale'] = true;
        }

        return redirect()->route('upload', $batch);
    }
}
