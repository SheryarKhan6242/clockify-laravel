<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\AllowanceType;
use App\Models\Allowance;
use Carbon\Carbon;

class AllowanceApiController extends Controller
{
    //
    public function addAllowanceRequest(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'allowance_date' => 'required|date_format:Y-m-d',
            'approver_id' => 'required|integer',
            'allowance_id' => 'required|integer',
            'description' => 'required|min:8',
        ]);

        if($validator->fails())
        {
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        // dd($request->all());

        $allowanceType = AllowanceType::find($request->allowance_id);
        //If Allowance Type doesn't have that type in DB
        if(!$allowanceType)
            return response()->json(['success' => false, 'message' => 'Allowance type does not exist!']);
            
        if($allowanceType->type == 'sunday' || $allowanceType->type == 'Sunday')
        {
            //Add necessary validation for Sunday Allowance
            $validator = \Validator::make($request->all(), [
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

            try {    
                $allowance = new Allowance();
                $allowance->user_id = $request->user_id;
                $allowance->allowance_date = $request->allowance_date;
                // dd(Carbon::createFromFormat('d-m-Y', $request->allowance_date)->format('Y-m-d'));
                $allowance->allowance_id = $request->allowance_id;
                $allowance->approver_id = $request->approver_id;
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
        } else if($allowanceType->type == 'Medical' 
            || $allowanceType->type == 'Medical'
            || $allowanceType->type == 'General'
            || $allowanceType->type == 'general'
            )
        {
            $validator = \Validator::make($request->all(),[
                'receipt_id' => 'required',
                'amount' => 'required',
                'attachment' => 'required'
            ]);
    
            if($validator->fails())
            {
                $errors = $validator->errors()->toArray();
                return response()->json(['success'=>false,'errors'=>$errors]);
            }
            try {            
                $allowance = new Allowance();
                $allowance->user_id = $request->user_id;
                $allowance->allowance_id     = $request->allowance_id;
                $allowance->allowance_date = $request->allowance_date;
                $allowance->approver_id = $request->approver_id;
                $allowance->allowance_date = $request->allowance_date;
                $allowance->description = $request->description;
                $allowance->amount = $request->amount;
                $allowance->receipt_id = $request->receipt_id;
                $allowance->status = 'Pending';
                //Upload Attachment
                // if(isset($request->attachment))
                // {
                //     $contents = file_get_contents($request->attachment);
                //     $name = substr($request->attachment, strrpos($request->attachment, '/') + 1);
                //     $filepath = 'uploads/' . $name;
                //     $path = Storage::disk('public')->put($filepath, $contents);
                //     $path = Storage::disk('public')->url($path);
                //     $allowance->attachment = $name;
                //     Storage::put($name, $contents);
                // }
                //Upload Attachment
                $allowance->save();
                
                return response()->json(['success' => true, 'message' => $allowanceType->type .' Allowance Submitted Successfully!']);
            } catch (\Throwable $th) {
                // Return the error response
                if (env('APP_ENV') === 'local') {
                    return response()->json(['success' => false, 'message' => $th->getMessage()]);
                }
                Log::error($th);
                return response()->json(['success' => false, 'message' => 'Error Submitting' . $allowanceType->type . ' Allowance!']);
            }

        }
    }

    public function getUserAllowance($userId = null, $checkinId = null)
    {
        $allowance = Allowance::where('user_id',$userId)->where('allowance_id',$checkinId)->get();
        if($allowance->count() > 0){
            $approvedAllowance = 0;
            foreach($allowance as $value)
            {
                if($value->status == "Approved" || $value->status == "approved")
                {
                    $approvedAllowance+=1;
                }
            }
            
            $totalAllowanceSubmitted = $allowance->count();
            return response()->json(['success' => true,
                'allowance' => $allowance,
                'total_submitted_allowance' => $totalAllowanceSubmitted,
                'approved_allowance' => $approvedAllowance
                ]);
        }
            
        
        return response()->json(['success'=>false,'message'=>'No Allowance request submitted.']);
    }
}
