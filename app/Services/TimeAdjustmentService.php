<?php
namespace App\Services;

use App\Models\TimeAdjustment;
use Carbon\Carbon;

class TimeAdjustmentService
{
    public function timeAdjustmentRequests($type = 'Pending', $filter = '1')
    {

        $endDate = Carbon::now()->format('Y-m-d');      
        $startDate = Carbon::now()->subWeek()->format('Y-m-d');   
        // Fetch for month
        if ($filter == '2')
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        //Type of Requests. Approved,Pending, Rejected
        if($type)
        {
            $requests = TimeAdjustment::where('status',$type)
                ->where('adj_date','>=' ,$startDate)
                ->where('adj_date','<=',$endDate)
                ->get();
        } else 
        {
            $requests = TimeAdjustment::where('status','Pending')
                ->where('adj_date','>=' ,$startDate)
                ->where('adj_date','<=',$endDate)
                ->get();
        }
        return $requests;
    }
}
