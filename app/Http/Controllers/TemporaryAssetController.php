<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemporaryAssetController extends Controller
{
    public function show(Request $request)
    {
        $batch = Batch::find($request->id);

        $asset = $batch->getTemporaryAsset();

        return response()->file(Storage::disk('temp')->path($asset->upload_path));
    }
}
