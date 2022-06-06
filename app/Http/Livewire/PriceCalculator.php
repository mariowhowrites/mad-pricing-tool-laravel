<?php

namespace App\Http\Livewire;

use App\Models\PriceSnapshot;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PriceCalculator extends Component
{
    public $selectedURL = '';
    public $allURLs = [];

    public $height = 1.0;
    public $width = 1.0;
    public $quantity = 1.0;

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
        return intval($this->width) * intval($this->height) * intval($this->quantity);
    }

    public function getVariantPricesProperty()
    {
        $priceSnapshot = PriceSnapshot::select('id')
            ->where('url', $this->selectedURL)
            ->latest()
            ->limit(1)
            ->get()
            ->first();


        $closestMeasurement = DB::table('price_measurements')->select([ 
            DB::raw("ABS(square_inches - {$this->squareInches}) AS distance")
        ])
            ->where('price_snapshot_id', '=', $priceSnapshot->id)
            ->orderBy('distance')
            ->distinct()
            ->limit(1)
            ->get()
            ->first();
        

        if (!$closestMeasurement) {
            return [];
        }

        $closestDistance = $closestMeasurement->distance;
            
        $results = DB::table('price_measurements')
            ->select(['id', 'price_per_square_inch', 'variant', DB::raw("ABS(square_inches - {$this->squareInches}) AS distance")])
            ->where('price_snapshot_id', '=', $priceSnapshot->id)
            ->having('distance', '=', $closestDistance)
            ->orderBy('distance')
            ->get();
            
        return $results->flatMap(function ($result) {
            return [$result->variant => round(($result->price_per_square_inch * $this->squareInches / 100), 2)];
        });
    }
}
