<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ClockController;
use App\Http\Controllers\Api\CheckInTypeController;
use App\Http\Controllers\Api\EmployeeApiController;
use App\Http\Controllers\Api\ReportApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\LeaveTypeApiController;
use App\Http\Controllers\Api\LeaveRequestApiController;
use App\Http\Controllers\Api\WorkFromHomeApiController;
use App\Http\Controllers\Api\PasswordApiController;





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

Route::post('/login', [LoginController::class, 'login'])->middleware('formdata');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('formdata');

    Route::post('/clockin', [ClockController::class, 'clockin'])->middleware('formdata');
    Route::post('/clockout', [ClockController::class, 'clockout'])->middleware('formdata');
    Route::get('/get-checkin-type', [CheckInTypeController::class, 'getCheckInTypes']);

    Route::prefix('/employee')->group(function () {
        Route::get('/working-types', [EmployeeApiController::class, 'getEmpWorkingTypes'])->name('getEmpWorkingTypes');
        Route::get('/profile/{id}', [EmployeeApiController::class, 'getProfile'])->name('getProfile');
        Route::post('/update-profile', [EmployeeApiController::class, 'updateProfile'])->name('updateProfile')->middleware('formdata');
    });

    Route::prefix('/report')->group(function () {
        Route::get('/', [ReportApiController::class, 'getReport'])->name('getReport');
    });

    Route::prefix('/leave-type')->group(function () {
        Route::get('/', [LeaveTypeApiController::class, 'getLeaveType'])->name('getLeaveType');
    });

    Route::prefix('/leave')->group(function () {
        Route::post('/add-request', [LeaveRequestApiController::class, 'addLeaveRequest'])->name('addLeaveRequest')->middleware('formdata');
    });

    Route::prefix('/work-from-home')->group(function () {
        Route::post('/add-request', [WorkFromHomeApiController::class, 'addWfhRequest'])->name('addWfhRequest')->middleware('formdata');
    });

    Route::get('/dashboard-widget/{user}', [DashboardApiController::class, 'dashboardWidget'])->name('dashboardWidget');
    
    Route::get('request-otp', [PasswordApiController::class, 'requestOtp'])->name('requestOtp');
    Route::post('verify-otp', [PasswordApiController::class, 'verifyOtp'])->name('verifyOtp')->middleware('formdata');
});
