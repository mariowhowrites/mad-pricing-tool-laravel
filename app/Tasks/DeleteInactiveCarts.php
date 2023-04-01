<?php

namespace App\Tasks;

use App\Models\Cart;

class DeleteInactiveCarts
{
    public function __invoke()
    {
        $inactiveCarts = Cart::where('created_at', '<', now()->subDays(30))
            ->where('order_id', null)
            ->get();

        $inactiveCarts->each(function ($cart) { 
            $cart->deleteWithAllBatches();
        });
    }
}
