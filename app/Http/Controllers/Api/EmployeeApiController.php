<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeWorkingType;


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

    public function getEmpWorkingTypes(Request $request)
    {
        $types = EmployeeWorkingType::all();
        if($types)
            return response()->json(['workingTypes'=>$types]);
        
        return response()->json(['message'=>'Employee Working Types does not exist.']); 
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
        $employee = Employee::where('user_id',$request->user_id)
            ->where('first_name',$request->first_name)
            ->where('last_name',$request->last_name)
            ->where('father_name',$request->father_name)
            ->first();

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
