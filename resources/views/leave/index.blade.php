@extends('layouts.app')
@section('title')
Leaves
@endsection
@section('bread_crumb')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@php
    use Carbon\Carbon;
    use App\Models\LeaveType;
    $leaveTypes = LeaveType::all();
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
                        <li class="breadcrumb-item"><a href="">Leaves</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="toast-bar mt-3 pt-2" style="display: none;">
        <span class="toast-icon"></span>
        <span class="toast-message" style="vertical-align: top;"></span>
    </div>
</div>
@endsection

@section('content')
<div class='row'>
    <div class="col-md-8">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="card-heading">Approved Leaves</div>
                            <div class="d-flex align-items-center pb-3">
                                <div class="position-relative me-2">
                                    <select class="form-select form-select-sm text-center filter-selector" id="approved-leave-type" name="approved-leave-type" aria-label="Time Range">
                                        @foreach ($leaveTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="arrow-down"></div>
                                </div>
                                <div class="position-relative">
                                    <select class="form-select form-select-sm text-center filter-selector" id="approved-frequency" name="approved-frequency" aria-label="Time Range">
                                        <option value="2">Monthly</option>
                                        <option value="1">Weekly</option>
                                    </select>
                                    <div class="arrow-down"></div>
                                </div>
                            </div>                        
                        </div>
                        <div class="table-container">
                            <div class="table-responsive">
                                <table id="approved-table" class="table no-wrap v-middle mb-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="text-white">Employee Id</th>
                                            <th class="text-white px-2">Employee</th>
                                            <th class="text-white">From</th>
                                            <th class="text-white">To</th>
                                            <th class="text-white">Leave Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- {{dd($approvedRequests)}} --}}
                                        @if (isset($approvedRequests))
                                        @foreach ($approvedRequests as $request)
                                        <tr>
                                            <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $request->userName->username }}</td>
                                            <td class="border-top-0 px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="me-3"><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-light mb-0 font-16 font-weight-medium">{{ "First name" }} </h5>
                                                        <span class="text-muted font-14">{{ "Engineer" }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ Carbon::parse($request->start_date)->format('m/d/y') }}</td>
                                            <td class="text-muted">{{ Carbon::parse($request->end_date)->format('m/d/y') }}</td>
                                            <td>
                                                @if ( $request->leave_type_id == 1 )
                                                    <img src="{{ asset('assets/images/icons/annual-leave.svg') }}" alt="annual-badge">
                                                @elseif( $request->leave_type_id == 2 )
                                                    <img src="{{ asset('assets/images/icons/sick-leave.svg') }}" alt="sick-badge">
                                                @elseif($request->leave_type_id == 3) 
                                                    <img src="{{ asset('assets/images/icons/casual-leave.svg') }}" alt="casual-badge">
                                                @elseif($request->leave_type_id == 4) 
                                                    <img src="{{ asset('assets/images/icons/half-day.svg') }}" alt="half-day-badge">
                                                @endif
                                            </td>
                                            <td><a href="#" onclick="view_approved_leaves({{$request->id}})"  class="text-white">Details</a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="card-heading">Rejected Leaves</div>
                            <div class="d-flex align-items-center pb-3">
                                <div class="position-relative me-2">
                                    <select class="form-select form-select-sm text-center filter-selector" id="rejected-leave-type" name="rejected-leave-type" aria-label="Time Range">
                                        @foreach ($leaveTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="arrow-down"></div>
                                </div>
                                <div class="position-relative">
                                    <select class="form-select form-select-sm text-center" id="rejected-frequency" name="rejected-frequency" style="width: 120.68px; height: 40.01px; border: 1px solid #3E6E75; border-radius: 20px; color: #fff" aria-label="Time Range">
                                        <option value="2">Monthly</option>
                                        <option value="1">Weekly</option>
                                    </select>
                                    <div class="arrow-down"></div>
                                </div>
                            </div>                        
                        </div>
                        <div class="table-container">
                            <div class="table-responsive">
                                <table id="rejected-table" class="table no-wrap v-middle mb-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="text-white">Employee Id</th>
                                            <th class="text-white px-2">Employee</th>
                                            <th class="text-white">From</th>
                                            <th class="text-white">To</th>
                                            <th class="text-white">Leave Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($rejectedRequests))
                                        @foreach ($rejectedRequests as $request)
                                        <tr>
                                            <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $request->userName->username }}</td>
                                            <td class="border-top-0 px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="me-3"><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-light mb-0 font-16 font-weight-medium">{{ "First name" }}</h5>
                                                        <span class="text-muted font-14">{{ "Engineer" }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ Carbon::parse($request->start_date)->format('m/d/y') }}</td>
                                            <td class="text-muted">{{ Carbon::parse($request->end_date)->format('m/d/y') }}</td>
                                            <td>
                                                @if ( $request->leave_type_id == 1 )
                                                    <img src="{{ asset('assets/images/icons/annual-leave.svg') }}" alt="annual-badge">
                                                @elseif( $request->leave_type_id == 2 )
                                                    <img src="{{ asset('assets/images/icons/sick-leave.svg') }}" alt="sick-badge">
                                                @elseif($request->leave_type_id == 3) 
                                                    <img src="{{ asset('assets/images/icons/casual-leave.svg') }}" alt="casual-badge">
                                                @elseif($request->leave_type_id == 4) 
                                                    <img src="{{ asset('assets/images/icons/half-day.svg') }}" alt="half-day-badge">
                                                @endif
                                            </td>
                                            <td><a href="#" onclick="view_rejected_leaves({{$request->id}})" class="text-white">Details</a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="card-heading">Pending Leaves</div>
                            <div class="d-flex align-items-center pb-3">
                                <div class="position-relative me-2">
                                    <select class="form-select form-select-sm text-center filter-selector" id="pending-leave-type" name="pending-leave-type" aria-label="Time Range">
                                        @foreach ($leaveTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="arrow-down"></div>
                                </div>
                                <div class="position-relative">
                                    <select class="form-select form-select-sm text-center filter-selector" id="pending-frequency" name="pending-frequency" aria-label="Time Range">
                                        <option value="2">Monthly</option>
                                        <option value="1">Weekly</option>
                                    </select>
                                    <div class="arrow-down"></div>
                                </div>
                            </div>                        
                        </div>
                        <div class="table-container">
                            <div class="table-responsive">
                                <table id="pending-table" class="table no-wrap v-middle mb-0">
                                    <thead>
                                        <tr class="border-0">
                                            <th class="text-white">Employee Id</th>
                                            <th class="text-white px-2">Employee</th>
                                            <th class="text-white">From</th>
                                            <th class="text-white">To</th>
                                            <th class="text-white">Leave Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($pendingRequests))
                                        @foreach ($pendingRequests as $request)
                                        <tr>
                                            <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $request->userName->username }}</td>
                                            <td class="border-top-0 px-2 py-4">
                                                <div class="d-flex no-block align-items-center">
                                                    <div class="me-3"><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                                    <div class="">
                                                        <h5 class="text-light mb-0 font-16 font-weight-medium">{{ "First name" }}</h5>
                                                        <span class="text-muted font-14">{{ "Engineer" }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted">{{ Carbon::parse($request->start_date)->format('m/d/y') }}</td>
                                            <td class="text-muted">{{ Carbon::parse($request->end_date)->format('m/d/y') }}</td>
                                            <td>
                                                @if ( $request->leave_type_id == 1 )
                                                    <img src="{{ asset('assets/images/icons/annual-leave.svg') }}" alt="annual-badge">
                                                @elseif( $request->leave_type_id == 2 )
                                                    <img src="{{ asset('assets/images/icons/sick-leave.svg') }}" alt="sick-badge">
                                                @elseif($request->leave_type_id == 3) 
                                                    <img src="{{ asset('assets/images/icons/casual-leave.svg') }}" alt="casual-badge">
                                                @elseif($request->leave_type_id == 4) 
                                                    <img src="{{ asset('assets/images/icons/half-day.svg') }}" alt="half-day-badge">
                                                @endif
                                            </td>
                                            <td><a href="#" onclick="view_pending_leaves({{$request->id}})" class="text-white">Details</a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card pt-3 pb-2">
            <div class="card ms-3 me-3">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 d-flex flex-column align-items-center">
                            <div class="card-heading text-left">Leaves</div>
                            <div id="medical-chart" style="height: 134px; width: 100%; max-height: 158px;" class="mt-4 c3"></div>
                        </div>
                    </div>
                    <ul class="list-style-none mt-4">
                        <li class="d-flex align-items-center">
                            <i class="fas fa-circle text-cyan font-10 me-2"></i>
                            <span class="text-muted">Annual:</span>
                            <span class="text-light ms-2 font-weight-medium">{{isset($approvedAnnualCount) ? $approvedAnnualCount : (0) }}</span>
                        </li>
                        <li class="mt-2 d-flex align-items-center">
                            <i class="fas fa-circle text-purple font-10 me-2"></i>
                            <span class="text-muted">Sick:</span>
                            <span class="text-light ms-2 font-weight-medium">{{isset($approvedSickCount) ? $approvedSickCount : (0) }}</span>
                        </li>
                        <li class="mt-2 d-flex align-items-center">
                            <i class="fas fa-circle text-danger font-10 me-2"></i>
                            <span class="text-muted">Casusal:</span>
                            <span class="text-light ms-2 font-weight-medium">{{isset($approvedCasualCount) ? $approvedCasualCount : (0) }}</span>
                        </li>
                        <li class="mt-2 d-flex align-items-center">
                            <i class="fas fa-circle text-success font-10 me-2"></i>
                            <span class="text-muted">Half Day:</span>
                            <span class="text-light ms-2 font-weight-medium">{{isset($approvedHalfCount) ? $approvedHalfCount : (0) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="calendar"></div>
            <h4 class="card-heading ps-3 pt-2"> Approved Leaves </h4>
            <div class="approved-sidebar card ms-3 me-3">
                <div class="card-body">
                    @if ($approvedLeavesToday->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table">
                            <tbody class="text-gray-600 fw-bold" id="tbody_render">
                            @foreach ($approvedLeavesToday as $leave)
                                <tr>
                                    <td><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></td>
                                    <td style="padding: 10px 0;">
                                        <h5 class="text-light mb-0 font-16 font-weight-light">{{ "First name" }}</h5>
                                        <span class="text-muted font-14">{{ "Engineer" }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" id="{{$leave->id}}" class="font-14 font-weight-light" style="color: #fff;">View Reason</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p class="ps-3"> No Approved Leaves found!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- <div id='calendar'></div> --}}
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

    select.form-select-sm {
        background-color: #202425;
    }

    select.form-select-sm option {
        background-color: #202425;
    }

    #calendar {
        max-width: none;
        margin: 0 auto;
    }
    /* .datedreamer__calendar {
        max-width: none !important;
    } */

    /* .form-group {
        border-radius: none !important;
        border: none;
        border-bottom: 1px solid #232B2E;
    } */
</style>

@endpush

@push('modals')
{{-- VIEW PENDING LEAVES --}}
<div class="modal fade" id="view-pending-details" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header" style="border-top: 5px solid #B3B3B3;">
                <h3 class="modal-heading">Details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y my-7">
                <div class="row pt-3">
                    <div class="mb-3">
                        <label class="form-label" for="emp-id">Employee ID</label>
                        {{ aire()->input('p_emp_id')->id('p_emp_id')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="start_date">From</label>
                            {{ aire()->date('p_start_date')->id('p_start_date')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="end_date">To</label>
                            {{ aire()->date('p_end_date')->id('p_end_date')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="mb-3">
                        <label class="form-label" for="date_sub">Date Submission</label>
                        {{ aire()->date('p_date_sub')->id('p_date_sub')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3 mx-0">
                    <div class="mb-3" style="border: 1px solid #232B2E; border-radius: 12px;">
                        <label class="form-label ps-0" for="reason">Leave Reason</label>
                        {{ aire()->textarea('p_reason')->id('p_reason')->rows(2)->cols(3)->class('form-control pt-1')->readOnly() }}
                    </div>
                </div>
                <label class="form-label" for="rej_reason">(Optional)</label>
                <div class="row pt-3 mx-0">
                    <div class="mb-3" style="border: 1px solid #232B2E; border-radius: 12px;">
                        <label class="form-label ps-0" for="rej_reason">Rejected Reason</label>
                        {{ aire()->textarea('p_rej_reason')->placeholder('Enter rejected reason')->id('p_rej_reason')->rows(2)->cols(3)->class('form-control pt-1 ps-0') }}
                    </div>
                </div>
                <div class="d-flex justify-content-between pt-3">
                    <a href="#" onclick="update_leave_status(0)" id="reject_leave" class="btn btn-rejected pt-3">Reject</a>
                    <a href="#" onclick="update_leave_status(1)" id="approve_leave" class="btn btn-primary pt-3">Approve</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id='p_leave_id' value="">
</div>
{{-- VIEW PENDING LEAVES --}}

{{-- VIEW APPROVED LEAVES --}}
<div class="modal fade" id="view-approved-details" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header" style="border-top: 5px solid #27B9C2;">
                <h3 class="modal-heading">Details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y my-7">
                <div class="row pt-3">
                    <div class="mb-3">
                        <label class="form-label" for="emp-id">Employee ID</label>
                        {{ aire()->input('a_emp_id')->id('a_emp_id')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="start_date">From</label>
                            {{ aire()->date('a_start_date')->id('a_start_date')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="end_date">To</label>
                            {{ aire()->date('a_end_date')->id('a_end_date')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="mb-3">
                        <label class="form-label" for="date_sub">Date Submission</label>
                        {{ aire()->date('a_date_sub')->id('a_date_sub')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3 mx-0">
                    <div class="mb-3" style="border: 1px solid #232B2E; border-radius: 12px;">
                        <label class="form-label ps-0" for="reason">Leave Reason</label>
                        {{ aire()->textarea('a_reason')->id('a_reason')->rows(2)->cols(3)->class('form-control pt-1')->readOnly() }}
                    </div>
                </div>
                {{-- <div class="d-flex justify-content-between pt-3">
                    <a href="#" onclick="add_leave_type()" id="add_leave_type" class="btn btn-rejected pt-3">Rejected</a>
                    <a href="#" onclick="add_leave_type()" id="add_leave_type" class="btn btn-primary pt-3">Approve</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
{{-- VIEW APPROVED LEAVES --}}

{{-- VIEW REJECTED LEAVES --}}
<div class="modal fade" id="view-rejected-details" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header" style="border-top: 5px solid #F04F4F;">
                <h3 class="modal-heading">Details</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y my-7">
                <div class="row pt-3">
                    <div class="mb-3">
                        <label class="form-label" for="emp-id">Employee ID</label>
                        {{ aire()->input('r_emp_id')->id('r_emp_id')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="start_date">From</label>
                            {{ aire()->date('r_start_date')->id('r_start_date')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="end_date">To</label>
                            {{ aire()->date('r_end_date')->id('r_end_date')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="mb-3">
                        <label class="form-label" for="date_sub">Date Submission</label>
                        {{ aire()->date('r_date_sub')->id('r_date_sub')->class('form-control pt-1')->style('border-bottom: 1px solid #232B2E;')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3 mx-0">
                    <div class="mb-3" style="border: 1px solid #232B2E; border-radius: 12px;">
                        <label class="form-label ps-0" for="reason">Leave Reason</label>
                        {{ aire()->textarea('r_reason')->id('r_reason')->rows(2)->cols(3)->class('form-control pt-1')->readOnly() }}
                    </div>
                </div>
                <div class="row pt-3 mx-0">
                    <div class="mb-3" style="border: 1px solid #232B2E; border-radius: 12px;">
                        <label class="form-label ps-0" for="rej_reason">Rejected Reason</label>
                        {{ aire()->textarea('r_rejected_reason')->placeholder('Enter rejected reason')->id('r_rejected_reason')->rows(2)->cols(3)->class('form-control pt-1 ps-0')->readOnly() }}
                    </div>
                </div>
                {{-- <div class="d-flex justify-content-between pt-3">
                    <a href="#" onclick="add_leave_type()" id="add_leave_type" class="btn btn-rejected pt-3">Rejected</a>
                    <a href="#" onclick="add_leave_type()" id="add_leave_type" class="btn btn-primary pt-3">Approve</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
{{-- VIEW REJECTED LEAVES --}}

@endpush

@push('header-scripts')

@endpush


@push('footer-scripts')
<script>
const today = new Date();
const yyyy = today.getFullYear();
let mm = today.getMonth() + 1; // Months start at 0!
let dd = today.getDate();
if (dd < 10) dd = '0' + dd;
if (mm < 10) mm = '0' + mm;
const formattedToday = mm + '/' + dd + '/' + yyyy;
// alert(formattedToday)

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//#############################APPROVED LEAVES FILTER###################################

//FREQUENCY FILTERS
$('#approved-frequency').on('change', function() {
    //Get selected frequency
    var freq = $('#approved-frequency').val();
    //Get Selected leave type
    var type = $('#approved-leave-type').val();
    getLeavesPartialView('Approved',type,freq);
});
//FREQUENCY FILTERS

//TYPE FILTERS
$('#approved-leave-type').on('change', function() {
    var type = $('#approved-leave-type').val();
    var freq = $('#approved-frequency').val();

    getLeavesPartialView('Approved',type,freq);
});
//TYPE FILTERS
//#############################APPROVED LEAVES FILTER###################################

//#############################REJECTED LEAVES FILTER###################################
//FREQUENCY FILTERS
$('#rejected-frequency').on('change', function() {
    var freq = $('#rejected-frequency').val();
    var type = $('#rejected-leave-type').val();
    getLeavesPartialView('Rejected',type,freq);
});
//FREQUENCY FILTERS

//TYPE FILTERS
$('#rejected-leave-type').on('change', function() {
    var type = $('#rejected-leave-type').val();
    var freq = $('#rejected-frequency').val();
    getLeavesPartialView('Rejected',type,freq);
});
//TYPE FILTERS
//#############################REJECTED LEAVES FILTER###################################

//#############################PENDING LEAVES FILTER###################################
//FREQUENCY FILTERS
$('#pending-frequency').on('change', function() {
    var freq = $('#pending-frequency').val();
    var type = $('#pending-leave-type').val();
    getLeavesPartialView('Pending',type,freq);
});
//FREQUENCY FILTERS

//TYPE FILTERS
$('#pending-leave-type').on('change', function() {
    var type = $('#pending-leave-type').val();
    var freq = $('#pending-frequency').val();
    getLeavesPartialView('Pending',type,freq);
    
});
//TYPE FILTERS
//#############################PENDING LEAVES FILTER###################################

//The requests gets the data based on filter and query
//Type: Sick,Annual,Casual,Half
//Freq: Weekly, Monthly)
//Status: Approved,Rejected,Pending
function getLeavesPartialView(status,type,freq) {
    $.ajax({
        url: 'ajax/get-leaves-partial?status=' + status + '&' + 'type=' + type + '&' + 'freq=' + freq,
        method: 'GET',
        success: function(response) {
            console.log(response)
            if(status == 'Pending')
            {
                $('#pending-table > tbody').html(response)
            } else if (status == 'Approved') {
                $('#approved-table > tbody').html(response)
            } else {
                $('#rejected-table > tbody').html(response)
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

new datedreamer.calendar({
    element: "#calendar",
    // select date on init
    selectedDate: formattedToday,
    // date format
    format: "MM/DD/YYYY",
    // custom next/prev icons
    iconNext: '',
    iconPrev: '',
    // set the label of the date input
    // inputLabel: 'Set a date',
    // set the placeholder of the date input
    // inputPlaceholder: 'Enter a date',
    // hide the input and today button
    hideInputs: true,
    // enable dark mode
    darkMode: true,
    // or 'lite-purple'
    theme: 'lite-purple',
    // custom styles here
    // styles: `
    //   button {
    //     color: yellow   
    //   }
    // `,
    // callback
    onChange: (e) => {
        // alert(e.detail);
        const dateString = e.detail;
        const parts = dateString.split('/');
        const year = parts[2];
        const month = parts[0].padStart(2, '0');
        const day = parts[1].padStart(2, '0');
        const formatted_date = `${year}-${month}-${day}`;
        var url = 'ajax/get-leaves-sidebar-partial?status=Approved' + '&' + 'date=' + formatted_date  
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if(response && response != null){
                    $('.approved-sidebar .card-body').html(response) 
                } else {
                    $('.approved-sidebar .card-body').html('')
                    $('.approved-sidebar .card-body').append('<p> No Approved Leaves Found! </p')
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    },
    onRender: (e) => {
      console.log(e.detail.calendar);
      $(".datedreamer__calendar dark");
    },
})


function view_approved_leaves(id) {
    $.ajax({
        url: 'ajax/get-leave/' + id,
        method: 'GET',
        success: function(response) {
            if(response.success)
            {
                //Fill up the modal
                $('#a_emp_id').val(response.leave.user_id)
                $('#a_start_date').val(response.leave.start_date)
                $('#a_end_date').val(response.leave.end_date)
                const dateTimeString = response.leave.created_at;
                const submission_date = dateTimeString.substring(0, 10);
                $('#a_date_sub').val(submission_date)
                $('#a_reason').val(response.leave.description)
                $('#view-approved-details').modal('show');
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function view_pending_leaves(id) {
    $.ajax({
        url: 'ajax/get-leave/' + id,
        method: 'GET',
        success: function(response) {
            if(response.success)
            {
                $('#p_emp_id').val(response.leave.user_id)
                $('#p_start_date').val(response.leave.start_date)
                $('#p_end_date').val(response.leave.end_date)
                const dateTimeString = response.leave.created_at;
                const submission_date = dateTimeString.substring(0, 10);
                $('#p_date_sub').val(submission_date)
                $('#p_reason').val(response.leave.description)
                // Add id in hidden field
                $('#p_leave_id').val(id)
                $('#view-pending-details').modal('show');
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function view_rejected_leaves(id) {
    $.ajax({
        url: 'ajax/get-leave/' + id,
        method: 'GET',
        success: function(response) {
            if(response.success)
            {
                $('#r_emp_id').val(response.leave.user_id)
                $('#r_start_date').val(response.leave.start_date)
                $('#r_end_date').val(response.leave.end_date)
                const dateTimeString = response.leave.created_at;
                const submission_date = dateTimeString.substring(0, 10);
                $('#r_date_sub').val(submission_date)
                $('#r_reason').val(response.leave.description)
                $('#r_rejected_reason').val(response.leave.reason)
                $('#view-rejected-details').modal('show');
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function update_leave_status(status) {
    //Get hidden leave id
    var id = $('#p_leave_id').val();
    var rejected_reason = $('#p_rej_reason').val()
    $.ajax({
        url: 'leave/update-leave-status',
        method: 'POST',
        data: {
            id: id,
            status: status,
            p_rej_reason: rejected_reason
        },
        success: function(response) {
            if(response.errors)
            {
                jQuery.each(response.errors, function(fieldName, errorMsg){
                    var field = $('[name="'+fieldName+'"]');
                    if (!field.hasClass('is-invalid')) {
                        field.addClass('is-invalid');
                        field.after('<div class="invalid-feedback">' + errorMsg + '</div>');
                    }
                });
                // Remove the error message and is-invalid class when the user corrects the input
                $('input, select').on('input', function() {
                    var field = $(this);
                    field.removeClass('is-invalid');
                    field.next('.invalid-feedback').remove();
                });
            } else {
                //Show Success message on updating leave status and hide form modal
                $('#view-pending-details').modal('hide') 
                $('.toast-bar').removeClass('toast-danger').addClass('toast-success');
                $('.toast-icon').removeClass().addClass('toast-icon-success');
                $('.toast-message').text(response.message);
                $('.toast-bar').show();        
                $('.toast-bar').fadeIn().delay(2000).fadeOut();
                location.reload(); 
            }
        },
        error: function(error) {
            $('#add-leave-type').modal('hide') 
            $('.toast-bar').removeClass('toast-success').addClass('toast-danger');
            $('.toast-icon').removeClass().addClass('toast-icon-danger');
            $('.toast-message').text('Error occurred during the request.');
            $('.toast-bar').show();
            $('.toast-bar').fadeIn().delay(2000).fadeOut();
        }
    });

    // update-leave-status
}

</script>
@endpush

