<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeWorkingType;

class EmployeeWorkingTypeController extends Controller
{
    public function index()
    {
        //
        $data['workType'] = EmployeeWorkingType::paginate(15);
        return view('empWorkType.index',$data);
    }

    public function get_leave_type_data(Request $request)
    {
        $workType = EmployeeWorkingType::paginate(15);

        if($request->ajax())
        {
            $workType = EmployeeWorkingType::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('type','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('empWorkType.include.tableData', compact('workType'))->render();
        }

        return view('empWorkType.include.tableData', compact('workType'))->render();
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
        $validator = \Validator::make($request->all(), [
            'type' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $workType = new EmployeeWorkingType();
        $workType->type = $request->type;
        $workType->save();
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
        $workType = EmployeeWorkingType::find($id);
        if($workType)
            return response()->json(['success'=>true,'workType'=>$workType]);
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
        $validator = \Validator::make($request->all(), [
            'type' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $workType = EmployeeWorkingType::find($id);
        $workType->type = $request->type;
        $workType->save();
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
        //
        EmployeeWorkingType::destroy($id);
        return response()->json(['success'=>true]);
    }
}
