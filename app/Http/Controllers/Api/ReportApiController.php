<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\ReportService;

class ReportApiController extends Controller
{
    
    public function getReport(Request $request, ReportService $reportService)
    {
        $validationError = $reportService->validateRequest($request);
        if ($validationError !== null)
            return $validationError;

        $result = $reportService->fetchReports($request);
        
        if($result)
            return response()->json(['success' => true, 'data' => $result['reports'], 'summary' => $result['summary']]);
        
        return response()->json(['success'=>false,'data'=>[], 'message' => 'Report for this User does not exist!']);
    }
}
