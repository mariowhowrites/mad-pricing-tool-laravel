<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageUploadPageController extends Controller
{
    public function index(Request $request)
    {
        // check query params: we need `height, width, quantity, variant`
        // if any of these are missing, redirect to the retail page
        if (!$request->has(['height', 'width', 'quantity', 'variant'])) {
            return redirect()->route('retail');
        }

        Log::info('made it to the controller');

        return view('upload', ['batch' => $request->all()]);
    }
}
