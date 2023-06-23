<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Report;
use App\Services\LeaveService;
use App\Services\WfhService;
use App\Services\TimeAdjustmentService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get total no of Clockins today(Total presents). Getting disctinct user_ids on current day since clockins can be multiple,
        $data['totalPresents'] = Report::whereDate('login_date', Carbon::now()->format('Y-m-d'))
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();
        
        //TOTAL ACTIVE ACTIVE EMPLOYEES
        $data['totalEmployees'] = Employee::where('status', 1)
            ->pluck('user_id')
            ->toArray();

        $data['totalAbsents'] = count($data['totalEmployees']) - count($data['totalPresents']);

        //EMPLOYEE DAILY REPORTS
        $data['reports'] = Report::join('employees', 'reports.user_id', '=', 'employees.user_id')
        ->whereDate('login_date', Carbon::now()->format('Y-m-d'))
        ->select('reports.*', 'employees.id as employee_id','employees.first_name as employee_fname','employees.last_name as employee_lname', 'employees.designation as employee_designation')
        ->get();

        //KARACHI ACTIVE EMPLOYEES
        // 108(PAK ) 46828(HYD) 46821(KHI)
        $data['khi'] = Employee::where('status',1)->where('country_id',108)->where('city_id',46821)->count();
        //HYDERABAD ACTIVE EMPLOYEES
        $data['hyd'] = Employee::where('status',1)->where('country_id',108)->where('city_id',46828)->count();
        //OTHER CITIES ACTIVE EMPLOYEES
        // dd(count($data['totalEmployees']));
        if(count($data['totalEmployees']) > 0)
        {
            $data['khiPercentage'] = round(($data['khi'] / count($data['totalEmployees'])) * 100);
            $data['hydPercentage'] = round(($data['hyd'] / count($data['totalEmployees'])) * 100);
            $data['other'] = round((100 - $data['khiPercentage'] - $data['hydPercentage']));
        } else {
            $data['khiPercentage'] = 0;
            $data['hydPercentage'] = 0;
            $data['other'] = 0;
        }

        //EMPLOYEE REQUESTS
        //PENDING LEAVES
        $leaveService = new LeaveService();
        $data['annualLeavesRequest'] = $leaveService->leaveRequests(1,'Pending','1',null,null);
        $data['sickLeavesRequest'] = $leaveService->leaveRequests(2,'Pending','1',null,null);

        //PENDING WFH
        $wfhService = new WfhService();
        $data['wfhRequest'] = $wfhService->wfhRequests('Pending',1,null,null);
        // dd($data['sickLeavesRequest']->count());

        //PENDING TIMEADJUSTMENT
        $timeAdjService = new TimeAdjustmentService();
        $data['timeAdjRequest'] = $timeAdjService->timeAdjustmentRequests('Pending',1,null,null);
        // dd($data['sickLeavesRequest']->count());
        return view('dashboard',$data);
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
