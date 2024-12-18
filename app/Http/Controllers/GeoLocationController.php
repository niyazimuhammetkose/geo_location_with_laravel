<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRouteRequest;
use App\Http\Requests\IndexGeoLocationRequest;
use App\Http\Requests\StoreGeoLocationRequest;
use App\Http\Requests\UpdateGeoLocationRequest;
use App\Http\Resources\GeoLocationResource;
use App\Http\Resources\GeoLocationResourceCollection;
use App\Models\GeoLocation;
use App\Services\DistanceService;
use Illuminate\Http\Request;

class GeoLocationController extends Controller
{
    private DistanceService $distanceService;

    public function __construct(DistanceService $distanceService)
    {
        $this->distanceService = $distanceService;
    }

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

        $responseData = new GeoLocationResourceCollection($geoLocations);

        return response()->json($responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeoLocationRequest $request)
    {
        $newGeoLocation = GeoLocation::create($request->all());

        $responseData = new GeoLocationResource($newGeoLocation);

        return response()->json($responseData,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GeoLocation $geoLocation)
    {
        if ($geoLocation->created_by !== auth()->id()) abort(403, __("messages.forbidden"));

        $responseData = new GeoLocationResource($geoLocation);

        return response()->json($responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeoLocationRequest $request, GeoLocation $geoLocation)
    {
        if ($geoLocation->created_by !== auth()->id()) abort(403, __("messages.forbidden"));

        $validatedData = $request->validated();

        if (empty($validatedData)) abort(400, __("messages.bad-request"));

        $geoLocation->update($validatedData);

        $responseData = new GeoLocationResource($geoLocation);

        return response()->json($responseData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeoLocation $geoLocation)
    {
        if ($geoLocation->created_by !== auth()->id()) abort(403, __("messages.forbidden"));

        $geoLocation->delete();

        return response()->noContent();
    }

    public function calculateRoute(CalculateRouteRequest $request)
    {
        $startLat = $request->input('latitude');
        $startLon = $request->input('longitude');

        $locations = GeoLocation::where('created_by', auth()->id())->get();

        $route = $this->distanceService->generateRouteFromNearest($startLat, $startLon, $locations->toArray());

        return response()->json($route);
    }

}
