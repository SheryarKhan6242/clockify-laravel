<?php
namespace App\Services;

use App\Models\Leave;
use Carbon\Carbon;

class LeaveService
{
    public function leaveRequests($type)
    {
        //Pending Requests
        if($type)
        {
            $requests = Leave::where('status','Pending')->where('leave_type_id',$type)->get();
        } else {
            $requests = Leave::where('status','Pending')->get();

        }
        return $requests;
    }
}
