<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Models\Employee;
use App\Services\LeaveService;
use App\Jobs\GetEmailTemplates;
use Carbon\Carbon;

//All Queries/Model fetching logic should be placed in Leave Service. The controller should only be responsible for returning the response and calling the necessary services.
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
        // $data = [];

        // if ($request->has(' ') && $request->leaveType === 'annual') {
        //     $data['leave'] = Leave::where('leave_type_id',1)->paginate(15);
        // } elseif($request->has('leaveType') && $request->leaveType === 'sick') {
        //     $data['leave'] = Leave::where('leave_type_id',2)->paginate(15);
        // } else {
        //     $data['leave'] = Leave::paginate(15);
        // }

        //Get Approved,Rejected,Pending Annual Requests Requests/Month
        $service = new LeaveService();
        $data['approvedRequests'] = $service->leaveRequests(1,'Approved','2',null,null);
        $data['pendingRequests'] = $service->leaveRequests(1,'Pending','2',null,null);
        // dd($data['p  endingRequests']);
        $data['rejectedRequests'] = $service->leaveRequests(1,'Rejected','2',null,null);

        //Get Count of All types of Approved Requests/Month
        $data['approvedAnnualCount'] = $service->leaveRequests(1,'Approved','2',null,null)->count();
        $data['approvedSickCount'] = $service->leaveRequests(2,'Approved','2',null,null)->count();
        $data['approvedCasualCount'] = $service->leaveRequests(3,'Approved','2',null,null)->count();
        $data['approvedHalfCount'] = $service->leaveRequests(4,'Approved','2',null,null)->count();
        // dd($requests);

        //Get Approved leaves for today.
        $startDate = Carbon::now()->format('Y-m-d');      
        $endDate = $startDate;
        $data['approvedLeavesToday'] = $service->leaveRequests(null,'Approved',null,$startDate,$endDate);   

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
        // dd($request->all());
        $leave = Leave::find($request->id);
        if($request->status == 1){
            $leave->status = 'Approved';
            $leave->approval_id = auth()->user()->id;
        } else if ($request->status == 0) {
            //Add the validation as required for Rejected reason
            $validator = \Validator::make($request->all(), [
                'p_rej_reason' => 'required'
                ], [
                    'p_rej_reason.required' => 'The rejected reason field is required'
            ]);            
            if ($validator->fails())
            {      
                $errors = $validator->errors()->toArray();
                return response()->json(['errors' => $errors]);
            }
            $leave->status = 'Declined';
            $leave->reason = isset($request->p_rej_reason) ? $request->p_rej_reason : null; 
            $leave->approval_id = auth()->user()->id;
        } else {
            $leave->status = 'Pending';
            $leave->approval_id = auth()->user()->id;
        }

        $leave->save();
        //Prepare Leave Request queue job for User
        // $templateName = 'update_leave_status';
        // //Fetch user
        // $user = User::find($leave->user_id);
        // $placeholders = ['[username]','[start_date]','[end_date]','[status]'];
        // $values = [$user->name,$leave->start_date,$leave->end_date,$leave->status];
        // //Dispatch queue job
        // GetEmailTemplates::dispatch($user, $templateName, $placeholders, $values);
        return response()->json(['type' =>'success','message' => 'Leave Status Updated Successfully!']);
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

    public function getEmpAvailedLeaves($id)
    {
        $service = new LeaveService();
        $data = $service->getAvailableLeaves($id);
        if($data != null)
        {
            return response()->json(['success' => true, 'data' => $data]);
        } else 
        {
            return response()->json(['success' => false, 'data' => '']);
        }
        //#################REMANING LEAVES###################
        
    }
}
