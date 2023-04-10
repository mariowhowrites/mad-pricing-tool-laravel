<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantPageController extends Controller
{
    public function show(Product $product, Variant $variant)
    {
        return view('variant.show', [
            'product' => $product,
            'variant' => $variant,
        ]);
    }
}
