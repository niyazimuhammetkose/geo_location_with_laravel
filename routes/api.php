<?php

use App\Http\Controllers\GeoLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('geo-location')
    ->name('api.geo-location.')
    ->middleware(['auth:sanctum', 'geoLocationThrottle'])
    ->group(function () {
        Route::get('/', [GeoLocationController::class, 'index'])->name('index');
        Route::get('/{geoLocation}', [GeoLocationController::class, 'show'])->name('show');
        Route::post('/store', [GeoLocationController::class, 'store'])->name('store');
        Route::post('/update/{geoLocation}', [GeoLocationController::class, 'update'])->name('update');
        Route::delete('/destroy/{geoLocation}', [GeoLocationController::class, 'destroy'])->name('destroy');

        Route::post('/calculate-route', [GeoLocationController::class, 'calculateRoute'])->name('calculateRoute');
    });

