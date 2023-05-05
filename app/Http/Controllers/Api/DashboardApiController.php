<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Report;
use Carbon\Carbon;

class DashboardApiController extends Controller
{
    //
    public function dashboardWidget(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required' 

        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }

        // Fetch the user's username
        $user = User::find($request->user_id)->first();
        $username = $user->username;

        // Fetch the total working hours for the current week
        $currentDate = Carbon::now();
        $currentWeek = $currentDate->weekOfYear;

        $totalWorkingHours = Report::where('user_id', $request->user_id)
            ->where('login_date', '>=', $currentDate->startOfWeek()->toDateString())
            ->where('login_date', '<=', $currentDate->endOfWeek()->toDateString())
            ->sum('total_work_hours');

         // Store the last hour of the week
        $lastHourOfWeek = Report::where('user_id', $request->user_id)
            ->where('login_date', '>=', $currentDate->startOfWeek()->toDateString())
            ->where('login_date', '<=', $currentDate->endOfWeek()->toDateString())
            ->orderBy('login_date', 'desc')
            ->value('total_work_hours');

        // Fetch the user's work anniversary date
        $employee = Employee::where('user_id',$request->user_id)->first();
        $joinDate = $employee->created_at;
        $firstName = $employee->first_name;
        $lastName = $employee->last_name;

        // Check if it's the employee's work anniversary
        $currentDate = Carbon::now();
        $anniversaryDate = Carbon::parse($joinDate);
        $yearsOfService = $anniversaryDate->diffInYears($currentDate);

        // Check if it's the employee's birthday
        $birthdate = Carbon::parse($employee->dob);

        if ($currentDate->isSameDay($birthdate)) {
            $message = "Today is {$firstName} {$lastName}'s birthday!";
        } else {
            $message = '';
        }

        // Check if it's the employee's work anniversary
        if ($anniversaryDate->isSameMonth($currentDate) && $anniversaryDate->isSameYear($currentDate)) {
            $message .= " Happy Work Anniversary $firstName $lastName!";
        }

        $user = [
            'name' => $username,
            'last_working_hour' => $lastHourOfWeek,
            'total_week_hours' => $totalWorkingHours,
            'announcement' => $message
        ];
        
        return response()->json(['dashboard_info' => $user]);
    }
}
