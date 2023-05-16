<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Carbon\Carbon;

class ReportApiController extends Controller
{
    //
    public function getReport(Request $request)
    {
        // return response()->json(['helo'=>'user']);
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        //Fetch report based on user_id
        $report = Report::where('user_id', $request->user_id);
        if($report->get()->count() > 0)
        {
            if (!$request->start_date && !$request->end_date && $request->month) {
                // Fetch reports for the given month and year
                $date = Carbon::createFromFormat('Y-m', date('Y') . '-' . $request->month);
                $report->whereYear('login_date', $date->year)
                    ->whereMonth('login_date', $date->month);
            } else if (!$request->month && !$request->start_date && !$request->end_date) {
                // Fetch reports for the past 3 months(inclusive first one, therefore subtracting 2)
                $report->where('login_date', '>=', Carbon::now()->subMonths(2));
            } else if ($request->start_date && $request->end_date) {
                // Fetch reports between start_date and end_date
                $report->whereBetween('login_date', [$request->start_date, $request->end_date]);
            }
    
            $reports = $report->get();
            return response()->json(['success'=>true,'data'=>$reports]);
        }
        
        return response()->json(['success'=>false,'data'=>[]]);

    }
}
