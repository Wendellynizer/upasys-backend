<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentalUnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response()->json(['Welcome to my API!']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function() {

    Route::post('/rental-units/{rentalUnit}/create-tenant', [RentalUnitController::class, 'addTenant']);
    Route::patch('/rental-units/{rentalUnit}/toggle-availability', [RentalUnitController::class, 'toggleAvailability']);
    Route::apiResource('/rental-units', RentalUnitController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});