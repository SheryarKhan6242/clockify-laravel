<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Report;
use App\Models\Leave;
use App\Models\WorkFromHome;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;



class DashboardApiController extends Controller
{
    //
    public function dashboardWidget($id)
    {
        // Fetch the user's username
        $user = User::find($id);
        if(!$user)
            return response()->json(['success' =>false, 'message' => 'User Does not exist!']);
        $name = $user->name;
        // Fetch the total working hours for the current week
        $currentDate = Carbon::now();
        $currentWeek = $currentDate->weekOfYear;
        $totalWorkingHours = Report::where('user_id', $id)
            ->where('login_date', '>=', $currentDate->startOfWeek()->toDateString())
            ->where('login_date', '<=', $currentDate->endOfWeek()->toDateString())
            ->sum('total_work_hours');
        $workingHours = null;
        $startDate = null;            
        // Find the last date on which the user has worked
        $lastWorkingDate = Report::where('user_id', $id)
            ->whereDate('login_date', '<', today())
            ->orderBy('login_date', 'desc')
            ->value('login_date');
                
        if ($lastWorkingDate) {
            $startDate = $lastWorkingDate;
        
            // Calculate the working hours for the last working date
            $officeOut = Carbon::parse(Report::where('user_id', $id)
                ->whereDate('login_date', $lastWorkingDate)
                ->max('office_out'));
        
            $officeIn = Carbon::parse(Report::where('user_id', $id)
                ->whereDate('login_date', $lastWorkingDate)
                ->min('office_in'));
                    
            if ($officeOut && $officeIn) {
                $workingHours = $officeOut->diffAsCarbonInterval($officeIn);
            }
        }
            
        if ($workingHours) 
            $lastWorkingHours = $workingHours->format('%H:%I:%S');

        $currentClockInDate = Carbon::now();
        // check current clock in
        $currentClockIn = Report::where('user_id', $id)
            ->where('login_date', $currentClockInDate->toDateString())
            ->where('office_out', null)
            ->orderBy('id', 'desc')
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
        //Get Employee's Type and Work Type
        $employee = Employee::where('user_id',$id)->with('employeeType','workType')->first();
        //Calculate total absents in current month
        $currentDate = Carbon::now(); // current date
        $currentMonth = $currentDate->format('m'); // current month
        // First, check if there are any missing records in Reports table for current month
        $reports = Report::where('user_id', $id)->whereMonth('login_date', $currentMonth)->pluck('login_date')->toArray();
        $datesInMonth = Carbon::parse("{$currentDate->year}-{$currentMonth}-01")->daysUntil($currentDate)->filter(function ($date) {
            return !$date->isWeekend();
        });;

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

        // // Get All reports for clockouts with current month
        $reports = Report::where('user_id', $id)
        ->whereMonth('login_date', '=', Carbon::now()->month)
        ->get();
    
        $totalDuration = CarbonInterval::seconds(0);
        
        foreach ($reports as $report) {
            // check if report is for the current date and has office_in time
            if ($report->login_date == $currentDate->format('Y-m-d') && $report->office_in !== null) {
                $officeIn = Carbon::parse($report->office_in);
                $officeOut = isset($report->office_out) ? Carbon::parse($report->office_out) : Carbon::now();
        
                $diffInSeconds = $officeOut->diffInSeconds($officeIn);
        
                $timeDuration = CarbonInterval::seconds($diffInSeconds);
        
                $totalDuration = $totalDuration->add($timeDuration);
            }
        }
        
        $totalTime = $totalDuration->cascade()->format('%H:%I:%S');
        

        //Last Clockin Time
        $lastOfficeIn = Report::where('user_id', $id)
            ->whereDate('login_date', Carbon::now()->format('Y-m-d'))
            ->orderBy('id', 'desc')
            ->value('office_in');

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
            'name' => $name,
            'last_working_hour' => isset($lastWorkingHours) ? $lastWorkingHours : 0,
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
            'employee_type' => $employee->employeeType->name,
            'checkin_type_today' => isset($type->checkinType->type) ? $type->checkinType->type : null,
            'working_type' => $employee->workType->type,
            'last_clockin_today' => isset($lastOfficeIn) ? $lastOfficeIn : null,
            'monthly_absents' => $totalAbsents,
            'wfh_allowed' => $wfhAllowed,
        ];
        
        return response()->json(['dashboard_info' => $dashboard_widget]);
    }
}
