<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\WorkFromHome;
use App\Models\User;
use Carbon\Carbon;


class WorkFromHomeApiController extends Controller
{
    //
    public function addWfhRequest(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y',
            'reason' => 'required',
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
            $home = new WorkFromHome();
            $home->user_id = $request->user_id;

            $home->start_date = Carbon::parse($request->start_date);
            $home->end_date = Carbon::parse($request->end_date);
            $home->reason = $request->reason;
            $home->status = "Pending";
            $home->approved_by = null;

            //Upload image from URL to Laravel storage
            if ($request->hasFile('attach_file')) {
                // dd('hello');
                $avatar = $request->file('attach_file');
                $fileName = time() . '_' . $avatar->getClientOriginalName();
                $filepath = 'uploads/' . $fileName;
                $path = Storage::disk('public')->put($filepath, file_get_contents($request->file('attach_file')));
                $path = Storage::disk('public')->url($path);
                $home->attach_file = $fileName;
            }

            $home->save();
            return response()->json(['success'=>true,'message'=>'Work From Home Request Submitted Successfully!']);
        } catch (\Throwable $th) {
            // Return the error response
            if (env('APP_ENV') === 'local') {
                return response()->json(['success' => false, 'message' => $th->getMessage()]);
            }
            Log::error($th);
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
        } 
    }

    public function getUserWfhRequests(Request $request)
    {
        $requests = WorkFromHome::where('user_id',$request->user_id)->get();
        // $path = asset('/storage/uploads/'.$fileName)
        if($requests->count() > 0){        
            $response = [];
            foreach ($requests as $request) {
                $path = null;
                if(isset($request->attach_file) && $request->attach_file !=null)
                    $path = asset('/storage/uploads/'.$request->attach_file);

                $payload = [
                    'id' => $request->id,
                    'user_id' => $request->user_id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'reason' => $request->reason,
                    'rejected_reason' => $request->rejected_reason,
                    'status' => $request->status,
                    'approved_by' => $request->approved_by,
                    'attach_file' => $path,
                    'created_at' => $request->created_at,
                    'updated_at' => $request->updated_at,
                ];
                $response[] = $payload;
            }
            // dd($payload);
            return response()->json(['success'=>true,'requests'=>$response]);
        }
        return response()->json(['success'=>false,'message'=>'No Work From Home request submitted.']);
    }
}
