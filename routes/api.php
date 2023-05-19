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
use App\Http\Controllers\Api\DeviceUserApiController;
use App\Http\Controllers\Api\TimeAdjustmentApiController;
use App\Http\Controllers\Api\AllowanceApiController;


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
        Route::get('/{user_id}', [LeaveRequestApiController::class, 'getUserLeavesRequests'])->name('getUserLeavesRequests')->middleware('formdata');
        Route::post('/add-request', [LeaveRequestApiController::class, 'addLeaveRequest'])->name('addLeaveRequest')->middleware('formdata');
    });

    Route::prefix('/work-from-home')->group(function () {
        Route::get('/{user_id}', [WorkFromHomeApiController::class, 'getUserWfhRequests'])->name('getUserWfhRequests')->middleware('formdata');
        Route::post('/add-request', [WorkFromHomeApiController::class, 'addWfhRequest'])->name('addWfhRequest')->middleware('formdata');
    });

    Route::prefix('/device')->group(function () {
        Route::post('/add', [DeviceUserApiController::class, 'storeDeviceId'])->name('storeDeviceId')->middleware('formdata');
    });

    Route::prefix('/time-adjustment')->group(function () {
        Route::get('/{user_id}', [TimeAdjustmentApiController::class, 'getTimeAdjustmentRequests'])->name('getTimeAdjustmentRequests')->middleware('formdata');
        Route::post('/add-request', [TimeAdjustmentApiController::class, 'addTimeAdjustmentRequest'])->name('addTimeAdjustmentRequest')->middleware('formdata');
    });

    Route::prefix('/allowance')->group(function () {
        Route::get('/{user_id}/{checkin_id}', [AllowanceApiController::class, 'getUserAllowance'])->name('getUserAllowance')->middleware('formdata');
        Route::post('/add-request', [AllowanceApiController::class, 'addAllowanceRequest'])->name('addAllowanceRequest')->middleware('formdata');
    });

    Route::get('/dashboard-widget/{user}', [DashboardApiController::class, 'dashboardWidget'])->name('dashboardWidget');
     
});

    Route::get('request-otp', [PasswordApiController::class, 'requestOtp'])->name('requestOtp');
    Route::post('verify-otp', [PasswordApiController::class, 'verifyOtp'])->name('verifyOtp')->middleware('formdata');
    Route::post('update-password', [PasswordApiController::class, 'updatePassword'])->name('updatePassword')->middleware('formdata');

