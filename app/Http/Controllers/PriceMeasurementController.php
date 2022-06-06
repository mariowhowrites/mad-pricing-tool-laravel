<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePriceMeasurementRequest;
use App\Http\Requests\UpdatePriceMeasurementRequest;
use App\Models\PriceMeasurement;
use Carbon\Carbon;

class PriceMeasurementController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePriceMeasurementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePriceMeasurementRequest $request)
    {
        $prices = $request->input('prices');

        $priceMeasurements = collect($prices)->map(function ($measurement) use ($request) {            
            return [
                'price_snapshot_id' => $request->input('snapshotID'),
                'width' => $measurement['width'],
                'height' => $measurement['height'],
                'quantity' => $measurement['quantity'],
                'variant' => $measurement['variant'],
                'price' => floatval($measurement['price']) * 100,
                'created_at' => Carbon::now(),
            ];
        })->toArray();

        PriceMeasurement::insert($priceMeasurements);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceMeasurement  $priceMeasurement
     * @return \Illuminate\Http\Response
     */
    public function show(PriceMeasurement $priceMeasurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceMeasurement  $priceMeasurement
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceMeasurement $priceMeasurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePriceMeasurementRequest  $request
     * @param  \App\Models\PriceMeasurement  $priceMeasurement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePriceMeasurementRequest $request, PriceMeasurement $priceMeasurement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceMeasurement  $priceMeasurement
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceMeasurement $priceMeasurement)
    {
        //
    }
}
