<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['employees'] = Employee::paginate(5);
        return view('employee.index',$data);
    }

    public function getEmpData(Request $request)
    {
        $employees = Employee::paginate(5);

        if($request->ajax())
        {
            $employees = Employee::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('first_name','LIKE','%'.$request->search_item.'%')
                            ->orWhere('last_name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(5);

            return view('employee.include.tabledata', compact('employees'))->render();
        }

        return view('employee.include.tabledata', compact('employees'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gen_id' => 'required',
            'permanent_address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'mobile_no' => 'required',
            'emergency_no' => 'required',
            'marital_status' => 'required',
            'emp_type' => 'required',
            'dep_id' => 'required',
            'shift_id' => 'required',
            'designation' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make(Str::random(10));
        $user->save();

        $user->assignRole(Role::findByName('employee'));

        $employee = new Employee();
        $employee->user_id = $user->id;
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->gen_id = $request->gen_id;
        $employee->permanent_address = $request->permanent_address;
        $employee->country_id = $request->country_id;
        $employee->city_id = $request->city_id;
        $employee->mobile_no = $request->mobile_no;
        $employee->emergency_no = $request->emergency_no;
        $employee->user_email = $request->email;
        $employee->marital_status = $request->marital_status;
        $employee->emp_type = $request->emp_type;
        $employee->dep_id = $request->dep_id;
        $employee->shift_id = $request->shift_id;
        $employee->designation = $request->designation;
        $employee->save();



        return response()->json(['type' =>'success']);
    }

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
        $employees = Employee::find($id);
        if($employees)
            return response()->json(['success'=>true,'employees'=>$employees]);
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
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gen_id' => 'required',
            'permanent_address' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'mobile_no' => 'required',
            'emergency_no' => 'required',
            'user_email' => 'required',
            'marital_status' => 'required',
            'emp_type' => 'required',
            'dep_id' => 'required',
            'shift_id' => 'required',
            'designation' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $employee = Employee::find($id);
        $employee->user_id = auth()->user()->id;
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->gen_id = $request->gen_id;
        $employee->permanent_address = $request->permanent_address;
        $employee->country_id = $request->country_id;
        $employee->city_id = $request->city_id;
        $employee->mobile_no = $request->mobile_no;
        $employee->emergency_no = $request->emergency_no;
        $employee->user_email = auth()->user()->email;
        $employee->marital_status = $request->marital_status;
        $employee->emp_type = $request->emp_type;
        $employee->dep_id = $request->dep_id;
        $employee->shift_id = $request->shift_id;
        $employee->designation = $request->designation;
        $employee->save();
        return response()->json(['type' =>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        return response()->json(['success'=>true]);
    }
}
