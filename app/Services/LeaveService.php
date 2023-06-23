<?php
namespace App\Services;

use App\Models\Leave;
use App\Models\Employee;
use Carbon\Carbon;

class LeaveService
{
    //Returns the Leaves request by type and Status
    //Filter: 1 => weekly,  2 => monthly
    public function leaveRequests($type = null, $status = 'Pending',$filter = '1',$startDate = null, $endDate = null)
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

        //Pending Requests
        if(isset($type) && $type != null)
        {
            $requests = Leave::where('status',$status)
                ->where('start_date','>=' ,$startDate)
                ->where('end_date','<=',$endDate)
                ->where('leave_type_id',$type)
                ->get();
        } else {
            $requests = Leave::where('status',$status)
                ->where('start_date','>=' ,$startDate)
                ->where('end_date','<=',$endDate)
                ->get();
        }
        return $requests;
    }

    //The service returns Availed(Annual, Sick, Casual leaves) and remaining leaves.
    //1 => Annual, 2 => Sick, 3 => Casual, 4 => Half Day 
    public function getAvailableLeaves($id)
    {
        #################AVAILED LEAVES###################
        //Get Annual Availed Leaves
        $currentYear = Carbon::now()->year;
        $startDate = "{$currentYear}-01-01";
        $endDate = "{$currentYear}-12-31";

        $availedAnnual = Leave::where('user_id',$id)
            ->where([
                ['start_date', '>=', $startDate],
                ['end_date', '<=', $endDate]
            ])
            ->where('leave_type_id',1)
            ->where('status','Approved')    
            ->count();
        //Get Availed Sick Leaves Annually
        $availedSick = Leave::where('user_id',$id)
            ->where([
                ['start_date', '>=', $startDate],
                ['end_date', '<=', $endDate]
            ])
            ->where('leave_type_id',2)
            ->where('status','Approved')    
            ->count();
        

            $availedCasual = Leave::where('user_id',$id)
            ->where([
                ['start_date', '>=', $startDate],
                ['end_date', '<=', $endDate]
            ])
            ->where('leave_type_id',3)
            ->where('status','Approved')    
            ->count();

            $availedHalfDay = Leave::where('user_id',$id)
            ->where([
                ['start_date', '>=', $startDate],
                ['end_date', '<=', $endDate]
            ])
            ->where('leave_type_id',4)
            ->where('status','Approved')    
            ->count();
            
            
        //#################AVAILED LEAVES###################


        //#################REMANING LEAVES###################
        //Set default to 0 incase quota not set.
        $remainingAnnual = 0;
        $remainingSick = 0;
        $remainingCasual = 0;
        $remainingHalfDay = 0;
        $leavesPayload = Employee::where('user_id',$id)->pluck('leaves_payload')->first();
        $decoded = json_decode($leavesPayload); 
        // dd($decoded);
        //Check if Leaves Quota has been added or not.
        if($decoded !=null)
        {
            //Remaining Annual
            if(isset($decoded[0]) && $decoded[0]->leave_type !==null )
            {
                $allowedAnnual = $decoded[0]->nol;
                $remainingAnnual = $allowedAnnual - $availedAnnual;
            }
            // Remaining Sick
            if(isset($decoded[1]) && $decoded[1]->leave_type !==null )
            {
                $allowedSick = $decoded[1]->nol;
                $remainingSick = $allowedSick - $availedSick;
            }

            // Remaining Casual
            if(isset($decoded[2]) && $decoded[2]->leave_type !==null )
            {
                $allowedCasual = $decoded[2]->nol;
                $remainingCasual = $allowedCasual - $availedCasual;
            }

            // Remaining Half Day
            if(isset($decoded[3]) && $decoded[3]->leave_type !==null)
            {
                $allowedHalfDay = $decoded[3]->nol;
                $remainingHalfDay = $allowedHalfDay - $availedHalfDay;
                
            }
        }

        $data['availed_sick'] = $availedSick;
        $data['remaining_sick'] = $remainingSick;
        $data['availed_annual'] = $availedAnnual;
        $data['remaining_annual'] = $remainingAnnual;
        $data['availed_casual'] = $availedCasual;
        $data['remaining_casual'] = $remainingCasual;
        $data['availed_half_day'] = $availedHalfDay;
        $data['remaining_half_day'] = $remainingHalfDay;

        return $data;
    }
}
