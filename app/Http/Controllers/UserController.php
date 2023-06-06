<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Requests\Users\EditRequest;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['users'] = User::all();
        return view('users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $emailExists = User::where('email', $request->email)->exists();
            if ($emailExists) {
                return redirect()->route('createUser')->with(['type' => 'danger', 'heading' => 'User Already Exist!','message' => 'User with same email already exist! Please try a different email.']);   
            } else {
                $user = User::create([
                    'name'          => $request->name,
                    'username'      => $request->username, 
                    'email'         => $request->email,
                    'password'      => Hash::make(rand()),
                ]);
                $user->assignRole(Role::findByName($request->roles));

                /*Send new member welcome mail*/
                try {
                    $token = app('auth.password.broker')->createToken($user);
                    $resetUrl= url(config('app.url').route('password.reset', $token,false)."?email=".$user->email);
                    Mail::to($user->email)->send(new Welcome('Welcome Foredimensions', $resetUrl));
                } catch (\Throwable $th) {
                    //throw $th;
                    Log::error($th);
                }
                return redirect()->route('listUsers')->with(['type' => 'success', 'message' => 'User Created Successfully!']);   
            }
        } catch (Exception $e) {
            dd("error");
            $this->error('Something went wrong!');
        }
        
    }
//     public function store(CreateRequest $request)
// {
//     dd($request->all()); // add this line to dump the value of the name field
    
//     try {
//         $user = User::create([
//             'name'          => $request->name,
//             'email'         => $request->email,
//             'password'      => Hash::make($request->password),
//         ]);
//         $user->assignRole(Role::findByName($request->roles));
//         return redirect()->route('listUsers')->with(['type' => 'success', 'message' => 'User Created Successfully!']);   
//     } catch (Exception $e) {
//         \Log::error('Error creating user: ' . $e->getMessage());
//         return back()->withInput()->withErrors(['message' => 'Something went wrong!']);
//     }
// }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [];
        $data['user'] = User::find($id);
        return view('users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            if($request->user_pass !=null){
                $user->password = Hash::make($request->user_pass);
            }
            $user->status = $request->status;
            $user->assignRole(Role::findByName($request->roles));
            $user->save();
            return redirect()->route('listUsers')->with(['type' => 'success', 'message' => 'User Updated Successfully!']);
        }
        catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::destroy($id);
        return redirect()->route('listUsers')->with(['type' => 'success', 'message' => 'User Deleted Successfully!']);
    }
}