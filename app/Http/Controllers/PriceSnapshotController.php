<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceSnapshotRequest;
use App\Http\Requests\UpdatePriceSnapshotRequest;
use App\Models\PriceMeasurement;
use App\Models\PriceSnapshot;
use Carbon\Carbon;

class PriceSnapshotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePriceSnapshotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePriceSnapshotRequest $request)
    {
        $url = $request->input('url');

        $priceSnapshot = PriceSnapshot::create(compact('url'));

        return $priceSnapshot->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceSnapshot  $priceSnapshot
     * @return \Illuminate\Http\Response
     */
    public function show(PriceSnapshot $priceSnapshot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceSnapshot  $priceSnapshot
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceSnapshot $priceSnapshot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePriceSnapshotRequest  $request
     * @param  \App\Models\PriceSnapshot  $priceSnapshot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePriceSnapshotRequest $request, PriceSnapshot $priceSnapshot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceSnapshot  $priceSnapshot
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceSnapshot $priceSnapshot)
    {
        //
    }
}
