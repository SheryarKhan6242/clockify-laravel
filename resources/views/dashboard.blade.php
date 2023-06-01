@extends('layouts.app')
@section('title')
Dashboard
@endsection
@section('bread_crumb')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@php
    date_default_timezone_set("Asia/Karachi");  
    $h = date('G');
    $message ="";
    if($h>=5 && $h<=11)
    {
        $message = "Good Morning";
    }else if($h>=12 && $h<=15)
    {
        $message = "Good Afternoon";
    }
    else
    {
        $message = "Good Evening";
    }
@endphp
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $message }} {{ auth()->user()->name }}!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        {{-- <div class="col-5 align-self-center">
            <div class="customize-input float-end">
                <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius">
                    <option selected>Aug 23</option>
                    <option value="1">July 23</option>
                    <option value="2">Jun 23</option>
                </select>
            </div>
        </div> --}}
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
@endsection

@section('content')
<!-- *************************************************************** -->
<!-- Start First Cards -->
<!-- *************************************************************** -->
<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-end">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">5</h2>
                            <span
                                class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none">+18.33%</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Employees
                        </h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-end ">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">2</h2>
                            <span
                                class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none">+18.33%</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Active Employees
                        </h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-end ">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">1</h2>
                            <span
                                class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none">+18.33%</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Non Active Employees
                        </h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div class="col-sm-6 col-lg-3">
        <div class="card ">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">1</h2>
                            <span
                                class="badge bg-primary font-12 text-white font-weight-medium rounded-pill ms-2 d-lg-block d-md-none">+18.33%</span>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Employees
                        </h6>
                    </div>
                    <div class="ms-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<!-- *************************************************************** -->
<!-- End First Cards -->
<!-- *************************************************************** -->
<!-- *************************************************************** -->
<!-- Start Sales Charts Section -->
<!-- *************************************************************** -->
<div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Time Status</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-style-none mb-0">
                            <li>
                                <i class="fas fa-circle text-cyan font-10 me-2"></i>
                                <span class="text-muted">Present</span>
                                <span class="text-dark float-end font-weight-medium">{{isset($totalPresents) && count($totalPresents) > 0 ? count($totalPresents) : 0}}</span>
                            </li>
                            <li class="mt-3">
                                <i class="fas fa-circle text-danger font-10 me-2"></i>
                                <span class="text-muted">Absent</span>
                                <span class="text-dark float-end font-weight-medium">{{isset($totalAbsents) && $totalAbsents > 0 ? $totalAbsents : 0}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Location</h4>
                <div class="" style="height:180px">
                    <div id="visitbylocate" style="height:100%"></div>
                </div>
                <div class="row mb-3 align-items-center mt-1 mt-5">
                    <div class="col-4 text-end">
                        <span class="text-muted font-14">Karachi</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <span class="mb-0 font-14 text-dark font-weight-medium">{{ $khiPercentage }}%</span>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-4 text-end">
                        <span class="text-muted font-14">Hydrabad</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-cyan" role="progressbar" style="width: 60%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <span class="mb-0 font-14 text-dark font-weight-medium">{{ $hydPercentage }}%</span>
                    </div>
                </div>
                {{-- <div class="row mb-3 align-items-center">
                    <div class="col-4 text-end">
                        <span class="text-muted font-14">UK</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 74%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <span class="mb-0 font-14 text-dark font-weight-medium">21%</span>
                    </div>
                </div> --}}
                <div class="row align-items-center">
                    <div class="col-4 text-end">
                        <span class="text-muted font-14">Others</span>
                    </div>
                    <div class="col-5">
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 50%"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <span class="mb-0 font-14 text-dark font-weight-medium">{{ $other }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Employee Working Hours   </h4>
                <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                <ul class="list-inline text-center mt-5 mb-2">
                    <li class="list-inline-item text-muted fst-italic">Sales for this month</li>
                </ul>
            </div>
        </div>
    </div> --}}
    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Employee Working Hours</h4>
                <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                <ul class="list-inline text-center mt-5 mb-2">
                <li class="list-inline-item text-muted fst-italic">Top 5 employees with most working hours</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Requests</h5>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ isset($wfhRequest) && $wfhRequest->count() > 0 ? $wfhRequest->count() : 0 }}</h5>
                                <a href="#" class="card-text">Work From Home</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ isset($wfhRequest) && $annualLeavesRequest->count() > 0 ? $annualLeavesRequest->count() : 0 }}</h5>
                                <a href="{{ route('leave.index', ['leaveType' => 'annual']) }}" class="card-text">Annual Leave</a>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ isset($sickLeavesRequest) && $sickLeavesRequest->count() > 0 ? $sickLeavesRequest->count() : 0 }}</h5>
                                <a href="{{ route('leave.index', ['leaveType' => 'sick']) }}" class="card-text">Sick Leave</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ isset($timeAdjRequest) && $timeAdjRequest->count() > 0 ? $timeAdjRequest->count() : 0 }}</h5>
                                <a href="#" class="card-text">Time Adjustment</a>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>      
</div>
<!-- *************************************************************** -->
<!-- End Sales Charts Section -->
<!-- *************************************************************** -->
<!-- *************************************************************** -->
<!-- Start Location and Earnings Charts Section -->
<!-- *************************************************************** -->
{{-- <div class="row">
    <div class="col-md-6 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <h4 class="card-title mb-0">Earning Statistics</h4>
                    <div class="ms-auto">
                        <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                id="dd1" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dd1">
                                <a class="dropdown-item" href="#">Insert</a>
                                <a class="dropdown-item" href="#">Update</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-4 mb-5">
                    <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                </div>
                <ul class="list-inline text-center mt-4 mb-0">
                    <li class="list-inline-item text-muted fst-italic">Earnings for this month</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recent Activity</h4>
                <div class="mt-4 activity">
                    <div class="d-flex align-items-start border-left-line pb-3">
                        <div>
                            <a href="javascript:void(0)" class="btn btn-info btn-circle mb-2 btn-item">
                                <i data-feather="shopping-cart"></i>
                            </a>
                        </div>
                        <div class="ms-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">New Product Sold!</h5>
                            <p class="font-14 mb-2 text-muted">John Musa just purchased <br> Cannon 5M
                                Camera.
                            </p>
                            <span class="font-weight-light font-14 text-muted">10 Minutes Ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start border-left-line pb-3">
                        <div>
                            <a href="javascript:void(0)"
                                class="btn btn-danger btn-circle mb-2 btn-item">
                                <i data-feather="message-square"></i>
                            </a>
                        </div>
                        <div class="ms-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">New Support Ticket</h5>
                            <p class="font-14 mb-2 text-muted">Richardson just create support <br>
                                ticket</p>
                            <span class="font-weight-light font-14 text-muted">25 Minutes Ago</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start border-left-line">
                        <div>
                            <a href="javascript:void(0)" class="btn btn-cyan btn-circle mb-2 btn-item">
                                <i data-feather="bell"></i>
                            </a>
                        </div>
                        <div class="ms-3 mt-2">
                            <h5 class="text-dark font-weight-medium mb-2">Notification Pending Order!
                            </h5>
                            <p class="font-14 mb-2 text-muted">One Pending order from Ryne <br> Doe</p>
                            <span class="font-weight-light font-14 mb-1 d-block text-muted">2 Hours
                                Ago</span>
                            <a href="javascript:void(0)"
                                class="font-14 border-bottom pb-1 border-info">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- *************************************************************** -->
<!-- End Location and Earnings Charts Section -->
<!-- *************************************************************** -->
<!-- *************************************************************** -->
<!-- Start Top Leader Table -->
<!-- *************************************************************** -->


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <h4 class="card-title">Employee Details</h4>
                    <div class="ms-auto">
                        <div class="dropdown sub-dropdown">
                            <button class="btn btn-link text-muted dropdown-toggle" type="button"
                                id="dd1" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i data-feather="more-vertical"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd1">
                                <a class="dropdown-item" href="#">Insert</a>
                                <a class="dropdown-item" href="#">Update</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                        <thead>
                            <tr class="border-0">
                                <th class="border-0 font-14 font-weight-medium text-muted">EMPLOYEE ID</th>
                                <th class="border-0 font-14 font-weight-medium text-muted px-2">EMPLOYEE</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">CLOCK IN</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">CLOCK OUT</th>
                                <th class="border-0 font-14 font-weight-medium text-muted text-center">WORKING HOURS</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">WEEKLY HOURS</th>
                                <th class="border-0 font-14 font-weight-medium text-muted">LOCATION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                            {{-- {{$employee->reportsForCurrentDate()->first()}} --}}
                            <tr>
                                <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $report->employee_id }}</td>
                                <td class="border-top-0 px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="me-3"><img
                                                src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}"
                                                alt="user" class="rounded-circle" width="45"
                                                height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $report->employee_fname }} {{ $report->employee_lname }}</h5>
                                            <span class="text-muted font-14">{{ $report->employee_designation }}</span>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td class="border-top-0 px-2 py-4"> --}}
                                    {{-- <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12"
                                            href="javascript:void(0)">DS</a>
                                        <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                            href="javascript:void(0)">SS</a>
                                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item"
                                            href="javascript:void(0)">RP</a>
                                        <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                            href="javascript:void(0)">+</a>
                                    </div> --}}
                                {{-- </td> --}}
                                <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">{{ $report->office_in }}</td>
                                {{-- <td>{{ $employee->reportsForCurrentDate->first()->office_in }}</td> --}}
                                <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">{{ $report->office_out }}</td>

                                {{-- <td>{{ $employee->reportsForCurrentDate ? $employee->reportsForCurrentDate->first()->office_in : '' }}</td> --}}
                                {{-- <td class="border-top-0 text-center px-2 py-4">
                                    <i class="fa fa-circle text-primary font-12" data-bs-toggle="tooltip" data-placement="top" title="In Testing"></i>
                                </td> --}}
                                {{-- <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">{{$employee->reportsForCurrentDate()?->office_out}}</td> --}}
                                <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">{{ $report->total_work_hours }}</td>
                                <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">{{ $report->total_work_hours }}</td>
                                <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">{{ $report->clockin_location }}</td>
                            </tr>
                            @endforeach
                            {{-- <tr>
                                <td class="px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="me-3"><img
                                                src="{{ asset('assets/images/users/widget-table-pic2.jpg')}}"
                                                alt="user" class="rounded-circle" width="45"
                                                height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Daniel
                                                Kristeen
                                            </h5>
                                            <span class="text-muted font-14">Kristeen@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted px-2 py-4 font-14">Real Homes WP Theme</td>
                                <td class="px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12"
                                            href="javascript:void(0)">DS</a>
                                        <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                            href="javascript:void(0)">SS</a>
                                        <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                            href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="text-center px-2 py-4"><i
                                        class="fa fa-circle text-success font-12"
                                        data-bs-toggle="tooltip" data-placement="top" title="Done"></i>
                                </td>
                                <td class="text-center text-muted font-weight-medium px-2 py-4">32</td>
                                <td class="font-weight-medium text-dark px-2 py-4">$85K</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="me-3"><img
                                                src="{{ asset('assets/images/users/widget-table-pic3.jpg')}}"
                                                alt="user" class="rounded-circle" width="45"
                                                height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Julian
                                                Josephs
                                            </h5>
                                            <span class="text-muted font-14">Josephs@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted px-2 py-4 font-14">MedicalPro WP Theme</td>
                                <td class="px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12"
                                            href="javascript:void(0)">DS</a>
                                        <a class="btn btn-danger rounded-circle btn-circle font-12 popover-item"
                                            href="javascript:void(0)">SS</a>
                                        <a class="btn btn-cyan rounded-circle btn-circle font-12 popover-item"
                                            href="javascript:void(0)">RP</a>
                                        <a class="btn btn-success text-white rounded-circle btn-circle font-20"
                                            href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="text-center px-2 py-4"><i
                                        class="fa fa-circle text-primary font-12"
                                        data-bs-toggle="tooltip" data-placement="top" title="Done"></i>
                                </td>
                                <td class="text-center text-muted font-weight-medium px-2 py-4">29</td>
                                <td class="font-weight-medium text-dark px-2 py-4">$81K</td>
                            </tr>
                            <tr>
                                <td class="border-bottom-0 px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="me-3"><img
                                                src="{{ asset('assets/images/users/widget-table-pic4.jpg')}}"
                                                alt="user" class="rounded-circle" width="45"
                                                height="45" /></div>
                                        <div class="">
                                            <h5 class="text-dark mb-0 font-16 font-weight-medium">Jan
                                                Petrovic
                                            </h5>
                                            <span class="text-muted font-14">hgover@gmail.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-muted px-2 py-4 font-14">Hosting Press
                                    HTML</td>
                                <td class="border-bottom-0 px-2 py-4">
                                    <div class="popover-icon">
                                        <a class="btn btn-primary rounded-circle btn-circle font-12"
                                            href="javascript:void(0)">DS</a>
                                        <a class="btn btn-success text-white font-20 rounded-circle btn-circle"
                                            href="javascript:void(0)">+</a>
                                    </div>
                                </td>
                                <td class="border-bottom-0 text-center px-2 py-4"><i
                                        class="fa fa-circle text-danger font-12"
                                        data-bs-toggle="tooltip" data-placement="top"
                                        title="In Progress"></i></td>
                                <td
                                    class="border-bottom-0 text-center text-muted font-weight-medium px-2 py-4">
                                    23</td>
                                <td class="border-bottom-0 font-weight-medium text-dark px-2 py-4">$80K
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- *************************************************************** -->
<!-- End Top Leader Table -->
<!-- *************************************************************** -->
</div>
@endsection

@section('footer')

@endsection

@push('header-css')

@endpush

@push('header-scripts')

@endpush

@push('header-css')

@endpush

@push('header-scripts')

@endpush

