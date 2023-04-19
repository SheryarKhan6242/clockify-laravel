<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::prefix('/dashboard')->group(function () {    
        Route::get('/', [ DashboardController::class, 'index' ])->name('dashboard');

    //Profile Default made by breeze
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    });

    Route::prefix('/logs')->group(function () {
        Route::get('/addToLog', [LogActivityController::class, 'AddLogActivity'])->name('add.logs');
        Route::get('/logActivity', [LogActivityController::class, 'logActivity'])->name('show.logs');
    });

    Route::prefix('/department')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::post('/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
        Route::post('/store', [DepartmentController::class, 'store'])->name('department.store');
        Route::get('/delete/{id}', [DepartmentController::class, 'destroy'])->name('department.delete');
        Route::get('/load-department-table', [DepartmentController::class, 'get_department_data'])->name('department.get_department_data');
    });

    Route::prefix('/shift')->group(function () {
        Route::get('/', [ShiftController::class, 'index'])->name('shift.index');
        Route::get('/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit');
        Route::post('/update/{id}', [ShiftController::class, 'update'])->name('shift.update');
        Route::post('/store', [ShiftController::class, 'store'])->name('shift.store');
        Route::get('/delete/{id}', [ShiftController::class, 'destroy'])->name('shift.delete');
        Route::get('/load-shift-table', [ShiftController::class, 'get_shift_data'])->name('shift.get_shift_data');
    });

    Route::prefix('/location')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('location.index');
        Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
        Route::post('/store', [LocationController::class, 'store'])->name('location.store');
        Route::post('/update/{id}', [LocationController::class, 'update'])->name('location.update');
        Route::get('/delete/{id}', [LocationController::class, 'destroy'])->name('location.delete');
        Route::get('/load-location-table', [LocationController::class, 'get_location_data'])->name('location.get_location_data');
    });

});




require __DIR__.'/auth.php';
