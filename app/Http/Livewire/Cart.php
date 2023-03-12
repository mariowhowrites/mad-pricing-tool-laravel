<?php

namespace App\Http\Livewire;

use App\Models\Batch;
use App\Models\Cart as CartModel;
use Livewire\Component;

class Cart extends Component
{
    public $batches = [];

    public function mount()
    {
        $this->refreshCart();
    }

    public function render()
    {
        return view('livewire.cart');
    }

    public function batchContainerClasses($batch, $index)
    {
        $classes = "batch flex justify-between border-w bg-gray-300 py-4 px-2";

        // not last
        if ($index < count($this->batches) - 1) {
            $classes = $classes . " border-b";
        }

        return $classes;
    }

    public function deleteBatch($batch)
    {
        Batch::destroy($batch['id']);

        $this->refreshCart();
    }

    public function refreshCart()
    {
        $cart = CartModel::firstOrCreate(['session_id' => session()->getId()]);

        $this->batches = $cart->batches;
    }
}
