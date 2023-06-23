<?php
namespace App\Services;

use App\Models\TimeAdjustment;
use Carbon\Carbon;

class TimeAdjustmentService
{
    public function timeAdjustmentRequests($status = 'Pending',$filter = '1',$startDate = null, $endDate = null)
    {
        // If Not filtered by date(fetch by weekly or monthly)
        if($startDate == null && $endDate == null)
        {
            //Fetch Weekly
            $endDate = Carbon::now()->format('Y-m-d');      
            // $startDate = Carbon::now()->subWeek()->format('Y-m-d');
            $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
            // Fetch Monthly
            if ($filter == '2')
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        //Get Request based on Status(Approved,Pending, Rejected)
        if($status && $status != null)
        {
            $requests = TimeAdjustment::where('status',$status)
                ->where('adj_date','>=' ,$startDate)
                ->where('adj_date','<=',$endDate)
                ->get();
        } else 
        {
            $requests = TimeAdjustment::where('adj_date','>=' ,$startDate)
                ->where('adj_date','<=',$endDate)
                ->get();
        }
        return $requests;
    }
}
