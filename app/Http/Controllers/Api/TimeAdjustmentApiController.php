<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TimeAdjustment;
use App\Models\TimeAdjustmentDetail;
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
            'checkin_id' => 'required'
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
            $adjustment->adj_reason = $request->adj_reason;
            $adjustment->report_id = isset($request->report_id) ? $request->report_id : null;
            $adjustment->wfh_reason = isset($request->wfh_reason) ? $request->wfh_reason : null;
            $adjustment->status = 'Pending';
            $adjustment->save();

            //Store Office in, Office out in details.
            $timeAdjustmentDetails = [];
            //Convert values to array
            $officeIn = explode(",",$request->office_in);
            $officeOut = explode(",",$request->office_out);
            $checkinId = explode(",",$request->checkin_id);

            // Check if the office_in and office_out values are arrays
            // dd($officeIn);
            if (is_array($officeIn) && is_array($officeOut) && count($officeIn) === count($officeOut)) {
                for ($i = 0; $i < count($officeIn); $i++) {
                    $timeAdjustmentDetail = new TimeAdjustmentDetail();
                    $timeAdjustmentDetail->time_adj_id = $adjustment->id;
                    $timeAdjustmentDetail->office_in = $officeIn[$i];
                    $timeAdjustmentDetail->office_out = $officeOut[$i];
                    $timeAdjustmentDetail->checkin_id = $checkinId[$i];
                    $timeAdjustmentDetail->save();
                }
            }
            
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
        
        try {
            $timeAdjustments = TimeAdjustment::with('adjustmentDetails')->where('user_id', $id)->get();
            
            if($timeAdjustments->count() <=0)
                return response()->json(['success' => false, 'message' => 'Time Adjustment for this user does not exist!']);

            $response = [];
            foreach ($timeAdjustments as $timeAdjustment) {
                $payload = [
                    'id' => $timeAdjustment->id,
                    'user_id' => $timeAdjustment->user_id,
                    'adj_date' => $timeAdjustment->adj_date,
                    'report_id' => $timeAdjustment->report_id,
                    'adj_reason' => $timeAdjustment->adj_reason,
                    'wfh_reason' => $timeAdjustment->wfh_reason,
                    'status' => $timeAdjustment->status,
                ];
            
                if ($timeAdjustment->adjustmentDetails->count() > 0) {
                    $adjustmentDetails = $timeAdjustment->adjustmentDetails->all();
                    $adjustmentDetailsPayload = [];
            
                    foreach ($adjustmentDetails as $detail) {
                        $adjustmentDetailsPayload[] = [
                            'id' => $detail->id,
                            'checkin_id' => $detail->checkin_id,
                            'office_in' => $detail->office_in,
                            'office_out' => $detail->office_out,
                        ];
                    }

                    $payload['adjustment_details'] = $adjustmentDetailsPayload;
                }

                $response[] = $payload;
            }
            return response()->json(['success' => true, 'data' => $response]);
    
        } catch (\Throwable $th) {
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
        }
        

    }
}


// "time_adjustment_id" : 4
// "user_id": 30
// 'adj_date": some date
// "report_id": 1
// "checkin_id": 1
// "adj_reason": some reason
// wfh_reason": null
// "status": "Pending"
// "adjustment_details": {
//     "office_in": { 
//         "id": 1
//         "01:00:00",
//         "03:00:00"
//     },
//     "office_out": {
//         "02:00:00",
//         "04:00:00"
//     }
// }