<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['departments'] = Department::paginate(5);
        return view('department.index',$data);
    }

    public function get_department_data(Request $request)
    {
        $departments = Department::paginate(5);

        if($request->ajax())
        {
            $departments = Department::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(5);

            return view('department.include.tableData', compact('departments'))->render();
        }

        return view('department.include.tableData', compact('departments'))->render();
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
        //
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $department = new Department();
        $department->name = $request->name;
        $department->status = isset($request->status) && $request->status == true ? 1 : 0 ;
        $department->color = $request->color;
        $department->save();
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
        //
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
    }
}
