<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['leaveType'] = LeaveType::paginate(15);
        return view('leaveType.index',$data);
    }

    public function get_leave_type_data(Request $request)
    {
        $leaveType = LeaveType::paginate(15);

        if($request->ajax())
        {
            $leaveType = LeaveType::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('type','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('leaveType.include.tableData', compact('leaveType'))->render();
        }

        return view('leaveType.include.tableData', compact('leaveType'))->render();
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
        $leaveType = new LeaveType();
        $leaveType->type = $request->type;
        $leaveType->save();
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
        $leaveType = LeaveType::find($id);
        if($leaveType)
            return response()->json(['success'=>true,'leaveType'=>$leaveType]);
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
        $leaveType = LeaveType::find($id);
        $leaveType->type = $request->type;
        $leaveType->save();
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
        LeaveType::destroy($id);
        return response()->json(['success'=>true]);
    }
}
