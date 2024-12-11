<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexGeoLocationRequest;
use App\Http\Requests\StoreGeoLocationRequest;
use App\Http\Requests\UpdateGeoLocationRequest;
use App\Http\Resources\GeoLocationResource;
use App\Http\Resources\GeoLocationResourceCollection;
use App\Models\GeoLocation;
use Illuminate\Http\Request;

class GeoLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexGeoLocationRequest $request)
    {
        $geoLocationsQuery = GeoLocation::query();

        $geoLocationsQuery->where('created_by', auth()->id());

        if ($request->query('withTrashed')) $geoLocationsQuery->withTrashed();

        $perPage = $request->query('perPage', 10);

        $geoLocations = $geoLocationsQuery->paginate($perPage);

        $response_data = new GeoLocationResourceCollection($geoLocations);

        return response()->json($response_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeoLocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GeoLocation $geoLocation)
    {
        if ($geoLocation->created_by !== auth()->id()) abort(403, __("messages.forbidden"));

        $response_data = new GeoLocationResource($geoLocation);

        return response()->json($response_data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeoLocation $geoLocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeoLocationRequest $request, GeoLocation $geoLocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeoLocation $geoLocation)
    {
        //
    }

}
