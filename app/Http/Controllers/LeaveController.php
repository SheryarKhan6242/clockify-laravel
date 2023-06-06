<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Jobs\GetEmailTemplates;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $data['leave'] = Leave::paginate(5);
        // return view('leave.index',$data);
        $data = [];

        if ($request->has('leaveType') && $request->leaveType === 'annual') {
            $data['leave'] = Leave::where('leave_type_id',1)->paginate(15);
        } elseif($request->has('leaveType') && $request->leaveType === 'sick') {
            $data['leave'] = Leave::where('leave_type_id',2)->paginate(15);
        } else {
            $data['leave'] = Leave::paginate(15);
        }
        return view('leave.index', $data);
    }

    public function get_leave_data(Request $request)
    {
        $leave = Leave::paginate(15);

        if($request->ajax())
        {
            $leave = Leave::query()
                        ->when($request->search_item, function($q)use($request){
                            $q->where('type','LIKE','%'.$request->search_item.'%');
                        })
                        ->paginate(15);

            return view('leave.include.tableData', compact('leave'))->render();
        }

        return view('leave.include.tableData', compact('leave'))->render();
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
        $leaveType = new Leave();
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
        // $leave = Leave::find($id);
        // if($leave)
        //     return response()->json(['success'=>true,'leave'=>$leave]);
        $leave = Leave::with('userName', 'leaveType')->find($id);
        // dd($leave);
        if($leave) {
            $response = [
                'success' => true,
                'leave' => [
                    'id' => $leave->id,
                    'subject' => $leave->subject,
                    'description' => $leave->description,
                    'user_name' => $leave->userName->name,
                    'start_date' => $leave->start_date,
                    'end_date' => $leave->end_date,
                    'status' => $leave->status,
                    'leave_type' => $leave->leaveType->type,
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
        $leaveType = Leave::find($id);
        $leaveType->type = $request->type;
        $leaveType->save();
        return response()->json(['type' =>'success']);
    }

    public function updateLeaveStatus(Request $request)
    {
        $leave = Leave::find($request->id);
        if($request->status == 1){
            $leave->status = 'Approved';
            $leave->approval_id = auth()->user()->id;
        } else if ($request->status == 0) {
            $leave->status = 'Declined';
            $leave->approval_id = auth()->user()->id;
        } else {
            $leave->status = 'Pending';
            $leave->approval_id = auth()->user()->id;
        }

        $leave->save();
        //Prepare Leave Request queue job for User
        $templateName = 'update_leave_status';
        //Fetch user
        $user = User::find($leave->user_id);
        $placeholders = ['[username]','[start_date]','[end_date]','[status]'];
        $values = [$user->name,$leave->start_date,$leave->end_date,$leave->status];
        //Dispatch queue job
        GetEmailTemplates::dispatch($user, $templateName, $placeholders, $values);
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
        Leave::destroy($id);
        return response()->json(['success'=>true]);
    }
}
