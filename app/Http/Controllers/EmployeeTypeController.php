<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeType;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['empTypes'] = EmployeeType::paginate(15);
        return view('empType.index',$data);
    }

    public function getEmpTypeData(Request $request)
    {
        $empTypes = EmployeeType::paginate(15);

        if($request->ajax())
        {
            $empTypes = EmployeeType::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('empType.include.tabledata', compact('empTypes'))->render();
        }

        return view('empType.include.tabledata', compact('empTypes'))->render();
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
            'name' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $empType = new EmployeeType();
        $empType->name = $request->name;
        $empType->save();
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
        $empType = EmployeeType::find($id);
        if($empType)
            return response()->json(['success'=>true,'empType'=>$empType]);
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
            'name' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $empType = EmployeeType::find($id);
        $empType->name = $request->name;
        $empType->save();
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
        EmployeeType::destroy($id);
        return response()->json(['success'=>true]);
    }
}
