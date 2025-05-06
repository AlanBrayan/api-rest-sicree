<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IonosController;

Route::middleware(['custom.cors', 'auth.api'])->group(function () {
    Route::get('ionos', [IonosController::class, 'index']);
    Route::post('ionos', [IonosController::class, 'store']);
    Route::get('ionos/{iono}', [IonosController::class, 'show']);
    Route::put('ionos/{iono}', [IonosController::class, 'update']);
    Route::delete('ionos/{iono}', [IonosController::class, 'destroy']);
});
