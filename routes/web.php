<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AjaxRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\EmployeeWorkingTypeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\WorkFromHomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;

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
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
    });

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

    Route::prefix('/leave')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('leave.index');
        Route::get('/edit/{id}', [LeaveController::class, 'edit'])->name('leave.edit');
        Route::post('/update/{id}', [LeaveController::class, 'update'])->name('leave.update');
        Route::post('/store', [LeaveController::class, 'store'])->name('leave.store');
        Route::get('/delete/{id}', [LeaveController::class, 'destroy'])->name('leave.delete');
        Route::post('/update-leave-status', [LeaveController::class, 'updateLeaveStatus'])->name('leaveType.updateLeaveStatus');
        Route::get('/load-table', [LeaveController::class, 'get_leave_data'])->name('leave.get_leave_type_data');
    });

    Route::prefix('/leave-type')->group(function () {
        Route::get('/', [LeaveTypeController::class, 'index'])->name('leaveType.index');
        Route::get('/edit/{id}', [LeaveTypeController::class, 'edit'])->name('leaveType.edit');
        Route::post('/update/{id}', [LeaveTypeController::class, 'update'])->name('leaveType.update');
        Route::post('/store', [LeaveTypeController::class, 'store'])->name('leaveType.store');
        Route::get('/delete/{id}', [LeaveTypeController::class, 'destroy'])->name('leaveType.delete');
        Route::get('/load-table', [LeaveTypeController::class, 'get_leave_type_data'])->name('leaveType.get_leave_type_data');
    });

    Route::prefix('/work-type')->group(function () {
        Route::get('/', [EmployeeWorkingTypeController::class, 'index'])->name('workType.index');
        Route::get('/edit/{id}', [EmployeeWorkingTypeController::class, 'edit'])->name('workType.edit');
        Route::post('/update/{id}', [EmployeeWorkingTypeController::class, 'update'])->name('workType.update');
        Route::post('/store', [EmployeeWorkingTypeController::class, 'store'])->name('workType.store');
        Route::get('/delete/{id}', [EmployeeWorkingTypeController::class, 'destroy'])->name('workType.delete');
        Route::get('/load-table', [EmployeeWorkingTypeController::class, 'get_leave_type_data'])->name('workType.get_leave_type_data');
    });

    Route::prefix('/shift')->group(function () {
        Route::get('/', [ShiftController::class, 'index'])->name('shift.index');
        Route::get('/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit');
        Route::post('/update/{id}', [ShiftController::class, 'update'])->name('shift.update');
        Route::post('/store', [ShiftController::class, 'store'])->name('shift.store');
        Route::get('/delete/{id}', [ShiftController::class, 'destroy'])->name('shift.delete');
        Route::get('/load-shift-table', [ShiftController::class, 'get_shift_data'])->name('shift.get_shift_data');
    });

    Route::prefix('/notice')->group(function () {
        Route::get('/', [NoticeController::class, 'index'])->name('notice.index');
        Route::get('/edit/{id}', [NoticeController::class, 'edit'])->name('notice.edit');
        Route::post('/update/{id}', [NoticeController::class, 'update'])->name('notice.update');
        Route::post('/store', [NoticeController::class, 'store'])->name('notice.store');
        Route::get('/delete/{id}', [NoticeController::class, 'destroy'])->name('notice.delete');
        Route::get('/load-notice-table', [NoticeController::class, 'get_notice_data'])->name('notice.get_notice_data');
    });

    Route::prefix('/holiday')->group(function () {
        Route::get('/', [HolidayController::class, 'index'])->name('holiday.index');
        Route::get('/edit/{id}', [HolidayController::class, 'edit'])->name('holiday.edit');
        Route::post('/update/{id}', [HolidayController::class, 'update'])->name('holiday.update');
        Route::post('/store', [HolidayController::class, 'store'])->name('holiday.store');
        Route::get('/delete/{id}', [HolidayController::class, 'destroy'])->name('holiday.delete');
        Route::get('/load-holiday-table', [HolidayController::class, 'get_holiday_data'])->name('holiday.get_holiday_data');
    });

    Route::prefix('/event')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('event.index');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('event.edit');
        Route::post('/update/{id}', [EventController::class, 'update'])->name('event.update');
        Route::post('/store', [EventController::class, 'store'])->name('event.store');
        Route::get('/delete/{id}', [EventController::class, 'destroy'])->name('event.delete');
        Route::get('/load-event-table', [EventController::class, 'get_event_data'])->name('event.get_event_data');
    });

    Route::prefix('/location')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('location.index');
        Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
        Route::post('/store', [LocationController::class, 'store'])->name('location.store');
        Route::post('/update/{id}', [LocationController::class, 'update'])->name('location.update');
        Route::get('/delete/{id}', [LocationController::class, 'destroy'])->name('location.delete');
        Route::get('/load-location-table', [LocationController::class, 'get_location_data'])->name('location.get_location_data');
    });

    Route::prefix('/emp-type')->group(function () {
        Route::get('/', [EmployeeTypeController::class, 'index'])->name('emp.type.index');
        Route::get('/edit/{id}', [EmployeeTypeController::class, 'edit'])->name('emp.type.edit');
        Route::post('/store', [EmployeeTypeController::class, 'store'])->name('emp.type.store');
        Route::post('/update/{id}', [EmployeeTypeController::class, 'update'])->name('emp.type.update');
        Route::get('/delete/{id}', [EmployeeTypeController::class, 'destroy'])->name('emp.type.delete');
        Route::get('/load-emp-type-table', [EmployeeTypeController::class, 'getEmpTypeData'])->name('emp_type.get_location_data');
    });

    Route::prefix('/employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('emp.index');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('emp.edit');
        Route::post('/store', [EmployeeController::class, 'store'])->name('emp.store');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('emp.update');
        Route::get('/delete/{id}', [EmployeeController::class, 'destroy'])->name('emp.delete');
        Route::get('/load-emp-table', [EmployeeController::class, 'getEmpData'])->name('emp_get_location_data');
    });

    Route::prefix('/email-template')->group(function () {
        Route::get('/', [EmailTemplateController::class, 'index'])->name('template.index');
        Route::get('/create', [EmailTemplateController::class, 'create'])->name('template.create');
        Route::get('/edit/{id}', [EmailTemplateController::class, 'edit'])->name('template.edit');
        Route::post('/store', [EmailTemplateController::class, 'store'])->name('template.store');
        Route::post('/update/{id}', [EmailTemplateController::class, 'update'])->name('template.update');
        Route::get('/delete/{id}', [EmailTemplateController::class, 'destroy'])->name('template.delete');
        // Route::get('/load-emp-table', [EmailTemplateController::class, 'getEmpData'])->name('emp_get_location_data');
    });

    Route::prefix('/work-from-home')->group(function () {
        Route::get('/', [WorkFromHomeController::class, 'index'])->name('wfh.index');
        Route::get('/create', [WorkFromHomeController::class, 'create'])->name('wfh.create');
        Route::get('/edit/{id}', [WorkFromHomeController::class, 'edit'])->name('wfh.edit');
        Route::post('/store', [WorkFromHomeController::class, 'store'])->name('wfh.store');
        Route::post('/update/{id}', [WorkFromHomeController::class, 'update'])->name('wfh.update');
        Route::get('/delete/{id}', [WorkFromHomeController::class, 'destroy'])->name('wfh.delete');
        Route::get('/load-table', [WorkFromHomeController::class, 'getWfhData'])->name('wfh_data');
        Route::post('/update-status', [WorkFromHomeController::class, 'updateWfhStatus'])->name('wfh.updateWfhStatus');
    });

    Route::prefix('/ajax')->group(function () {
        Route::get('/cities/{country_id}', [ AjaxRequestController::class, 'getCities' ])->name('country_cities');
        Route::post('cities-selected', [ AjaxRequestController::class, 'getSelectedCities' ])->name('selected_country_cities');
        Route::post('/store-emp-type-leave', [ AjaxRequestController::class, 'storeEmpTypeLeaves' ])->name('store_emp_type_leaves');
        Route::get('/get-emp-type-leave/{id}', [ AjaxRequestController::class, 'getEmpTypeLeaves' ])->name('get_emp_type_leaves');
    });

    Route::prefix('/report')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('report.index');
        Route::get('/edit/{id}', [ReportController::class, 'edit'])->name('report.edit');
        // Route::post('/update/{id}', [ReportController::class, 'update'])->name('leave.update');
        // Route::post('/store', [ReportController::class, 'store'])->name('leave.store');
        // Route::get('/delete/{id}', [ReportController::class, 'destroy'])->name('leave.delete');
        // Route::post('/update-leave-status', [ReportController::class, 'updateLeaveStatus'])->name('leaveType.updateLeaveStatus');
        Route::get('/load-table', [ReportController::class, 'getReportData'])->name('report.get_report_data');
    });


});




require __DIR__.'/auth.php';
