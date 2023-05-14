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
    public function dashboardWidget($id)
    {
        // $validator = \Validator::make($request->all(), [
        //     'user_id' => 'required|integer' 

        // ]);
        
        // if ($validator->fails())
        // {      
        //     $errors = $validator->errors()->toArray();
        //     // dd($errors);
        //     return response()->json(['errors' => $errors]);
        //     // return response()->json(['errors'=>$validator->errors()->all()]);
        // }

        // Fetch the user's username
        $user = User::find($id)->first();
        $username = $user->username;
        // Fetch the total working hours for the current week
        $currentDate = Carbon::now();
        $currentWeek = $currentDate->weekOfYear;

        $totalWorkingHours = Report::where('user_id', $id)
            ->where('login_date', '>=', $currentDate->startOfWeek()->toDateString())
            ->where('login_date', '<=', $currentDate->endOfWeek()->toDateString())
            ->sum('total_work_hours');

         // Store the last hour of the week
        $lastHourOfWeek = Report::where('user_id', $id)
            ->where('login_date', '>=', $currentDate->startOfWeek()->toDateString())
            ->where('login_date', '<=', $currentDate->endOfWeek()->toDateString())
            ->orderBy('login_date', 'desc')
            ->value('total_work_hours');

         // check current clock in
         $currentClockIn = Report::where('user_id', $id)
         ->where('login_date', '=', $currentDate->toDateString())
         ->where('office_in', '!=', null)
         ->where('office_out', '=', null)
         ->orderBy('login_date', 'desc')
         ->first();
        
        // Check current clock in hours
        $currentClockInHours = Report::where('user_id', $id)
        ->where('login_date', '=', $currentDate->toDateString())
        ->orderBy('login_date', 'desc')
        ->first();
         

        // Fetch the user's work anniversary date
        $currentDate = Carbon::now();
        $employee = Employee::where('user_id',$id)->first();
        $firstName = $employee->first_name;
        $lastName = $employee->last_name;

        if ($employee->joining_date != null) {
            $anniversaryDate = Carbon::parse($employee->joining_date);
            $yearsOfService = $anniversaryDate->diffInYears($currentDate);
        } else {
            $anniversaryDate = null; // or false, 0, etc.
        }
        // return response()->json(['join'=>$anniversaryDate]);

        //NOTE: If this condition is missing, carbon will parse to current date automatically if the date_of_birth is null
        if ($employee->date_of_birth != null) {
            $birthdate = Carbon::parse($employee->date_of_birth);
        } else {
            $birthdate = null; // or false, 0, etc.
        }
        // return response()->json(['join'=>$birthdate]);
        $birthDayMessage = null;
        $anniversaryMessage = null;

         // Check if it's the employee's birthday
        if ($birthdate !=null && $currentDate->isSameDay($birthdate)) {            
            $birthDayMessage = "Today is {$firstName} {$lastName}'s birthday!";
        }
        
        // Check if it's the employee's work anniversary
        if ($anniversaryDate !=null && $currentDate->isSameDay($anniversaryDate)) {
            $anniversaryMessage = "Happy Work Anniversary $firstName $lastName!";
        }

        //Already clockin today
        if($currentClockIn)
        {
            $is_clock_in = true;

        }else{
            $is_clock_in = false;
        }
        
        if($currentClockInHours)
        {
            $clock_in_time = Carbon::parse($currentClockInHours->office_in);
            $clock_out_time = Carbon::parse($currentClockInHours->office_out);
            $currentClockInHours = $clock_in_time->diffInSeconds($clock_out_time ?? Carbon::now());
            $currentClockInHours = gmdate('H:i:s',$currentClockInHours);
        }

        $user = [
            'name' => $username,
            'last_working_hour' => $lastHourOfWeek,
            'total_week_hours' => $totalWorkingHours,
            'celebration' => ["birthday"=>$birthDayMessage, "anniversary"=> $anniversaryMessage],
            'is_clock_in' => $is_clock_in,
            'currentClockInHours' => $currentClockInHours ?? null
        ];
        
        return response()->json(['dashboard_info' => $user]);
    }
}
