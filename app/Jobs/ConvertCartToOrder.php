<?php

namespace App\Jobs;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;

class ConvertCartToOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Cart $cart;
    protected Address $address;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Session $session)
    {
        $this->cart = Cart::find($session->client_reference_id);
        $this->address = Address::createFromCheckoutSession($session);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = null;

        if ($this->cart->user) {
            $user = User::find($this->cart->user->id);
        }

        $order = Order::create([
            'user_id' => $user ? $user->id : null,
            'address_id' => $this->address->id
        ]);

        if ($user) {
            $user->addresses()->save($this->address);
        }

        $order->batches()->saveMany($this->cart->batches);

        $this->cart->update([
            'converted' => true
        ]);
    }
}
