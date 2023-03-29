<?php

namespace App\Jobs;

use App\Mail\OrderCreated;
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
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;

class ConvertCartToOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Cart $cart;
    protected Address $address;
    protected string $customer_email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Session $session)
    {
        $this->cart = Cart::find($session->client_reference_id);
        $this->address = Address::createFromCheckoutSession($session);
        $this->customer_email = $session->customer_details->email;
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
            'address_id' => $this->address->id,
            'customer_email' => $this->customer_email,
        ]);

        if ($user) {
            $user->addresses()->save($this->address);
        }

        $order->batches()->saveMany($this->cart->batches);

        $this->cart->update([
            'converted' => true
        ]);

        Mail::to('mariovegadev@gmail.com')->send(new OrderCreated($order));
    }
}
