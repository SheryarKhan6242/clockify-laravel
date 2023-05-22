<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class DeviceUserApiController extends Controller
{
    //

    public function storeDeviceId(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'device_id' => 'required',
        ]);

        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        $user = User::where('id',$request->user_id)->where('status', 1)->first();
        if($user)
        {
            if($user->device_id == null)
            {
                try {    
                    $user->device_id = $request->device_id;
                    $user->save();
                } catch (\Throwable $th) {
                    // Return the error response
                    if (env('APP_ENV') === 'local') {
                        return response()->json(['success' => false, 'message' => $th->getMessage()]);
                    }
                    Log::error($th);
                    return response()->json(['success' => false, 'message' => 'An error occurred while processing your request.']);
                }
            }
            else
            {
                return response()->json(['success' => false, 'message' => 'Device Id Already Exist!']);
            }
            
            return response()->json(['success' => true, 'message' => 'Device Id Added Successfully!']);

        } else 
        {
            return response()->json(['success' => false, 'message' => 'User Does Not Exist!' ]);
        }

    }
}
