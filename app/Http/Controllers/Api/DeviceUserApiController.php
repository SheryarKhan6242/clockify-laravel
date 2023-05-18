<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                $user->device_id = $request->device_id;
                $user->save();
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
