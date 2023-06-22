@extends('layouts.app')
@section('title')
Dashboard
@endsection
@section('bread_crumb')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@php
    use Carbon\Carbon;
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
            <h2 class="page-title text-truncate text-light font-weight-medium mb-1">{{ $message }} {{ auth()->user()->name }}!</h2>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class='row'>
    <div class="col md 6">
        <div class="row">
            <div class="col 6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-heading">Time Status</div>
                        <div class="row">
                            <div class="col-sm-6" style="position: absolute; bottom: 20px; left: 0;">
                                <ul class="list-style-none mb-0">
                                  <li>
                                    <i class="fas fa-circle text-cyan font-10 me-2"></i>
                                    <span class="text-muted">Present:</span>
                                    <span class="text-light float-end font-weight-medium">{{ isset($totalPresents) && count($totalPresents) > 0 ? count($totalPresents) : 0 }}</span>
                                  </li>
                                  <li class="mt-1">
                                    <i class="fas fa-circle text-danger font-10 me-2"></i>
                                    <span class="text-muted">Absent:</span>
                                    <span class="text-light float-end font-weight-medium">{{ isset($totalAbsents) && $totalAbsents > 0 ? $totalAbsents : 0 }}</span>
                                  </li>
                                </ul>
                            </div>                      
                            <div class="col-sm-6">
                                <div id="time-status" style="height: 134px; width: 100%; max-height: 158px; position: absolute; top: 0; right: 0; left: 135px;" class="mt-2 c3"></div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col 6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-heading mb-4">Location</div>
                        <div class="row mb-3 align-items-center mt-1 mt-5">
                            <div class="col-5 text-end">
                                <span class="text-muted font-14">Karachi</span>
                            </div>
                            <div class="col-4">
                                <div class="progress" style="height: 16px; border-radius: 1000px;">
                                    <div class="progress-bar bg-cyan" role="progressbar" style="width: {{ $khiPercentage }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <span class="mb-0 font-14 text-light font-weight-medium">{{ $khiPercentage }}%</span>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-5 text-end">
                                <span class="text-muted font-14">Hyderabad</span>
                            </div>
                            <div class="col-4">
                                <div class="progress" style="height: 16px; border-radius: 1000px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $hydPercentage }}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <span class="mb-0 font-14 text-light font-weight-medium">{{ $hydPercentage }}%</span>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-5 text-end">
                                <span class="text-muted font-14">Others</span>
                            </div>
                            <div class="col-4">
                                <div class="progress" style="height: 16px; border-radius: 1000px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $other }}%; background-color: yellow;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <span class="mb-0 font-14 text-light font-weight-medium">{{ $other }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row ms-0 pe-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-heading">
                            Requests
                        </div>
                        <div class="d-flex align-items-center pb-3">
                            <div class="position-relative">
                                <select class="form-select form-select-sm text-center" id="emp-requests" name="emp-requests" style="width: 120.68px; height: 40.01px; border: 1px solid #3E6E75; border-radius: 20px; color: #fff" aria-label="Time Range">
                                    <option value="1">Weekly</option>
                                    <option value="2">Monthly</option>
                                </select>
                                <div class="arrow-down"></div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <div style="width: 50%;">
                                        <img src="{{ asset('assets/dashboard-assets/wfh.svg') }}" style="width: 100%;" alt="WFH Icon">
                                    </div>
                                    <div style="width: 80%; padding-left: 10px;">
                                        <div class="request-count wfh-count">{{ isset($wfhRequest) && $wfhRequest->count() > 0 ? $wfhRequest->count() : 0 }}</div>
                                        <p class="card-text" style="font-size: 14px;">Work From Home</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <div style="width: 50%;">
                                        <img src="{{ asset('assets/dashboard-assets/annual-leave.svg') }}" style="width: 100%;" alt="Annual Leave Icon">
                                    </div>
                                    <div style="width: 80%; padding-left: 10px;">
                                        <div class="request-count annual-count">{{ isset($annualLeavesRequest) && $annualLeavesRequest->count() > 0 ? $annualLeavesRequest->count() : 0 }}</div>
                                        <p class="card-text" style="font-size: 14px;">Annual Leave</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <div style="width: 50%;">
                                        <img src="{{ asset('assets/dashboard-assets/sick-leave.svg') }}" style="width: 100%;" alt="Sick Leave Icon">
                                    </div>
                                    <div style="width: 80%; padding-left: 10px;">
                                        <div class="request-count sick-count">{{ isset($sickLeavesRequest) && $sickLeavesRequest->count() > 0 ? $sickLeavesRequest->count() : 0 }}</div>
                                        <p class="card-text" style="font-size: 14px;">Sick Leave</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body d-flex align-items-center">
                                    <div style="width: 50%;">
                                        <img src="{{ asset('assets/dashboard-assets/time-adj.svg') }}" style="width: 100%;" alt="Time Adjustment Icon">
                                    </div>
                                    <div style="width: 80%; padding-left: 10px;">
                                        <div class="request-count time-adj-count">{{ isset($timeAdjRequest) && $timeAdjRequest->count() > 0 ? $timeAdjRequest->count() : 0 }}</div>
                                        <p class="card-text" style="font-size: 14px;">Time Adj</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="class col md 6">
        <div class="card" style="height: 96%;">
            <div class="card-body">
                {{-- <h4 class="card-heading">Employee Working Hours</h4> --}}
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-heading">
                        Employee Working Hours
                    </h4>
                    <div class="d-flex align-items-center pb-3">
                        <div class="position-relative">
                            <select class="form-select form-select-sm text-center"id="emp-work-hours" name="emp-work-hours" style="width: 120.68px; height: 40.01px; border: 1px solid #3E6E75; border-radius: 20px; color: #fff" aria-label="Time Range">
                                <option value="1">Weekly</option>
                                <option value="2">Monthly</option>
                            </select>
                            <div class="arrow-down"></div>
                        </div>
                    </div>                        
                </div>
                <div class="chart-wrapper">
                    <div class="emp-max-hours mt-4 position-relative" style="height:294px;"></div>
                </div>
                <ul class="list-inline text-center mt-5 mb-2">
                <li class="list-inline-item text-muted fst-italic">Top 5 employees with most working hours</li>
                </ul>
            </div>
        </div>   
    </div>
</div>

<div class="row"> 
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <h4 class="card-heading">Employee Details</h4>
                    <div class="ms-auto">
                        {{-- <div class="dropdown sub-dropdown">
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
                        </div> --}}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table no-wrap v-middle mb-0">
                        <thead>
                            <tr class="border-0">
                                <th class="text-white">Employee Id</th>
                                <th class="text-white px-2">Employee</th>
                                <th class="text-white">Clock in</th>
                                <th class="text-white">Clock out</th>
                                <th class="text-white">Working hrs</th>
                                <th class="text-white">Weekly hrs</th>
                                <th class="text-white">Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                            <tr>
                                <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $report->userName->username }}</td>
                                <td class="border-top-0 px-2 py-4">
                                    <div class="d-flex no-block align-items-center">
                                        <div class="me-3"><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                        <div class="">
                                            <h5 class="text-light mb-0 font-16 font-weight-medium">{{ $report->employee_fname }} {{ $report->employee_lname }}</h5>
                                            <span class="text-muted font-14">{{ $report->employee_designation }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ Carbon::parse($report->office_in)->format('g:i A') }}</td>
                                <td class="text-muted">{{ Carbon::parse($report->office_out)->format('g:i A') }}</td>
                                <td class="text-muted">{{ Carbon::parse($report->total_work_hours)->format('H:i') }} hrs</td>
                                <td class="text-muted">{{ $report->fetchWeeklyHrs($report->user_id)}} hrs</td>
                                <td class="text-muted">{{ $report->clockin_location }}</td>
                                @if ( $report->checkin_id == 3 )
                                    <td> <img src="{{ asset('assets/images/icons/client.png') }}" alt="work-badge"> </td>
                                @elseif( $report->checkin_id == 2 )
                                    <td> <img src="{{ asset('assets/images/icons/wfh.png') }}" alt="work-badge"> </td>
                                @else 
                                    <td> <img src="{{ asset('assets/images/icons/office.png') }}" alt="work-badge"> </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('footer')

@endsection

@push('header-css')
<style>
    .ct-series .ct-bar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 5px 5px 0 0;
        background-color: rgba(0, 0, 0, 0.3);
        pointer-events: none;
        z-index: 1;
    }
    .ct-bar {
        stroke-width: 24px;
    }

    .arrow-down {
    position: absolute;
    top: 50%;
    right: 18px;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid #fff;
}

/* select.form-select-sm {
    background-color: #202425;
}

select.form-select-sm option {
    background-color: #202425;
} */

    
</style>

@endpush

@push('header-scripts')

@endpush


@push('footer-scripts')
<script>
    $('#emp-requests').on('change', function() {
        var query = $('#emp-requests').val();
        // alert(query);
        $.ajax({
            url: 'ajax/get-emp-requests?filter=' + query + ' ',
            method: 'GET',
            success: function(response) {
                // Call the function to update the chart with the retrieved data
                console.log(response)
                //Set the counts to their respective cards
                $('.wfh-count').text(response.data.wfhRequest.length) 
                $('.annual-count').text(response.data.annualLeavesRequest.length) 
                $('.sick-count').text(response.data.sickLeavesRequest.length) 
                $('.time-adj-count').text(response.data.wfhRequest.length) 
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

</script>
@endpush

