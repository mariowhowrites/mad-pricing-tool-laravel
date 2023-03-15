<?php

namespace App\Jobs;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ConvertCartToOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Cart $cart;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // how do we want to handle moving batches from carts to orders?

        // can we delete the cart, then attach the batch to an order?

        // something tells me we don't want to delete the cart to start off with, maybe a soft delete?

        // let's just do the easiest way for now
        Log::info('beginning conversion');

        $order = Order::create();

        $order->batches()->saveMany($this->cart->batches);

        $this->cart->update([
            'converted' => true
        ]);

        Log::info('ending conversion');
    }
}
