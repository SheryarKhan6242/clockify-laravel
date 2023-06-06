<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['holidays'] = Holiday::paginate(15);
        return view('holiday.index',$data);
    }

    public function get_holiday_data(Request $request)
    {
        $holidays = Holiday::paginate(15);

        if($request->ajax())
        {
            $holidays = Holiday::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('name','LIKE','%'.$request->search_item.'%')
                                ->orwhere('description','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('holiday.include.tableData', compact('holidays'))->render();
        }

        return view('holiday.include.tableData', compact('holidays'))->render();
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
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $holiday = new Holiday();
        $holiday->name = $request->name;
        $holiday->description = $request->description;
        $holiday->start_date = $request->start_date;
        $holiday->end_date = $request->end_date;
        $holiday->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $holiday->save();
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
        $holiday = Holiday::find($id);
        if($holiday)
            return response()->json(['success'=>true,'holiday'=>$holiday]);
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
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        
        if ($validator->fails())
        {      
            $errors = $validator->errors()->toArray();
            // dd($errors);
            return response()->json(['errors' => $errors]);
            // return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $holiday = Holiday::find($id);
        $holiday->name = $request->name;
        $holiday->description = $request->description;
        $holiday->start_date = $request->start_date;
        $holiday->end_date = $request->end_date;
        $holiday->status = isset($request->status) && $request->status == "true" ? 1 : 0 ;
        $holiday->save();
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
        Holiday::destroy($id);
        return response()->json(['success'=>true]);
    }
}
