<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

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

    public function show(Product $product)
    {
        return view('product.show', ['product' => $product]);
    }
}
