<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkFromHome;
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

        try {
            $home = new WorkFromHome();
            $home->user_id = $request->user_id;

            $home->start_date = Carbon::parse($request->start_date);
            $home->end_date = Carbon::parse($request->end_date);
            $home->reason = $request->reason;
            $home->status = "pending";
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
            //throw $th;
            return response()->json(['success'=>false,'errors'=>$th]);
        }
        
    }
}
