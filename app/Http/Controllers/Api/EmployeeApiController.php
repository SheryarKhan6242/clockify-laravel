<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeApiController extends Controller
{
    //

    public function getProfile(Request $request)
    {
        $employee = Employee::where('user_id',$request->id)->first();
        if($employee)
            return response()->json(['employee'=>$employee]);
        
            return response()->json(['message'=>'Employee does not exist.']); 
    }

    public function updateProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'father_name' => 'required',

        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $employee = Employee::where('user_id',$request->user_id)->first();

        if($employee)
        {
            $employee = Employee::find($employee->id);
            $employee->update($request->all());
            return response()->json(['message' =>'Employee Updated Successfully!']);
        } else {
            return response()->json(['message' =>'Employee does not exist.']);
        }
    }
}
