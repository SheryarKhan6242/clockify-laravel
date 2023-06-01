<?php
namespace App\Services;

use App\Models\Report;
use App\Models\Leave;
use Carbon\Carbon;

class ReportService
{

    public function validateRequest($request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(['success' => false, 'errors' => $errors]);
        }
        // Validation passed
        return null; 
    }

    // Your service methods and logic

    public function fetchReports($request)
    {
        $report = Report::where('user_id', $request->user_id);
        
        if ($report->count() > 0) {

            $filterReports = $this->filterReports($request,$report);

            $reports = $filterReports->with('checkinType')->get();

            // Group reports by login date
            $groupedReports = $reports->groupBy('login_date');

            // Format the grouped reports
            $formattedReports = $this->formatReports($groupedReports);

            // Calculate the summary
            $summary = $this->calculateSummary($request->user_id,$groupedReports);
            
            return ['reports' => $formattedReports, 'summary' => $summary];
        }
        return false;
    }

    //Filter the reports by User Id, Start Date-End-Date, Month
    public function filterReports($request,$report)
    {
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
        return $report;
    }

    //Format the grouped reports.
    public function formatReports($groupedReports)
    {
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

        return $updatedReports;
    }

    public function calculateSummary($userId,$groupedReports)
    {
        $totalWorkingDays = $groupedReports->count();
        // Get the starting and ending login_date months from the reports
        $startDate = Carbon::parse($groupedReports->first()->first()->login_date)->startOfMonth();
        $endDate = Carbon::parse($groupedReports->last()->first()->login_date)->endOfMonth();
        // Calculate the total working days excluding weekends
        $totalWorkingDays = 0;
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            if (!$currentDate->isWeekend()) {
                $totalWorkingDays++;
            }
            $currentDate->addDay();
        }

        //Calculate total working hours
        $totalWorkingHours = $groupedReports->sum(function ($group) {
            $firstReport = $group->first();
            $officeIn = Carbon::parse($firstReport->office_in);
            $officeOut = Carbon::parse($firstReport->office_out);
            return $officeOut->diffInHours($officeIn);

        });
        
        //Get Approved Leaves
        $leaves = $this->getApprovedLeaves($userId,$startDate,$endDate);
    
        // Calculate the total absents excluding approved leaves
        $totalAbsents = $totalWorkingDays - $leaves - count($groupedReports);

        $summary = [
            'total_working_days' => $totalWorkingDays,
            'total_working_hours' => $totalWorkingHours,
            'total_absents' => $totalAbsents,
            'total_presents' => count($groupedReports),
            'total_approved_leaves' => $leaves,
        ];

        return $summary;
    }


    public function getApprovedLeaves($userId,$startDate,$endDate)
    {
        // Calculate the total approved leaves within the same month range as the reports
        $leaves = Leave::where('user_id', $userId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->where('status', 'approved')
            ->count();

        return $leaves;
    }

}
