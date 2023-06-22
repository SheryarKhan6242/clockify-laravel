<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkFromHome;
use App\Models\User;
use App\Jobs\GetEmailTemplates;

class WorkFromHomeController extends Controller
{
    public function index()
    {
        //
        $data['workFromHome'] = WorkFromHome::paginate(15);
        return view('workFromHome.index',$data);
    }

    public function getWfhData(Request $request)
    {
        $workFromHome = WorkFromHome::paginate(15);

        if($request->ajax())
        {
            $workFromHome = WorkFromHome::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('reason','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            //Need to add search for employee name as well. Map the ID on to the name.
            // $workFromHome = WorkFromHome::query()
            // ->when($request->search_item, function($q)use($request){
            //     $q->where('employee','LIKE','%'.$request->search_item.'%')
            //     ->orWhere('reason','LIKE','%'.$request->search_item.'%');
            // })
            // ->paginate(5);

            return view('workFromHome.include.tabledata', compact('workFromHome'))->render();
        }

        return view('workFromHome.include.tabledata', compact('workFromHome'))->render();
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

    public function updateWfhStatus(Request $request)
    {
        $workFromHome = WorkFromHome::find($request->id);
        if($request->status == 1){
            $workFromHome->status = 'Approved';
            $workFromHome->approved_by = auth()->user()->id;
        } else if ($request->status == 0) {
            $workFromHome->status = 'Declined';
            $workFromHome->approved_by = auth()->user()->id;
        } else {
            $workFromHome->status = 'Pending';
            $workFromHome->approved_by = auth()->user()->id;
        }

        $workFromHome->save();
        //Prepare Work From Home Request queue job for User
        $templateName = 'wfh_status';
        //Fetch user
        $user = User::find($workFromHome->user_id);
        $placeholders = ['[username]','[start_date]','[end_date]','[status]'];
        $values = [$user->name,$workFromHome->start_date,$workFromHome->end_date,$workFromHome->status];
        //Dispatch queue job
        GetEmailTemplates::dispatch($user->email, $templateName, $placeholders, $values);
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
        WorkFromHome::destroy($id);
        return response()->json(['success'=>true]);
    }
}
