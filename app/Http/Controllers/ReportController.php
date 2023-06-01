<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        //
        $data['reports'] = Report::paginate(5);
        return view('report.index',$data);
    }

    public function getReportData(Request $request)
    {
        $reports = Report::paginate(5);

        if($request->ajax())
        {
            $reports = Report::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('reason','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(5);

            //Need to add search for employee name as well. Map the ID on to the name.
            // $workFromHome = WorkFromHome::query()
            // ->when($request->search_item, function($q)use($request){
            //     $q->where('employee','LIKE','%'.$request->search_item.'%')
            //     ->orWhere('reason','LIKE','%'.$request->search_item.'%');
            // })
            // ->paginate(5);

            return view('report.include.tabledata', compact('reports'))->render();
        }

        return view('report.include.tabledata', compact('reports'))->render();
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
        // $validator = \Validator::make($request->all(), [
        //     'type' => 'required'
        // ]);
        
        // if ($validator->fails())
        // {      
        //     $errors = $validator->errors()->toArray();
        //     // dd($errors);
        //     return response()->json(['errors' => $errors]);
        //     // return response()->json(['errors'=>$validator->errors()->all()]);
        // }
        // $leaveType = new Leave();
        // $leaveType->type = $request->type;
        // $leaveType->save();
        // return response()->json(['type' =>'success']);
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
        $workFromHome = WorkFromHome::with('userName')->find($id);
        // dd($workFromHome);
        if($workFromHome) {
            $response = [
                'success' => true,
                'workFromHome' => [
                    'id' => $workFromHome->id,
                    'name' => $workFromHome->userName->name,
                    'start_date' => $workFromHome->start_date,
                    'end_date' => $workFromHome->end_date,
                    'reason' => $workFromHome->reason,
                    'status' => $workFromHome->status
                    // add other columns as needed
                ],
            ];
            return response()->json($response);
        }
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
        // $validator = \Validator::make($request->all(), [
        //     'type' => 'required'
        // ]);
        
        // if ($validator->fails())
        // {      
        //     $errors = $validator->errors()->toArray();
        //     // dd($errors);
        //     return response()->json(['errors' => $errors]);
        //     // return response()->json(['errors'=>$validator->errors()->all()]);
        // }
        // $leaveType = Leave::find($id);
        // $leaveType->type = $request->type;
        // $leaveType->save();
        // return response()->json(['type' =>'success']);
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
        Report::destroy($id);
        return response()->json(['success'=>true]);
    }

    public function fetchTopEmployees(Request $request)
    {
        $topEmployees = Report::orderBy('total_work_hours', 'desc')
            ->take(5)
            ->get(['user_id', 'total_work_hours']);

        return response()->json($topEmployees);
    }
}
