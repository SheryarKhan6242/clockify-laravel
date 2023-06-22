<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Report extends Model
{
    use HasFactory;
    
    protected $guarded = [];  

    public function userName()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkinType()
    {
        return $this->belongsTo(CheckinType::class,'checkin_id');
    }

    public function fetchWeeklyHrs($userId)
    {
        $endDate = Carbon::now()->format('Y-m-d');
        $startDate = Carbon::now()->subWeek()->format('Y-m-d');    
        // dd($startDate);  
        // Fetch the records from the database within the specified date range
        // dd($endDate);
        // $weeklyHrs = Report::where('user_id',$userId)
        //     ->where('login_date','>=' ,$startDate)
        //     ->where('login_date','<',$endDate)
        //     ->selectRaw('SUM(total_work_hours) as weekly_hours')
        //     ->groupBy('user_id')
        //     ->first();
        $weeklyHrs = Report::where('user_id', $userId)
        ->where('login_date', '>=', $startDate)
        ->where('login_date', '<', $endDate)
        ->selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(total_work_hours))) AS weekly_hours')    
        ->groupBy('user_id')
        ->first();
    
        $totalWorkHoursFormatted = 0;
        if ($weeklyHrs) {
            $hours = substr($weeklyHrs->weekly_hours, 0, 2); 
            $minutes = substr($weeklyHrs->weekly_hours, 3, 2);
            $totalWorkHoursFormatted = $hours . ':' . $minutes;
        }

        return $totalWorkHoursFormatted;
    }

    public static function fetchReports($userId, $month = null, $startDate = null, $endDate = null)
    {
        $query = Report::with(['user', 'checkinType'])
        ->where('user_id', $userId)
        ->where(function ($query) use ($month, $startDate, $endDate) {
            if ($month) {
                $query->whereRaw('MONTH(login_date) = ?', [$month]);
            }

            if ($startDate && $endDate) {
                $query->whereBetween('login_date', [$startDate, $endDate]);
            }

            $query->whereNull('month')
                ->orWhereNull('start_date')
                ->orWhereNull('end_date');
        })
        ->orderBy('login_date')
        ->get();

        $reports = $query->toArray();

        $reports = array_map(function ($report) use ($reports) {
            $sameDateReports = array_filter($reports, function ($r) use ($report) {
                return $r['login_date'] === $report['login_date'];
            });

            $otherReports = array_values(array_diff_key($sameDateReports, [$report['id'] => '']));

            if (!empty($otherReports)) {
                $report['other_reports'] = $otherReports;
            }

            return $report;
        }, $reports);

        $summary = [
            'total_working_days' => count($reports),
            'total_working_hours' => '00:00:00',
            'total_absent_days' => 0,
            'total_present_days' => 0,
            'total_approved_leaves' => Leave::where('user_id', $userId)->where('status', 'approved')->count(),
        ];

        foreach ($reports as $report) {
            if ($report['total_work_hours']) {
                $hours = explode(':', $report['total_work_hours']);
                $summary['total_working_hours'] += ($hours[0] * 60) + $hours[1];
            }

            if ($report['checkin_type']['name'] === 'office') {
                $summary['total_present_days']++;
            }
        }

        $summary['total_working_hours'] = gmdate('H:i:s', $summary['total_working_hours'] * 60);

        return [
            'success' => true,
            'data' => $reports,
            'summary' => $summary,
        ];
    }
}
