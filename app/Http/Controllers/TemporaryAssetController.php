<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class TemporaryAssetController extends Controller
{
    public function show(Request $request)
    {
        $token = $request->input('token');

        try {
            $batchID = Crypt::decrypt($token);

            $batch = Batch::find($batchID);

            $asset = $batch->getTemporaryAsset();

            return response()->file(storage_path('app/assets/temp/' . $asset->upload_path));
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Invalid token'], 401);
        }
    }
}
