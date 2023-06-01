<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllowanceType;
use App\Models\Allowance;
use App\Models\Report;
use Carbon\Carbon;

class SundayAllowanceApiController extends Controller
{
    public function addRequest(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'allowance_date' => 'required|date_format:Y-m-d',
            'approver_id' => 'required|integer',
            'allowance_id' => 'required|integer',
            'description' => 'required|min:8',
            'time_in' => 'required|regex:/^\d{1,2}:\d{2}:\d{2}$/',
            'time_out' => 'required|regex:/^\d{1,2}:\d{2}:\d{2}$/',
        ], [
            'time_in.regex' => 'The time_in must be in the format H:m:s.',
            'time_out.regex' => 'The time_out must be in the format H:m:s.',
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        $allowanceType = AllowanceType::find($request->allowance_id);
        //If Allowance Type doesn't have that type in DB
        if(!$allowanceType)
            return response()->json(['success' => false, 'message' => 'Allowance type does not exist!']);
        
        try {    
            $allowance = new Allowance();
            $allowance->user_id = $request->user_id;
            $allowance->allowance_date = $request->allowance_date;
            // dd(Carbon::createFromFormat('d-m-Y', $request->allowance_date)->format('Y-m-d'));
            $allowance->allowance_id = $request->allowance_id;
            //Get lead_id of user_id and send email. Fetch hr_manager role user and send email

            //
            $allowance->allowance_date = $request->allowance_date;
            $allowance->description = $request->description;
            $allowance->time_in = $request->time_in;
            $allowance->time_out = $request->time_out;
            $allowance->status = 'Pending';
            $allowance->save();

            return response()->json(['success' => true, 'message' => 'Sunday Allowance Submitted Successfully!']);
    
        } catch (\Throwable $th) {
            // Return the error response
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function getAllowanceRecord($userId)
    {
        $allowanceDate = request()->query('allowance_date');
    
        $dateRegex = '/^\d{4}-\d{2}-\d{2}$/';
        if ($allowanceDate == null || !preg_match($dateRegex, $allowanceDate))
            abort(404);
    
        $allowance = Report::where('user_id', $userId)
            ->where('login_date', Carbon::parse($allowanceDate)->format('Y-m-d'))
            ->get();
    
        if ($allowance->count() <=0) {
            return response()->json(['success' => false, 'message' => 'No Allowance Request Submitted.']);
        }
    
        return response()->json(['success' => true, 'data' => $allowance]);               
    }
}
