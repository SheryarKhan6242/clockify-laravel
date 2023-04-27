<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CheckinType;

class CheckInTypeController extends Controller
{
    public function getCheckInTypes()
    {
        $types = CheckinType::all();
        return response()->json($types);
    }
}
