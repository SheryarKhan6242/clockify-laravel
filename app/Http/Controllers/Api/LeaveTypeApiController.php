<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeApiController extends Controller
{
    //
    public function getLeaveType()
    {
        $types = LeaveType::all();
        return response()->json($types);
    }
}
