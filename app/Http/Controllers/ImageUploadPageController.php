<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadPageController extends Controller
{
    public function index(Request $request)
    {
        // check query params: we need `height, width, quantity, variant`
        // if any of these are missing, redirect to the retail page
        if (!$request->has(['height', 'width', 'quantity', 'variant', 'product_id'])) {
            return redirect()->route('product.show', ['product' => 'stickers']);
        }

        return view('upload', ['batch' => $request->all()]);
    }
}
