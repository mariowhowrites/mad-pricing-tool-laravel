<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProductPageController extends Controller
{
    public function retail()
    {
        return view('product-page', ['wholesale' => false]);
    }

    public function wholesale()
    {
        return view('product-page', ['wholesale' => true]);
    }
}
