<?php

namespace App\Http\Livewire;

use App\Models\Batch;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Stripe;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class CartComponent extends Component
{
    public $batches = [];
    public CartModel $cart;
    public $stripeError = false;

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
        Batch::deleteAndClearAssets($batch['id']);

        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cart = CartModel::getFromSession();
    }

    public function checkout(StripeClient $stripe)
    {
        $checkoutParams = [
            'shipping_address_collection' => [
                'allowed_countries' => ['US'],
            ],
            'line_items' => $this->convertCartToLineItems(),
            'success_url' => route('checkout.success'),
            'cancel_url' => route('cart'),
            'mode' => 'payment',
            'client_reference_id' => $this->cart->id
        ];

        try {
            $checkoutSession = $stripe->checkout->sessions->create($checkoutParams);

            redirect($checkoutSession->url);
        } catch (ApiErrorException $e) {
            Log::error($e);

            $this->stripeError = true;
        }
    }

    protected function convertCartToLineItems()
    {
        return $this->cart->batches->map(function ($batch) {
            return $batch->convertToLineItem();
        })->toArray();
    }
}
