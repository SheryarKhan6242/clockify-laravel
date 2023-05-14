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


        if($user && $user->status == 0)
        {
            return $this->sendResponse(null, 'User profile has been deactivated.');
        } else if($user && !Hash::check($request->password, $user->password)) {
            return $this->sendError('Incorrect Password', null);

        } else if(!$user)
        {
            return $this->sendError('Invalid Credentials', null);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User logged in successfully.');
        }
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
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
