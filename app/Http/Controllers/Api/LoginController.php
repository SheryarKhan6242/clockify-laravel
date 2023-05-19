<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
{
     /**
     * Log In API.
     *
     * @return json response
     */
    public function login(Request $request)
    {
        // If logging in using device_id, ignore email password validations. Otherwise, login via email and password.
        if (isset($request->device_id)) {
            $user = User::where('device_id', $request->device_id)->where('status', 1)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Device Id does not exist!']);
            }
            //Log the user in if the device id exists. The function is a replacement for Auth::attempt(['email' => $request->email, 'password' => $request->password]) Which is used
            //to login via email and password only 
            Auth::login($user);
        } else {
            $validator = \Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json(['errors' => $errors]);
            }

            $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

            if ($user && $user->status == 0) {
                return $this->sendResponse(null, 'User profile has been deactivated.');
            } else if ($user && !Hash::check($request->password, $user->password)) {
                return $this->sendError('Incorrect Password', null);
            } else if (!$user) {
                return $this->sendError('Invalid Credentials', null);
            }
        }

        // Check if device_id exists in the payload and user exists in the DB, then log in. Otherwise, check if the password and email match.
        if (isset($request->device_id) || Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::check()) {
                $user = Auth::user();
        
                $user->update([
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp()
                ]);
        
                $success['token'] =  $user->createToken('MyApp')->plainTextToken;
                $success['name'] =  $user->name;
                $success['user'] = [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "last_login_at" => $user->last_login_at,
                    "last_login_ip" => $user->last_login_ip
                ];
        
                return $this->sendResponse($success, 'User logged in successfully.');
            } else {
                // Handle authentication failure
                return $this->sendError('Authentication failed.', null);
            }
        }

    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success'=>true,'message'=>'You have been successfully logged out!']);
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        // if(!empty($errorMessages)){
        //     $response['data'] = $errorMessages;
        // }

        return response()->json($response, $code);
    }
}
