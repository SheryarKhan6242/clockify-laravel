<?php
namespace App\Services;

use App\Models\WorkFromHome;
use Carbon\Carbon;

class WfhService
{
    //Default Fetches Weekly Report, If Monthly filter passed, fetches by month
    public function wfhRequests($status = 'Pending', $filter = '1',$startDate = null, $endDate = null)
    {
        // If Not filtered by date(fetch by weekly or monthly)
        if($startDate == null && $endDate == null)
        {
            //Fetch Weekly
            $endDate = Carbon::now()->format('Y-m-d');      
            $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');           
            // Fetch Monthly
            if ($filter == '2')
                $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        //Status of Requests. Approved,Pending, Rejected
        // dd($startDate);
        if($status && $status != null)
        {
            $requests = WorkFromHome::where('status',$status)
                ->where('start_date','>=' ,$startDate)
                ->where('end_date','<=',$endDate)
                ->get();
        } else 
        {
            $requests = WorkFromHome::where('start_date','>=' ,$startDate)
                ->where('end_date','<=',$endDate)
                ->get();
        }
        // dd($requests);
        return $requests;
    }
}
