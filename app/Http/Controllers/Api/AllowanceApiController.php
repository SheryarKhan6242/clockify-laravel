<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\AllowanceType;
use App\Models\Allowance;
use App\Models\User;
use Carbon\Carbon;

class AllowanceApiController extends Controller
{
    //
    public function addAllowanceRequest(Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'user_id' => 'required|integer',
            'allowance_id' => 'required|integer',
            'allowance_date' => 'required|date_format:Y-m-d',
            'receipt_id' => 'required',
            'description' => 'required|min:8',
            'amount' => 'required'
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

        try {            
            $allowance = new Allowance();
            $allowance->user_id = $request->user_id;
            $allowance->allowance_id     = $request->allowance_id;
            $allowance->allowance_date = $request->allowance_date;
            $allowance->approver_id = null;
            $allowance->description = $request->description;
            $allowance->amount = $request->amount;
            $allowance->receipt_id = $request->receipt_id;
            $allowance->status = 'Pending';
            //Upload image from URL to Laravel storage
            if ($request->hasFile('attachment')) {
                $avatar = $request->file('attachment');
                $fileName = time() . '_' . $avatar->getClientOriginalName();
                $filepath = 'uploads/' . $fileName;
                $path = Storage::disk('public')->put($filepath, file_get_contents($request->file('attachment')));
                $path = Storage::disk('public')->url($path);
                $allowance->attachment = $fileName;
            }
            // Upload Attachment
            $allowance->save();
            
            return response()->json(['success' => true, 'message' => $allowanceType->type .' Allowance Submitted Successfully!']);
        } catch (\Throwable $th) {
            // Return the error response
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'Error Submitting ' . $allowanceType->type . ' Allowance!']);
        }
    }

    public function getUserAllowance($id = null)
    {
        if($id){
            $user = User::find($id);
            if(!$user)
                return response()->json(['success'=>false,'message'=>'User does not exist.']);
        }

        $Allowance = Allowance::where('user_id',$id)->get();

        $sundayAllowance = Allowance::where('user_id',$id)->where('allowance_id',1)->get();
        $generalAllowance = Allowance::where('user_id',$id)->where('allowance_id',2)->get();
        $medicalAllowance = Allowance::where('user_id',$id)->where('allowance_id',5)->get();
        $response = [
            'sunday' => $sundayAllowance,
            'general' => $generalAllowance,
            'medical' => $medicalAllowance
        ];

        return response()->json(['success' => true,'data' => $response]);
            // $approvedAllowance = 0;
            // foreach($allowance as $value)
            // {
            //     if($value->status == "Approved" || $value->status == "approved")
            //     {
            //         $approvedAllowance+=1;
            //     }
            // }
            
            // $totalAllowanceSubmitted = $allowance->count();
            // return response()->json(['success' => true,
            //     'allowance' => $allowance,
            //     'total_submitted_allowance' => $totalAllowanceSubmitted,
            //     'approved_allowance' => $approvedAllowance
            //     ]);       
    }
}
