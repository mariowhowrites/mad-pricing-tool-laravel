<?php

namespace App\Http\Livewire;

use App\Models\PriceSnapshot;
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
        $this->selectedURL = $urls[0];
    }

    public function render()
    {
        return view('livewire.price-calculator');
    }
}
