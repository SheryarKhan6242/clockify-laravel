<?php
namespace App\Services;

use App\Models\WorkFromHome;
use Carbon\Carbon;

class WfhService
{
    public function wfhRequests()
    {
        //Pending Requests
        $requests = WorkFromHome::where('status','Pending')->get();
        return $requests;
    }
}
