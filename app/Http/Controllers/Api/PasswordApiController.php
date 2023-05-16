<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\SendEmail; 

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
                $subject = 'Testing Application OTP';
                $content = 'Your OTP is: ' . $otp;    
                Mail::to($user->email)->send(new SendEmail($subject,$content));
    
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
