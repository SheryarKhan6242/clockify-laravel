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
        // return response()->json(['name' => 'shery']);
    //     $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
    //     if($user && $user->status == 0)
    //     {
    //         return response()->json(['message'=> 'User profile has been deleted']);
    //     }
    //     if (! $user || ! Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => __('auth.failed'),
    //         ]);
    //     }
    //     // dd($request->user());
    //     $user->update([
    //         'last_login_at' => Carbon::now()->toDateTimeString(),
    //         'last_login_ip' => $request->getClientIp()
    //     ]);

    //     $token = $user->createToken('api-token');
    //     $user = ['name' => $user->name];
    //     return response()->json(['token' => $token,'user' => $user]);
    // }

    // public function logout(Request $request) {
    //     $request->user()->currentAccessToken()->delete();
    //     $response = ['message' => 'You have been successfully logged out!'];
    //     return response($response, 200);

        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        // return $user;
        if($user && $user->status == 0)
        {
            return $this->sendResponse(null, 'User profile has been deactivated.');
        } else if($user && !Hash::check($request->password, $user->password)) {
            return $this->sendError('Incorrect Password', null);

        } else if(!$user)
        {
            return $this->sendError('Invalid email address', null);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User logged in successfully.');
        }
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
