<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\LeaveService;
use App\Models\Leave;
use App\Models\User;
use App\Jobs\GetEmailTemplates;
use Carbon\Carbon;

class LeaveRequestApiController extends Controller
{
    //

    public function addLeaveRequest(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'leave_type' => 'required|integer',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y',
            'subject' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        $user = User::find($request->user_id);
        if(!$user)
            return response()->json(['success' => false, 'message' => 'User does not exist!']);

        try {
            //code...\
            $leave = new Leave();
            $leave->user_id = $request->user_id;
            $leave->leave_type_id = $request->leave_type;
            $leave->subject = $request->subject;
            $leave->description = $request->description;
            
            $leave->start_date = Carbon::parse($request->start_date);
            $leave->end_date = Carbon::parse($request->end_date);
            $leave->status = 'Pending';
            $leave->approval_id = null;

            //Upload image from URL to Laravel storage
            if ($request->hasFile('media')) {
                $avatar = $request->file('media');
                $fileName = time() . '_' . $avatar->getClientOriginalName();
                $filepath = 'uploads/' . $fileName;
                $path = Storage::disk('public')->put($filepath, file_get_contents($request->file('media')));
                $path = Storage::disk('public')->url($path);
                $leave->media = $fileName;
            }
            $leave->save();

            //Prepare Leave Request queue job for HR and Admin
            $templateName = 'leave_request';
            $placeholders = ['[admin]','[username]','[start_date]','[end_date]'];
            //Fetch the Dynamic Admin name here.
            $admin = "Admin";
            //Fetch user
            $user = User::find($request->user_id);
            $values = [$admin,$user->name,$request->start_date,$request->end_date];
            //Dispatch queue job
            GetEmailTemplates::dispatch($user, $templateName, $placeholders, $values);

            return response()->json(['success'=>true,'message'=>'Leave Request Submitted Successfully!']);
        } catch (\Throwable $th) {
            // Return the error response
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function getUserLeavesRequests(Request $request)
    {
        
        $leaves = leave::where('user_id',$request->user_id)->get();
        if($leaves->count() > 0)
        {
            $response = [];
            //Fetch User Availed Annual Sick and Casual Leaves
            $service = new LeaveService();
            $leavesData = $service->getAvailableLeaves($request->user_id);

            foreach ($leaves as $leave) {
                $path = null;
                if(isset($leave->media) && $leave->media !=null)
                    $path = asset('/storage/uploads/'.$leave->media);

                $payload = [
                    'id' => $leave->id,
                    'user_id' => $leave->user_id,
                    'leave_type_id' => $leave->leave_type_id,
                    'subject' => $leave->subject,
                    'description' => $leave->description,
                    'start_date' => $leave->start_date,
                    'end_date' => $leave->end_date,
                    'reason' => $leave->reason,
                    'status' => $leave->status,
                    'approval_id' => $leave->approval_id,
                    'media' => $path,
                    'availed_annual' => $leavesData['availed_annual'],
                    'remaining_annual' => $leavesData['remaining_annual'],
                    'availed_sick' => $leavesData['availed_sick'],
                    'remaining_sick' => $leavesData['remaining_sick'],
                    'availed_casual' => $leavesData['availed_casual'],
                    'remaining_casual' => $leavesData['remaining_casual'],
                    'availed_half_day' => $leavesData['availed_half_day'],
                    'remaining_half_day' => $leavesData['remaining_half_day'],
                    'created_at' => $leave->created_at,
                    'updated_at' => $leave->updated_at,
                ];
                $response[] = $payload;
            }
            // dd($payload);
            return response()->json(['success'=>true,'leaves'=>$response]);
        }
        
        return response()->json(['success'=>false,'message'=>'No leaves request submitted.']);
    }

}
