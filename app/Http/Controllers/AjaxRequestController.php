<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\EmployeeLeaveType;
use App\Models\Report;
use App\Models\Leave;
use Carbon\Carbon;
use App\Services\LeaveService;
use App\Services\WfhService;
use App\Services\TimeAdjustmentService;

class AjaxRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $viewData = array();
    public function getCities($country_id, Request $request)
    {
        $cities = City::where('country_id', $country_id)->get();
        $this->viewData['cities'] = $cities;
        $this->viewData['city_id'] = isset($request->city_id) ?  $request->city_id : 0;
        return view('partial.cities', $this->viewData);
    }

    public function getSelectedCities(Request $request)
    {  
        $cities = City::where('country_id', $request->country_id)->get();
        $this->viewData['cities'] = $cities;
        $this->viewData['city_id'] = isset($request->city_id) ?  $request->city_id : 0;
        //While fetching city_id value in edit form, since add form and edit both has city_id
        $this->viewData['edit_city_id'] = 1;
         
        return view('partial.cities', $this->viewData);
    }

    public function storeEmpTypeLeaves(Request $request)
    {
        // dd($request->all());
        for ($i = 0; $i < count($request->leaveTypeValues); $i++) {
            $result[] = [
                "leave_type" => $request->leaveTypeValues[$i],
                "nol" => $request->nolValues[$i],
            ];
        }
        
        $json_result = json_encode($result);

        $empLeavetype = new EmployeeLeaveType();
        $empLeavetype->emp_type_id = $request->empTypeId;
        $empLeavetype->payload = $json_result;
        $empLeavetype->save();
        return response()->json(['success' =>'true']);
    }

    public function getEmpTypeLeaves(Request $request, $id)
    {
        // dd($request->all());
        $empLeavetype = EmployeeLeaveType::where('emp_type_id',$id)->first();
        return response()->json(['success' =>'true','empLeavetype'=>$empLeavetype]);
    }

    //Get Employee Max Working hours by weekly or monthly(TOP 5)
    public function getEmpWorkHours(Request $request)
    {   
        // dd($request->input('filter'));
        $startDate = Carbon::now()->subWeek()->format('Y-m-d');   
        // Fetch for month
        if ($request->has('filter') && $request->input('filter') == '2')
            $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
            // dd("fetching month");

        $endDate = Carbon::now()->format('Y-m-d');      
        // Fetch the records from the database within the specified date range
        // dd($endDate);
        $employeeData = Report::where('login_date','>=' ,$startDate)
            ->where('login_date','<=',$endDate)
            ->select('user_id')
            ->selectRaw('SUM(total_work_hours) as total_work_hours')
            ->groupBy('user_id')
            ->orderByDesc('total_work_hours')
            ->limit(5)
            ->get();
        // dd($employeeData);
      
        // Prepare the chart data
        $labels = [];
        $series = [];
      
        foreach ($employeeData as $employee) {
          $labels[] = $employee->userName->name;
          $series[] = $employee->total_work_hours;
        }
      
        // Calculate the maximum value for y-axes
        $maxHours = $employeeData->max('total_work_hours');
      
        // Prepare the response data
        $responseData = [
          'labels' => $labels,
          'series' => $series,
          'maxHours' => $maxHours
        ];

        return response()->json($responseData);
    }

    public function getEmpRequests(Request $request)
    {
        $filter = $request->input('filter')!= null ? $request->input('filter') : '1' ;

        //EMPLOYEE REQUESTS
        //PENDING LEAVES
        $leaveService = new LeaveService();
        $data['annualLeavesRequest'] = $leaveService->leaveRequests(1,'Pending',$filter,null,null);
        $data['sickLeavesRequest'] = $leaveService->leaveRequests(2,'Pending',$filter,null,null);

        //PENDING WFH
        $wfhService = new WfhService();
        // dd($filter);
        $data['wfhRequest'] = $wfhService->wfhRequests('Pending',$filter,null,null);

        // dd($data['sickLeavesRequest']->count());

        //PENDING TIMEADJUSTMENT
        $timeAdjService = new TimeAdjustmentService();
        $data['timeAdjRequest'] = $timeAdjService->timeAdjustmentRequests('Pending',$filter,null,null);

        return response(['success' => true, 'data' => $data]);
    }

    //Get Filtered Data based on
    //Status: Approved, Rejected,Pending
    //Filter: Type(Annual,Sick,Half,Casual).... Frequency: Month 

    public function getFilteredLeaves(Request $request)
    {
        // dd($request->all());
        $status = $request->input('status');
        $type = $request->input('type');
        $freq = $request->input('freq');
        $date = $request->input('date');
        $leaveService = new LeaveService();
        $data['requests'] = $leaveService->leaveRequests($type,$status,$freq,$date,$date);

        return $data;
        // return response(['success' => true, 'leaves' => $leaves]);
    }

    //Gets Leaves table partial view
    public function getLeavesPartialView(Request $request)
    {
        // dd("getting partial view");
        $data = $this->getFilteredLeaves($request);
        return view('partial.leaves', $data);
    }

    public function getLeavesSidebarPartialView(Request $request)
    {
        $data = $this->getFilteredLeaves($request);
        if($data['requests']->count() > 0 )
        {
            return view('partial.leaves-sidebar', $data);
        } else {
            return null;
        }
    }

    public function getLeaveById($id)
    {
        $response = Leave::find($id); 
        return response(['success' => true, 'leave' => $response]);
    }

}
