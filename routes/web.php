<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;


Route::get('/', function () {
    return redirect()->route('appointments.index');
});

Route::resource('appointments', AppointmentController::class);
