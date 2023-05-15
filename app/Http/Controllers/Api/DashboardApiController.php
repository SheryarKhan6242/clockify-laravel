<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Report;
use App\Models\Leave;
use App\Models\WorkFromHome;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\CarbonInterval;

class DashboardApiController extends Controller
{
    //
    public function dashboardWidget($id)
    {
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
        
        // Get current clock in hours
        $currentClockInHours = Report::where('user_id', $id)
        ->where('login_date', '=', $currentDate->toDateString())
        ->orderBy('login_date', 'desc')
        ->first();

        //Calculate All active Employee's Birthday and Anniversary
        $currentDate = Carbon::now();
        $birthdayMessages = [];
        $anniversaryMessages = [];
        $employees = Employee::where('status', 1)->get();

        foreach ($employees as $employee) {
            $birthdate = Carbon::parse($employee->date_of_birth);
            // Check if it's the employee's birthday
            if ($birthdate->format('m-d') === $currentDate->format('m-d')) {
                $birthdayMessages[] = "Today is {$employee->first_name} {$employee->last_name}'s birthday!";
            }
        
            // Check if it's the employee's anniversary
            $anniversaryDate = Carbon::parse($employee->joining_date);
            if ($anniversaryDate->format('m-d') === $currentDate->format('m-d')) {
                $anniversaryMessages[] = "Happy Anniversary {$employee->first_name} {$employee->last_name}!";
            }
        }

        // $employee = Employee::where('user_id',$id)->first();
        // $firstName = $employee->first_name;
        // $lastName = $employee->last_name;

        // // Fetch the user's work anniversary date
        // if ($employee->joining_date != null) {
        //     $anniversaryDate = Carbon::parse($employee->joining_date);
        //     $yearsOfService = $anniversaryDate->diffInYears($currentDate);
        // } else {
        //     $anniversaryDate = null; // or false, 0, etc.
        // }
        // // return response()->json(['join'=>$anniversaryDate]);

        // //NOTE: If this condition is missing, carbon will parse to current date automatically if the date_of_birth is null
        // if ($employee->date_of_birth != null) {
        //     $birthdate = Carbon::parse($employee->date_of_birth);
        // } else {
        //     $birthdate = null; // or false, 0, etc.
        // }
        // // return response()->json(['join'=>$birthdate]);
        // $birthDayMessage = null;
        // $anniversaryMessage = null;

        //  // Check if it's the employee's birthday
        // if ($birthdate !=null && $currentDate->isSameDay($birthdate)) {            
        //     $birthDayMessage = "Today is {$firstName} {$lastName}'s birthday!";
        // }
        
        // // Check if it's the employee's work anniversary
        // if ($anniversaryDate !=null && $currentDate->isSameDay($anniversaryDate)) {
        //     $anniversaryMessage = "Happy Work Anniversary $firstName $lastName!";
        // }

        //Already clockin today
        $is_clock_in = false;
        if($currentClockIn)
            $is_clock_in = true;
        
        if($currentClockInHours)
        {
            $clock_in_time = Carbon::parse($currentClockInHours->office_in);
            $clock_out_time = Carbon::parse($currentClockInHours->office_out);
            $currentClockInHours = $clock_in_time->diffInSeconds($clock_out_time ?? Carbon::now());
            $currentClockInHours = gmdate('H:i:s',$currentClockInHours);
        }

        //Get Checkin Type Only when not clocked out
        $type = Report::where('user_id', $id)->where('office_out', null)->with('checkinType')->first();

        //Calculate total absents in current month
        $currentDate = Carbon::now(); // current date
        $currentMonth = $currentDate->format('m'); // current month
        // First, check if there are any missing records in Reports table for current month
        $reports = Report::where('user_id', $id)->whereMonth('login_date', $currentMonth)->pluck('login_date')->toArray();
        $datesInMonth = Carbon::parse("{$currentDate->year}-{$currentMonth}-01")->daysUntil($currentDate);

        $absentDays = [];
        foreach ($datesInMonth as $date) {
            $dateStr = $date->format('Y-m-d');
            if (!in_array($dateStr, $reports)) {
                // if record is missing, check if there is an approved leave request for the user on that day
                $leave = Leave::where('user_id', $id)
                    ->where('status', 'approved')
                    ->whereDate('start_date', '<=', $dateStr)
                    ->whereDate('end_date', '>=', $dateStr)
                    ->first();
                if (!$leave) {
                    // if no leave request found, mark as absent
                    $absentDays[] = $dateStr;
                }
            }
        }

        $totalAbsents = count($absentDays);

        // Get All reports for clockouts with current month
        $reports = Report::where('user_id', $id)
            ->whereMonth('login_date', '=', Carbon::now()->month)
            ->where('office_out', '!=', null)
            ->get();

        // return response()->json($currentDate->format('Y-m-d'));
        // Based on current month, calculate dff bw hours in office_in and office_out
        $clockinHours = [];
        foreach ($reports as $report) {
            // check if report is for current date
            if ($report->login_date == $currentDate->format('Y-m-d')) {
                $officeIn = Carbon::parse($report->office_in);
                $officeOut = Carbon::parse($report->office_out);
                $diff = $officeOut->diffInSeconds($officeIn);
                $clockinHours[] = gmdate('H:i:s',$diff);
            }
        }
        
        // Initialize total duration as zero seconds
        $totalDuration = CarbonInterval::seconds(0); 

        foreach ($clockinHours as $timeStr) {
            $timeComponents = explode(':', $timeStr);
            $hours = intval($timeComponents[0]);
            $minutes = intval($timeComponents[1]);
            $seconds = intval($timeComponents[2]);

            $timeDuration = CarbonInterval::hours($hours)
                ->minutes($minutes)
                ->seconds($seconds);

            $totalDuration = $totalDuration->add($timeDuration);
        }

        $totalTime = $totalDuration->format('%H:%I:%S');
        //Last Clockout Time
        $lastOfficeOut = Report::where('user_id', $id)
            ->whereDate('login_date', '=', Carbon::now()->format('Y-m-d'))
            ->whereNotNull('office_out')
            ->pluck('office_out')
            ->first();

        //Check if WFH is allowed
        // return response()->json($currentDate->format('Y-m-d'));
        $wfhAllowed = false;
        $wfh = WorkFromHome::where('user_id', $id)
            ->where('start_date', '<=', $currentDate->format('Y-m-d'))
            ->where('end_date', '>=', $currentDate->format('Y-m-d'))
            ->where('status', 'approved')
            ->get();
                // return response()->json(isset($requests));
        if ($wfh->count() > 0)
            $wfhAllowed = true;
        
        $dashboard_widget = [
            'name' => $username,
            'last_working_hour' => $lastHourOfWeek,
            'total_week_hours' => $totalWorkingHours,
            'widget_collections' => [
                'celebrations' => 
                    [
                        "birthday"=>$birthdayMessages, 
                        "anniversary"=> $anniversaryMessages
                    ],
            ],
            'is_clock_in' => $is_clock_in,
            "profile_photo_path" => $user->profile_photo_path ?? null,
            'clockin_hours_today' => $totalTime  ?? 0,
            'checkin_type_today' => isset($type->checkinType->type) ? $type->checkinType->type : null,
            'last_clockin_today' => isset($lastOfficeOut) ? $lastOfficeOut : null,
            'monthly_absents' => $totalAbsents,
            'wfh_allowed' => $wfhAllowed,
        ];
        
        return response()->json(['dashboard_info' => $dashboard_widget]);
    }
}
