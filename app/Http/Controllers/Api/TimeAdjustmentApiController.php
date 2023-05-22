<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TimeAdjustment;
use App\Models\Report;


class TimeAdjustmentApiController extends Controller
{
    //
    public function addTimeAdjustmentRequest(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'adj_date' => 'required|date_format:Y-m-d',
            'office_in' => 'required',
            'office_out' => 'required',
            'adj_reason' => 'required|min:8',
            'checkin_id' => 'required|integer'
        ]);

        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        try {
            $adjustment = new TimeAdjustment();
            $adjustment->user_id = $request->user_id;
            $adjustment->adj_date = $request->adj_date;
            $adjustment->office_in = $request->office_in;
            $adjustment->office_out = $request->office_out;
            $adjustment->checkin_id = $request->checkin_id;
            $adjustment->adj_reason = $request->adj_reason;
            $adjustment->report_id = isset($request->report_id) ? $request->report_id : null;
            $adjustment->wfh_reason = isset($request->wfh_reason) ? $request->wfh_reason : null;
            $adjustment->status = 'Pending';
            $adjustment->save();
            
            return response()->json(['success' => true, 'message' => 'Time Adjustment Added Successfully!']);
        } catch (\Throwable $th) {
            // Return the error response
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
        }        
    }

    public function getTimeAdjustmentRequests($id)
    {
        $requests = TimeAdjustment::where('user_id',$id)->get();
        if($requests->count() > 0)
            return response()->json(['success'=>true,'data'=>$requests]);
        
        return response()->json(['success'=>false,'message'=>'No Time Adjustment request submitted.']);
    }
}
