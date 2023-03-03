<?php

namespace App\Http\Livewire;

use App\Models\Cart as CartModel;
use Livewire\Component;

class Cart extends Component
{
    public $batches = [];

    public function mount()
    {
        $cart = CartModel::firstWhere('session_id', session()->getId());

        $this->batches = $cart->batches;
    }

    public function render()
    {
        return view('livewire.cart');
    }
}
