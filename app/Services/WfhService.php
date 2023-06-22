<?php
namespace App\Services;

use App\Models\WorkFromHome;
use Carbon\Carbon;

class WfhService
{
    //Default Fetches Weekly Report, If Monthly filter passed, fetches by month
    public function wfhRequests($type = 'Pending', $filter = '1')
    {
        $endDate = Carbon::now()->format('Y-m-d');      
        $startDate = Carbon::now()->subWeek()->format('Y-m-d');   
        // Fetch for month
        if ($filter == '2')
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        //Type of Requests. Approved,Pending, Rejected
        // dd($startDate);
        if($type)
        {
            $requests = WorkFromHome::where('status',$type)
                ->where('start_date','>=' ,$startDate)
                ->where('end_date','<=',$endDate)
                ->get();
        } else 
        {
            $requests = WorkFromHome::where('status','Pending')
                ->where('start_date','>=' ,$startDate)
                ->where('end_date','<=',$endDate)
                ->get();
        }
        // dd($requests);
        return $requests;
    }
}
