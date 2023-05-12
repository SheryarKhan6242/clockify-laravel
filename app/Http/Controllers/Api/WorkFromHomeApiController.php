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
            'user_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
        }

        $home = new WorkFromHome();
        $home->user_id = $request->user_id;
        // if(Carbon::parse($request->start_date) < Carbon::now())
        //     return response()->json(['message' => 'Start date cannot be less than current date.']);

        $home->start_date = Carbon::parse($request->start_date);
        $home->end_date = Carbon::parse($request->end_date);
        $home->reason = $request->reason;
        $home->status = $request->status;
        $home->approved_by = null;

        //Upload image from URL to Laravel storage
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $fileName = time() . '_' . $avatar->getClientOriginalName();
        //     $filepath = 'uploads/' . $fileName;
        //     $path = Storage::disk('public')->put($filepath, file_get_contents($request->file('avatar')));
        //     $path = Storage::disk('public')->url($path);
        //     $memberProfile->profile_photo = $fileName;
        // }
        if(isset($request->attach_file))
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
            $contents = file_get_contents($request->attach_file);
            $name = substr($request->attach_file, strrpos($request->attach_file, '/') + 1);
            $filepath = 'uploads/' . $name;
            $path = Storage::disk('public')->put($filepath, $contents);
            $path = Storage::disk('public')->url($path);
            $home->attach_file = $name;
            // Storage::put($name, $contents);
        }
        $home->save();
            
        return response()->json(['message' =>'Work From Home Request Submitted Successfully!']);
    }
}
