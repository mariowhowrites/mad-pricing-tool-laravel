<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('order.show', compact('order'));
    }
}