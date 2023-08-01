<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\DeliveryController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cities', [CityController::class, 'index']);
    Route::get('/deliveries', [DeliveryController::class, 'index']);
    Route::post('/deliveries', [DeliveryController::class, 'store']);
    Route::put('/deliveries/{id}', [DeliveryController::class, 'update']);
    Route::delete('/deliveries/{id}', [DeliveryController::class, 'destroy']);
});

