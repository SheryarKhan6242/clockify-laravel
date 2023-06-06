<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['shifts'] = Shift::paginate(15);
        return view('shift.index',$data);
    }

    public function get_shift_data(Request $request)
    {
        $shifts = Shift::paginate(15);

        if($request->ajax())
        {
            $shifts = Shift::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('shift.include.tableData', compact('shifts'))->render();
        }

        return view('shift.include.tableData', compact('shifts'))->render();
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
            'start_time' => 'required',
            'end_time' => 'required',
            'late' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $shift = new Shift();
        $shift->name = $request->name;
        $shift->start = $request->start_time;
        $shift->end = $request->end_time;
        $shift->late = $request->late;
        $shift->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $shift->save();
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
        $shift = Shift::find($id);
        if($shift)
            return response()->json(['success'=>true,'shift'=>$shift]);
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
            'start_time' => 'required',
            'end_time' => 'required',
            'late' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $shift = Shift::find($id);
        $shift->name = $request->name;
        $shift->start = $request->start_time;
        $shift->end = $request->end_time;
        $shift->late = $request->late;
        $shift->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $shift->save();
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
        Shift::destroy($id);
        return response()->json(['success'=>true]);
    }
}
