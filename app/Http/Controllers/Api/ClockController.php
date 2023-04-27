<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Carbon\Carbon;

class ClockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clockin(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required'],
            'checkin_id' => ['required'],
            'shift_id' => ['required'],
            'clockin_location' => ['required'],
            'login_user_ip' => ['required'],
        ]);
        // dd($request->all());
        // Insert Clockin data for Reports
        $report = new Report();
        $report->user_id = $request->user_id;
        $report->office_in = Carbon::now()->format('H:i:m');
        $report->login_date = Carbon::now()->format('Y-m-d');
        $report->shift_id = $request->shift_id;
        $report->wfh_reason =  $request->wfh_reason ?? null;
        $report->clockin_location = $request->clockin_location;
        $report->login_user_ip = $request->login_user_ip;
        $report->checkin_id = $request->checkin_id;
        $report->save();
        // Return the entire payload as a JSON response
        return response()->json($report);
    }

    public function clockout(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required'],
            'login_date' => ['required'],
        ]);

        // Get Current Check in time from reports for the following user and the date 
        $report = Report::where('user_id',$request->user_id)->where('login_date',$request->login_date)->first();
        if($report)
        {
            $checkInTime = $report->office_in;
            $checkOutTime = Carbon::now()->format('H:i:m');
            //Calculate working hours
            // $workHours = $checkInTime - $checkOutTime;
            $end = Carbon::parse($checkOutTime);
            $workHours = $end->diffInSeconds($checkInTime);
            //Calculate working hours
            $report->total_work_hours = gmdate('H:i:s', $workHours);
            $report->office_out = $checkOutTime;
            $report->save();
            // Return the entire payload as a JSON response
            return response()->json(['date'=> $report]);
        } else {
            return response()->json(['message'=>'Report for the following user_id or login_date does not exist']);
        }
    }
}
