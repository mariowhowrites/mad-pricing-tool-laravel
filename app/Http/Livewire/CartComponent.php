<?php

namespace App\Http\Livewire;

use App\Models\Batch;
use App\Models\Cart as CartModel;
use Livewire\Component;
use Stripe;
use Stripe\StripeClient;

class CartComponent extends Component
{
    public $batches = [];
    public CartModel $cart;


    public function mount()
    {
        $this->refreshCart();
    }

    public function render()
    {
        return view('livewire.cart-component');
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

        $this->cart = $cart;
    }

    public function checkout(StripeClient $stripe)
    {
        $checkoutParams = [
            'line_items' => $this->convertCartToLineItems(),
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
            'mode' => 'payment'
        ];

        // we are interacting with stripe here, we need to have a fallback in case this fails
        $checkoutSession = $stripe->checkout->sessions->create($checkoutParams);

        redirect($checkoutSession->url);
    }

    protected function convertCartToLineItems()
    {
        return $this->cart->batches->map(function ($batch) {
            return $batch->convertToLineItem();
        })->toArray();
    }
}
