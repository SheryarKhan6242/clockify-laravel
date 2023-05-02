<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeApiController extends Controller
{
    //
    public function updateProfile(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $employee = Employee::where('user_id',$request->user_id)->first();
        $employee = Employee::find($employee->id);
    $employee->update($request->all());
        // return response()->json(['employee'=>$employee]);
        // $employee->user_id = $request->user_id;
        // $employee->first_name = $request->first_name;
        // $employee->last_name = $request->last_name;
        // $employee->father_name = $request->father_name;
        // $employee->gen_id = $request->gen_id;
        // $employee->cnic_no = $request->cnic_no;
        // $employee->permanent_address = $request->permanent_address;
        // $employee->temporary_address = $request->temporary_address;
        // $employee->country_id = $request->country_id;
        // $employee->city_id = $request->city_id;
        // $employee->mobile_no = $request->mobile_no;
        // $employee->alternative_no = $request->alternative_no;
        // $employee->emergency_no = $request->emergency_no;
        // // $employee->user_email = auth()->user()->email;
        // $employee->personal_email = $request->personal_email;
        // $employee->marital_status = $request->marital_status;
        // $employee->emp_type = $request->emp_type;
        // $employee->dep_id = $request->dep_id;
        // $employee->shift_id = $request->shift_id;
        // $employee->designation = $request->designation;
        // $employee->salary = $request->salary;
        // $employee->is_lead = isset($request->is_lead) && $request->is_lead == true ? 1 : 0;
        // $employee->save();
        return response()->json(['type' =>'success']);
    }
}
