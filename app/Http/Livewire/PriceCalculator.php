<?php

namespace App\Http\Livewire;

use App\Models\PriceMeasurement;
use App\Models\PriceSnapshot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    }

    public function render()
    {
        return view('livewire.price-calculator');
    }

    public function getSquareInchesProperty()
    {
        return floatval($this->width) * floatval($this->height) * intval($this->quantity);
    }

    public function getVariantPricesProperty()
    {
        $priceSnapshot = PriceSnapshot::getbyURL($this->selectedURL);

        $closestMeasurement = PriceMeasurement::getClosest($priceSnapshot, $this->squareInches);

        if (!$closestMeasurement) {
            return [];
        }

        return PriceMeasurement::getPricesForDistance($priceSnapshot, $this->squareInches, $closestMeasurement->distance, $this->wholesale);
    }

    public function formatKey($key)
    {
        if ($key === 'Gloss Laminated (6mil thick)') {
            return 'Gloss Laminated';
        }

        if ($key === 'Clear Laminated (6mil thick)') {
            return 'Clear Laminated';
        }

        return $key;
    }
}
