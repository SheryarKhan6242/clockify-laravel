<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $report = Report::where('user_id', $request->user_id);

        if ($report->count() > 0) {
            if (!$request->start_date && !$request->end_date && $request->month) {
                // Fetch reports for the given month and year
                $date = Carbon::createFromFormat('Y-m', date('Y') . '-' . $request->month);
                $report->whereYear('login_date', $date->year)
                    ->whereMonth('login_date', $date->month);
            } else if (!$request->month && !$request->start_date && !$request->end_date) {
                // Fetch reports for the past 3 months (inclusive first one, therefore subtracting 2)
                $report->where('login_date', '>=', Carbon::now()->subMonths(2));
            } else if ($request->start_date && $request->end_date) {
                // Fetch reports between start_date and end_date
                $report->whereBetween('login_date', [$request->start_date, $request->end_date]);
            }
            
            $report = Report::where('user_id', $request->user_id);

        if ($report->count() > 0) {
            if (!$request->start_date && !$request->end_date && $request->month) {
                // Fetch reports for the given month and year
                $date = Carbon::createFromFormat('Y-m', date('Y') . '-' . $request->month);
                $report->whereYear('login_date', $date->year)
                    ->whereMonth('login_date', $date->month);
            } else if (!$request->month && !$request->start_date && !$request->end_date) {
                // Fetch reports for the past 3 months (inclusive first one, therefore subtracting 2)
                $report->where('login_date', '>=', Carbon::now()->subMonths(2));
            } else if ($request->start_date && $request->end_date) {
                // Fetch reports between start_date and end_date
                $report->whereBetween('login_date', [$request->start_date, $request->end_date]);
            }

            //Original Reports.
            // $reports = $report->with('checkinType')->get();

            // // Update reports to include the checkin type name
            // $updatedReports = $reports->map(function ($report) {
            //     $checkinTypeName = $report->checkinType ? $report->checkinType->type : null;
            //     $report->checkin_type = $checkinTypeName;
            //     unset($report->checkinType);
            //     unset($report->checkin_id);
            //     return $report;
            // });

            // return response()->json(['success' => true, 'data' => $updatedReports]);
            
            // $reports = $report->with('checkinType')->get();
            // $reports = $report->with('checkinType')->get();
            // // Group reports by login date
            // $groupedReports = $reports->groupBy('login_date');

            // // Format the grouped reports
            // $updatedReports = $groupedReports->flatMap(function ($group) {
            //     $firstReport = $group->first();
            //     $checkinTypeName = $firstReport->checkinType ? $firstReport->checkinType->type : null;
            //     $formattedReports = $group->slice(1)->map(function ($report) {
            //         return [
            //             'id' => $report->id,
            //             'office_in' => $report->office_in,
            //             'office_out' => $report->office_out,
            //             'total_work_hours' => $report->total_work_hours,
            //             'checkin_type' => $report->checkinType ? $report->checkinType->type : null,
            //         ];
            //     });
                

            //     return [
            //         'id' => $firstReport->id,
            //         'user_id' => $firstReport->user_id,
            //         'office_in' => $firstReport->office_in,
            //         'office_out' => $firstReport->office_out,
            //         'is_late' => $firstReport->is_late,
            //         'late_reason' => $firstReport->late_reason,
            //         'wfh_reason' => $firstReport->wfh_reason,
            //         'total_work_hours' => $firstReport->total_work_hours,
            //         'login_date' => $firstReport->login_date,
            //         'shift_id' => $firstReport->shift_id,
            //         'clockin_location' => $firstReport->clockin_location,
            //         'login_user_ip' => $firstReport->login_user_ip,
            //         'created_at' => $firstReport->created_at,
            //         'updated_at' => $firstReport->updated_at,
            //         'checkin_type' => $checkinTypeName,
            //         'other_reports' => $formattedReports->values(),
            //     ];
            // });

            // return response()->json(['success' => true, 'data' => $updatedReports]);

            $reports = $report->with('checkinType')->get();
            // Group reports by login date
            $groupedReports = $reports->groupBy('login_date');
            
            // Format the grouped reports
            $updatedReports = $groupedReports->map(function ($group) {
                $firstReport = $group->first();
                $checkinTypeName = $firstReport->checkinType ? $firstReport->checkinType->type : null;
                $formattedReports = $group->slice(1)->map(function ($report) {
                    return [
                        'id' => $report->id,
                        'office_in' => $report->office_in,
                        'office_out' => $report->office_out,
                        'total_work_hours' => $report->total_work_hours,
                        'checkin_type' => $report->checkinType ? $report->checkinType->type : null,
                    ];
                });
            
                return [
                    'id' => $firstReport->id,
                    'user_id' => $firstReport->user_id,
                    'office_in' => $firstReport->office_in,
                    'office_out' => $firstReport->office_out,
                    'is_late' => $firstReport->is_late,
                    'late_reason' => $firstReport->late_reason,
                    'wfh_reason' => $firstReport->wfh_reason,
                    'total_work_hours' => $firstReport->total_work_hours,
                    'login_date' => $firstReport->login_date,
                    'shift_id' => $firstReport->shift_id,
                    'clockin_location' => $firstReport->clockin_location,
                    'login_user_ip' => $firstReport->login_user_ip,
                    'created_at' => $firstReport->created_at,
                    'updated_at' => $firstReport->updated_at,
                    'checkin_type' => $checkinTypeName,
                    'other_reports' => $formattedReports->values(),
                ];
            })->values();
            
            return response()->json(['success' => true, 'data' => $updatedReports]);
            

        }        
    }
        return response()->json(['success'=>false,'data'=>[], 'message' => 'Report for this User does not exist!']);
    }
}
