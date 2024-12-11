<?php

use App\Http\Controllers\GeoLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('geo-location')
        ->name('api.geo-location.')
        ->group(function () {
            Route::get('/', [GeoLocationController::class, 'index'])->name('index');
            Route::get('/{geoLocation}', [GeoLocationController::class, 'show'])->name('show');
            Route::post('/store', [GeoLocationController::class, 'store'])->name('store');
            Route::post('/update/{geoLocation}', [GeoLocationController::class, 'update'])->name('update');
            Route::delete('/destroy/{geoLocation}', [GeoLocationController::class, 'destroy'])->name('destroy');
    });
});
