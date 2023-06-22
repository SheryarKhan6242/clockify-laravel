<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllowanceType;

class AllowanceTypeApiController extends Controller
{
    //

    // 1 => Sunday, 2 => General, 3 => Medical
    public function getAllowanceType()
    {
        $types = AllowanceType::all();
        return response()->json($types);
    }
}
