<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerAssetController extends Controller
{
    public function show(Request $request)
    {
        $batch = Batch::find($request->input('id'));

        return response()->file(
            Storage::disk('customer_assets')->path($batch->latestCustomerAssetPath())
        );
    }
}
