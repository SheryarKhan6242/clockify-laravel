<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            // if ($request->hasFile('avatar')) {
            //     $avatar = $request->file('avatar');
            //     $fileName = time() . '_' . $avatar->getClientOriginalName();
            //     $filepath = 'uploads/' . $fileName;
            //     $path = Storage::disk('public')->put($filepath, file_get_contents($request->file('avatar')));
            //     $path = Storage::disk('public')->url($path);
            //     $memberProfile->profile_photo = $fileName;
            // }
            if(isset($request->media))
            {
                // $imageData = file_get_contents($request->media);
                // $imageData = file_get_contents($request->media, false, stream_context_create([
                //     'http' => [
                //         'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36',
                //     ],
                // ]));
                
                // // return response()->json($imageData);
                // $fileName = time() . '_image';
                // Storage::put($fileName, $imageData);
                // $filepath = 'uploads/' . $fileName;
                // $path = Storage::disk('public')->put($filepath, $imageData);
                // $path = Storage::disk('public')->url($path);
                // $leave->media = $fileName;

                //USING URL AS AN IMAGE
                $contents = file_get_contents($request->media);
                $name = substr($request->media, strrpos($request->media, '/') + 1);
                $filepath = 'uploads/' . $name;
                $path = Storage::disk('public')->put($filepath, $contents);
                $path = Storage::disk('public')->url($path);
                $leave->media = $name;
                Storage::put($name, $contents);
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
            //throw $th;
            return response()->json(['success'=>false,'errors'=>$th]);
        }
        
    }

    public function getUserLeavesRequests(Request $request)
    {
        
        $leaves = leave::where('user_id',$request->user_id)->get();
        if($leaves->count() > 0)
        return response()->json(['success'=>true,'leaves'=>$leaves]);
        
        return response()->json(['success'=>false,'message'=>'No leaves request submitted.']);
    }

}
