<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ClockController;
use App\Http\Controllers\Api\CheckInTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::prefix('clock')->group(function () {
        Route::post('/clockin', [ClockController::class, 'clockin']);
        Route::post('/clockout', [ClockController::class, 'clockout']);
    });
    Route::get('/get-checkin-type', [CheckInTypeController::class, 'getCheckInTypes']);
});
