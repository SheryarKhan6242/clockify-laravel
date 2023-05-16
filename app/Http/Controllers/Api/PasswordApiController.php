<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use App\Mail\SendEmail; 
use App\Jobs\SendVerifiedOtpEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordApiController extends Controller
{
    //
    public function requestOtp(Request $request)
    {
        // Validate the request input
        $validator = \Validator::make($request->all(), [
            'identifier' => 'required',
        ]);

        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }
    
        try {
            // Find the user by email or username
            $user = User::where('email', '=', $request->identifier)
                ->orWhere('username', '=', $request->identifier)
                ->first();
    
            if ($user) {
                // Generate a unique OTP

                $otp = $this->generateUniqueOtp();

                // Update the user's OTP in the database
                $user->otp = $otp;
                $user->save();

                // Send the OTP via email    
                SendVerifiedOtpEmail::dispatch($user, $otp);
    
                return response()->json(['success' => true,'status' => 200,'message' => 'OTP sent successfully',]);
            } else {
                return response()->json(['success' => false,'status' => 401,'message' => 'Invalid email or username',], 401);
            }
        } catch (\Exception $e) {    
            return response()->json(['success' => false,'status' => 500,'message' => 'An error occurred while requesting OTP. Please try again later.',], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
         // Validate the request input
         $validator = \Validator::make($request->all(), [
            'identifier' => 'required',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }

        // Find the user by email or username and matching OTP
        $user = User::where('otp', $request->otp)
            ->where('email', $request->identifier)
            ->orWhere('username', $request->identifier)
            ->first();

        if ($user) {
            Auth::guard('web')->login($user, true);            
            $user->otp = null;
            $user->save();

            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json(['success' => true,'status' => 200,'message' => 'Otp Verified Successfully!','access_token' => $accessToken,
            ]);
        } else {
            return response()->json(['success' => false,'status' => 401,'message' => 'Invalid email, username, or OTP',], 401);
        }
    }

    public function updatePassword(Request $request)
    {
        // Validate the request input
        $validator = \Validator::make($request->all(), [
            'access_token' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            return response()->json(['success'=>false,'errors'=>$errors]);
        }
        // Find the user_id associated with the access token
        $token = $request->input('access_token');
        $accessToken = PersonalAccessToken::where('token',$token)->first();
      
        // Check if the access token and user_id are valid
        if (!isset($accessToken->id)) {
            // throw ValidationException::withMessages(['access_token' => 'Invalid access token']);
            return response()->json(['success'=>false,'errors'=>'Invalid access token']);
        }
        $user_id = $accessToken->tokenable_id;
        // Update the user's password
        $user = User::find($user_id);
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['success'=>true,'message'=>'Password Changed Successfully!']);
    }
    
    public function generateUniqueOtp()
    {
        $otp = rand(1000, 9999);
    
        // Check if the generated OTP already exists in the database
        $existingOtp = User::where('otp', '=', $otp)->first();
        if ($existingOtp) {
            // If the OTP already exists, recursively generate a new one
            return $this->generateUniqueOtp();
        }
    
        return $otp;
    }

}
