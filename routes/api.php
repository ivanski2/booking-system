<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppointmentApiController;

Route::post('login', [AuthApiController::class, 'login']);

Route::middleware('auth.api')->group(function() {
    Route::apiResource('appointments', AppointmentApiController::class);
});
