@extends('layouts.app')
@section('title')
    Employees
@endsection
@php
    use App\Models\Country;
    use App\Models\MaritalStatus;
    use App\Models\Employee;
    use App\Models\EmployeeType;
    use App\Models\Department;
    use App\Models\Shift;
    use App\Models\Gender;
    use App\Models\EmployeeWorkingType;
    use App\Models\BankAccountType;
    
@endphp


@section('bread_crumb')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h2 class="page-title text-truncate text-light font-weight-medium mb-1">Inaequo Employees</h2>
        </div>
        <div class="col-5 text-end">
            <a class="btn pt-3" href="{{ route('emp.create') }}" style="width: 186px; height: 60px; margin-right: 160px; border: 1px solid #27B9C2; border-radius: 12px; color: #ffffff;">Add Employee     +</a>
        </div>        
    </div>
</div>

@endsection

@section('content')
    @if (isset($employees) && $employees->count() > 0)
    <div class='row'>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-heading pb-2">Your Employees</div>
                    <div class="d-flex align-items-center position-relative my-1">
                        <div class="position-relative pb-3">
                            <input type="text" name="searchTerm" id="searchTerm" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Employee" autocomplete="off" style="background-color: #202425;border: 1px solid #252E31;/*! width: 50%; */padding: 8px 0px 21px;/*! border-radius: 7px; */border: 1px solid #232B2E;border-radius: 12px;height: 60px;width: 328px;padding: 18px 16px;">
                            <img src="{{ asset('assets/images/icons/search-icon.svg') }}" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); width: 24px; height: 24px;">
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($employees as $key => $employee)
                        <div class="col-md-4">
                            <a href="#" class="card-link" onclick="handleCardClick(event, {{ json_encode($employee) }})">
                                <div class="card text-center pt-3 pb-2 @if($key === 0) active @endif" id="card-{{ $employee->id }}">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" />
                                        <h5 class="card-title pt-2 mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h5>
                                        <p class="card-text text-muted">{{ $employee->designation }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card text-center pt-3 pb-2">
                <div class="card-body">
                    <img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="employee-image rounded-circle mx-auto" width="140" height="140" />
                    <div class="mt-3 mb-2">
                        <span class="designation-badge" style="color: #EAA621; background: rgba(234, 166, 33, 0.15); font-size: 14px; padding: 8px 10px; gap: 10px; width: fit-content; height: 36px; border-radius: 8px;">Engineer</span>
                    </div>
                    <h5 class="card-title emp-name pt-2 mb-0">{{ $firstEmployee->first_name }} {{ $firstEmployee->last_name }}</h5>
                    <p class="card-text text-muted emp-email">{{ $firstEmployee->user_email }}</p>
                </div>
                <div class="card ms-3 me-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6" style="position: relative;">
                                <div class="card-heading">Annual Leaves</div>
                                <ul class="list-style-none mt-4">
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-circle font-10 me-2" style="color: #27C278"></i>
                                        <span class="text-muted">Availed:</span>
                                        <span class="text-light ms-2 font-weight-medium avail-annual">{{ isset($availableLeaves) ? $availableLeaves['availed_annual'] : (0) }}</span>
                                    </li>
                                    <li class="mt-2 d-flex align-items-center">
                                        <i class="fas fa-circle font-10 me-2" style="color: #274436"></i>
                                        <span class="text-muted">Remaining</span>
                                        <span class="text-light ms-2 font-weight-medium rem-annual">{{ isset($availableLeaves) ? $availableLeaves['remaining_annual'] : (0) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <div id="time-status" style="height: 134px; width: 100%; max-height: 158px;" class="mt-2 c3"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card ms-3 me-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6" style="position: relative;">
                                <div class="card-heading">Sick Leaves</div>
                                <ul class="list-style-none mt-4">
                                    <li class="d-flex align-items-center">
                                        <i class="fas fa-circle font-10 me-2" style="color: #8854F5"></i>
                                        <span class="text-muted">Availed:</span>
                                        <span class="text-light ms-2 font-weight-medium avail-sick">{{ isset($availableLeaves) ? $availableLeaves['availed_sick'] : (0) }}</span>
                                    </li>
                                    <li class="mt-2 d-flex align-items-center">
                                        <i class="fas fa-circle font-10 me-2" style="color: #8767CC26"></i>
                                        <span class="text-muted">Remaining</span>
                                        <span class="text-light ms-2 font-weight-medium rem-sick">{{ isset($availableLeaves) ? $availableLeaves['remaining_sick'] : (0) }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <div id="sick-chart" style="height: 134px; width: 100%; max-height: 158px;" class="mt-2 c3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card ms-3 me-3">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-sm-6 d-flex flex-column align-items-center">
                                <div class="card-heading text-center">Medical Reimbursement</div>
                                <div id="medical-chart" style="height: 134px; width: 100%; max-height: 158px;" class="mt-4 c3"></div>
                            </div>
                        </div>
                        <ul class="list-style-none mt-4">
                            <li class="d-flex align-items-center">
                                <i class="fas fa-circle font-10 me-2" style="color: #8854F5;"></i>
                                <span class="text-muted">Availed:</span>
                                <span class="text-light ms-2 font-weight-medium">(0)</span>
                            </li>
                            <li class="mt-2 d-flex align-items-center">
                                <i class="fas fa-circle font-10 me-2" style="color: #8767CC26"></i>
                                <span class="text-muted">Remaining</span>
                                <span class="text-light ms-2 font-weight-medium">(5)</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row pb-2">
                    <div class="col md mb-3">
                        <a href="{{ route('emp.show',['id' => $firstEmployee->user_id]) }}" id="view_emp" class="btn btn-primary pt-3">View Details</a>
                    </div>
                    <div class="col md 6">
                        <a href="#" id="edit_emp" class="btn btn-primary pt-3" style="background-color: #202425; border: 1px solid #27B9C2;">Edit</a>
                    </div>                
                </div>
            </div>
        </div>      
    </div>
    @else
    {{-- No Employees Found --}}
    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 349px;">
        <img src="{{ asset('assets/images/icons/add-friend.svg')}}" alt="add-friend" class="rounded-circle" width="128px" height="128px" />
        <h3 class="page-title text-truncate text-light font-weight-medium mb-1">Inaequo Employees</h3>
        <p style="color: #B3B3B3">There are no employees right now. Click the below button to add an employee.</p>
        <button class="btn btn-primary" style="width: 186px; height: 60px; border-radius: 14px;">Add Employee</button>
    </div>
    @endif
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

    .card.active {
        background-color: #232B2E;
    }
    
</style>

@endpush

@push('header-scripts')

@endpush


@push('header-scripts')

@endpush

@push('footer-scripts')
<script>
    //Active Card Click
    function handleCardClick(event, emp) {
        console.log(emp)
        event.preventDefault();
        // Remove active class from all cards
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => card.classList.remove('active'));
        // Add active class to the clicked card
        const clickedCard = document.getElementById('card-' + emp.id);
        clickedCard.classList.add('active');

        //Insert employee details on Active Card 
        var full_name = (emp.first_name) + ' ' + (emp.last_name);
        $('.emp-name').text(full_name)
        $('.designation-badge').text(emp.designation)
        $('.emp-email').text(emp.user_email)

        //Add the Id on View and Edit Employee
        var url = "{{ url('employee/show/:id') }}";
        url = url.replace(':id', emp.user_id);
        $('#view_emp').attr('href', url);

        //Get Availed, remaining sick and annual leaves
        get_availed_leaves(emp.user_id);

    }
    
    // Ajax to get Employee Annual,Sick leaves and reimbursement
    function get_availed_leaves(id) {
        $.ajax({
            url: "{{url('/leave/get-availed-leaves')}}/"+id,

            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // success handling
                if(response.success && response.data != null)
                {
                    console.log(response)
                    //Insert Leaves on Active Card
                    $('.avail-sick').text('('+ response.data.availed_sick + ')') 
                    $('.avail-annual').text('('+response.data.availed_annual + ')')
                    $('.rem-sick').text('('+response.data.remaining_sick + ')')
                    $('.rem-annual').text('('+response.data.remaining_annual + ')')
                }
            }
        });
    }

    </script>
@endpush
