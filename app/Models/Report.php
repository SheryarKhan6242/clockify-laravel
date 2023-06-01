<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
