<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Report;
use App\Services\ReportService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReportController extends Controller
{
    public function index()
    {
        //
        $data['reports'] = Report::paginate(5);

        $currentMonth = Carbon::now()->month; // Get the current month (1-12)
        $currentYear = Carbon::now()->year; // Get the current year

        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $monthValue = ($currentMonth - $i) > 0 ? ($currentMonth - $i) : (12 + ($currentMonth - $i));
            $yearValue = $currentMonth - $i > 0 ? $currentYear : ($currentYear - 1);
            $monthName = Carbon::create($yearValue, $monthValue, 1)->format('F Y');
            $months[$monthValue] = $monthName;
        }

        return view('report.index',compact('months'));
    }

    public function searchReport(Request $request)
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

    /**dd
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::with('userName')->find($id);
        // dd($workFromHome);
        if($report) {
            $response = [
                'success' => true,
                'report' => [
                    'id' => $report->id,
                    'name' => $report->userName->name,
                    'login_date' => $report->login_date,
                    'office_in' => $report->office_in,
                    'office_out' => $report->office_out,
                    'checkin_type' => $report->checkin_id,
                    'total_work_hours' => $report->total_work_hours
                ],
            ];
            // dd($response);
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
        // try {
            $report = Report::find($id);
            $report->update($request->all());

            return response()->json(['type' =>'success']);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['type' =>'false']);
        // }
    }

    //Returns Filtered reports based on user_id,selected month and attendance_status.
    //By Default, Present status data is returned from Filter service. 
    // Attendance Statuses: 0=>Absent, 1=> Present, 3=>All
    //eg Of Absent OR Combined Reports 2023-06-01 => null, 2023-06-02 => report object for that date.
    public function getReports(Request $request)
    {
        $report = Report::where('user_id', $request->user_id);
        
        $reportService = new ReportService();
        //The filter returns selected monthly reports for a user_id.
        $filterReports = $reportService->filterReports($request, $report)->get();
        
        //If Status is present, return the default present records
        if($request->attendance_status == 1){
            $html = View::make('report.include.tabledata', ['reports' => $filterReports])->render();
            return response()->json(['html' => $html]);
        }
        
        // Create a Carbon instance for the specified month
        $date = Carbon::createFromDate(date('Y'), $request->month, 1);

        // Get the number of days in the month
        $numberOfDays = $date->daysInMonth;

        // Generate a CarbonPeriod for the entire month
        $period = CarbonPeriod::create(
            $date->format('Y-m-d'),
            $date->copy()->addDays($numberOfDays - 1)->format('Y-m-d')
        );

        //Create two separate records. 1: For complete absent, 2 for merging absent records with the present records(All records). Based on status, return accordingly.
        $records = [];

        // Loop over each day in the month
        foreach ($period as $day) {
            $loginDate = $day->format('Y-m-d');

            // Check if a record exists for the login date in the reports collection
            $recordExists = $filterReports->contains(function ($item) use ($loginDate) {
                return $item->login_date === $loginDate;
            });

            // All Status(Absent + Present)
            if ($request->attendance_status == 3 && $recordExists) {
                $records[$loginDate] = $recordExists ? $filterReports->where('login_date', $loginDate)->first() : null;
            } else if(!$recordExists){
                //If record doesn't exist,Mark as Absent
                $records[$loginDate] = null;
            }
        }

        //Return the embedded html records
        $html = View::make('report.include.tabledata', ['reports' => $records])->render();

        return response()->json(['html' => $html]);
    }

    public function fetchTopEmployees(Request $request)
    {
        $topEmployees = Report::orderBy('total_work_hours', 'desc')
            ->take(5)
            ->get(['user_id', 'total_work_hours']);

        return response()->json($topEmployees);
    }
}
