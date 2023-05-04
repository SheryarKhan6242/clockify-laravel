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

class LoginController extends Controller
{
     /**
     * Log In API.
     *
     * @return json response
     */
    public function login(LoginRequest $request)
    {
        // return response()->json(['name' => 'shery']);
        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        if($user && $user->status == 0)
        {
            return response()->json(['message'=> 'User profile has been deleted']);
        }
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        // dd($request->user());
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        $token = $user->createToken('api-token');
        $user = ['name' => $user->name];
        return response()->json(['token' => $token,'user' => $user]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
