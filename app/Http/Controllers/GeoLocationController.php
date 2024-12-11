<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateRouteRequest;
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
        $newGeoLocation = GeoLocation::create($request->all());

        $response_data = new GeoLocationResource($newGeoLocation);

        return response()->json($response_data,201);
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
        if ($geoLocation->created_by !== auth()->id()) abort(403, __("messages.forbidden"));

        $validatedData = $request->validated();

        if (empty($validatedData)) abort(400, __("messages.bad-request"));

        $geoLocation->update($validatedData);

        $response_data = new GeoLocationResource($geoLocation);

        return response()->json($response_data);
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

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371;  // Yeryüzü yarıçapı (km)
        $phi1 = deg2rad($lat1);
        $phi2 = deg2rad($lat2);
        $deltaPhi = deg2rad($lat2 - $lat1);
        $deltaLambda = deg2rad($lon2 - $lon1);

        $a = sin($deltaPhi / 2) * sin($deltaPhi / 2) + cos($phi1) * cos($phi2) * sin($deltaLambda / 2) * sin($deltaLambda / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c; // Mesafe kilometre cinsinden
    }

    public function calculateRoute(CalculateRouteRequest $request)
    {
        $startLat = $request->input('latitude');
        $startLon = $request->input('longitude');

        $locations = GeoLocation::where('created_by', auth()->id())->get();

        $route = [];
        $remainingLocations = $locations->toArray();

        $currentLat = $startLat;
        $currentLon = $startLon;

        while (count($remainingLocations) > 0) {
            $nearestLocation = null;
            $shortestDistance = PHP_INT_MAX;

            foreach ($remainingLocations as $location) {
                $distance = $this->haversine($currentLat, $currentLon, $location['latitude'], $location['longitude']);

                if ($distance < $shortestDistance) {
                    $shortestDistance = $distance;
                    $nearestLocation = [
                        "id" => $location["id"],
                        "name" => $location["name"],
                        "latitude" => $location["latitude"],
                        "longitude" => $location["longitude"],
                        "marker_color" => $location["marker_color"],
                        "distance" => $distance,
                    ];
                }
            }

            $route[] = $nearestLocation;
            $currentLat = $nearestLocation['latitude'];
            $currentLon = $nearestLocation['longitude'];

            $remainingLocations = array_filter($remainingLocations, function($location) use ($nearestLocation) {
                return $location['id'] !== $nearestLocation['id'];
            });
            $remainingLocations = array_values($remainingLocations);
        }

        return response()->json($route);
    }

}
