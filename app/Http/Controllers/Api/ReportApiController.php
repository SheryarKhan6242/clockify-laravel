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

            
            $reports = $report->with('checkinType')->get();

            $mergedReports = [];

            foreach ($reports as $report) {
                $loginDate = Carbon::createFromFormat('Y-m-d', $report->login_date)->format('Y-m-d');

                if (!isset($mergedReports[$loginDate])) {
                    // Create a new entry for the login date
                    $mergedReports[$loginDate] = $report->toArray();
                    $mergedReports[$loginDate]['other_reports'] = [];
                } else {
                    // Add the current report to the existing login date entry
                    $otherReport = [
                        'id' => $report->id,
                        'office_in' => $report->office_in,
                        'office_out' => $report->office_out,
                        'total_work_hours' => $report->total_work_hours,
                        'checkin_type' => $report->checkinType ? $report->checkinType->type : null,
                    ];
                    $mergedReports[$loginDate]['other_reports'][] = $otherReport;
                }
            }

            // Convert mergedReports back into Report models
            $updatedReports = collect($mergedReports)->map(function ($reportData) {
                $report = Report::make($reportData);
                $report->checkin_type = $reportData['checkin_type'];
                unset($report->checkinType);
                unset($report->checkin_id);
                return $report;
            });

            $responseData = ['success' => true,'data' => $updatedReports];

            return response()->json($responseData);
        }

        return response()->json(['success'=>false,'data'=>[], 'message' => 'Report for this User does not exist!']);
    }
}
