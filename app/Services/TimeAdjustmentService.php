<?php
namespace App\Services;

use App\Models\TimeAdjustment;
use Carbon\Carbon;

class TimeAdjustmentService
{
    public function timeAdjustmentRequests()
    {
        //Pending Requests
        $requests = TimeAdjustment::where('status','Pending')->get();
        return $requests;
    }
}
