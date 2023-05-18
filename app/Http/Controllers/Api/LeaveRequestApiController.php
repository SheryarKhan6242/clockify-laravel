<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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

        try {
            //code...\
            $leave = new Leave();
            $leave->user_id = $request->user_id;
            $leave->leave_type_id = $request->leave_type;
            $leave->subject = $request->subject;
            $leave->description = $request->description;
            
            $leave->start_date = Carbon::parse($request->start_date);
            $leave->end_date = Carbon::parse($request->end_date);
            $leave->status = 'pending';
            $leave->approval_id = null;

            //Upload image from URL to Laravel storage
            if ($request->hasFile('media')) {
                $avatar = $request->file('media');
                $fileName = time() . '_' . $avatar->getClientOriginalName();
                $filepath = 'uploads/' . $fileName;
                $path = Storage::disk('public')->put($filepath, file_get_contents($request->file('media')));
                $path = Storage::disk('public')->url($path);
                $memberProfile->profile_photo = $fileName;
            }
            $leave->save();
            
            return response()->json(['success'=>true,'message'=>'Leave Request Submitted Successfully!']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success'=>false,'errors'=>$th]);
        }
        
    }
}
