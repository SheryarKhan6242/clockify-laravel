@extends('layouts.app')
@section('title')
    Locations
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
            <h2 class="page-title text-truncate text-light font-weight-medium mb-1">View Details</h2>
        </div>
        <div class="col-5 text-end">
            <button class="btn" style="width: 186px; height: 60px; margin-right: 160px; border: 1px solid #27B9C2; border-radius: 12px; color: #ffffff;">Add Employee     +</button>
        </div>        
    </div>
</div>

@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body" style="height:348px; overflow: auto;">
                        <div class="form-heading">Personal Information</div>
                        <div class="row flex-column pt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Email</label>
                                {{ aire()->email('personal_email')->placeholder('Enter Personal Email')->id('personal_email')->class('form-control pt-1')->value(isset($employee) ? $employee->personal_email : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="cnic">CNIC</label>
                                {{ aire()->input('cnic_no')->placeholder('Enter CNIC No')->id('cnic_no')->class('form-control pt-1')->value(isset($employee) ? $employee->cnic_no : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="dob">Date Of Birth</label>
                                {{ aire()->date('date_of_birth')->placeholder('Dob')->id('date_of_birth')->class('form-control pt-1')->value(isset($employee) ? $employee->date_of_birth : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="mobile-no">Personal Phone No</label>
                                {{ aire()->input('mobile_no')->placeholder('Enter Phone No')->id('mobile_no')->class('form-control pt-1')->value(isset($employee) ? $employee->mobile_no : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="emergency-no">Emergency No</label>
                                {{ aire()->input('emergency_no')->placeholder('Enter Emergency No')->id('emergency_no')->class('form-control pt-1')->value(isset($employee) ? $employee->emergency_no : '') }}

                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="personal_address">Permanent Address</label>
                                {{ aire()->input('permanent_address')->placeholder('Enter Permanent Address')->id('permanent_address')->class('form-control pt-1')->value(isset($employee) ? $employee->permanent_address : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="linkedin">Linkedin Id</label>
                                {{ aire()->input('linkedin')->placeholder('Enter Full Name')->id('linkedin')->class('form-control pt-1')->value(isset($employee) ? '' : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="skype">Skype Id</label>
                                {{ aire()->input('skype')->placeholder('Enter Full Name')->id('skype')->class('form-control pt-1')->value(isset($employee) ? '' : '') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body" style="height:348px; overflow: auto;">
                        <div class="form-heading">Financial Information</div>
                        <div class="row flex-column pt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="salary">Salary</label>
                                {{ aire()->input('salary')->placeholder('Enter Salary')->id('salary')->class('form-control pt-1')->value(isset($employee) ? $employee->salary : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="acc_holder">Account Holder name</label>
                                {{ aire()->input('acc_holder')->placeholder('Enter Account Holder Name')->id('acc_holder')->class('form-control pt-1')->value(isset($employee) ? json_decode($employee->bank_payload)->account_holder : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="acc_no">Account No + Branch Code</label>
                                {{ aire()->input('acc_no')->placeholder('Enter account')->id('acc_no')->class('form-control pt-1')->value(isset($employee) ? json_decode($employee->bank_payload)->acc_no : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="branch_location">Branch Location</label>
                                {{ aire()->input('branch_location')->placeholder('Enter branch location')->id('branch_location')->class('form-control pt-1')->value(isset($employee) ? json_decode($employee->bank_payload)->branch_location : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="branch_name">Branch Name</label>
                                {{ aire()->input('branch_name')->placeholder('Enter branch name')->id('branch_name')->class('form-control pt-1')->value(isset($employee) ? json_decode($employee->bank_payload)->branch_name : '') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="height:348px; overflow: auto;">
                        <div class="form-heading">Office Information</div>
                        <div class="row flex-column pt-3">
                            <div class="form-group mb-3">
                                <label class="form-label" for="username">Username</label>
                                {{ aire()->email('username')->placeholder('Enter username')->id('username')->class('form-control pt-1') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="official_email">Official Email</label>
                                {{ aire()->email('user_email')->placeholder('Enter official email')->id('user_email')->class('form-control pt-1')->value(isset($employee) ? $employee->user_email : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="dep_id">Department</label>
                                {{ aire()->select(Department::all()->pluck('name', 'id')->prepend('Select Department', ''),'dep_id')->id('dep_id')->class('form-control pt-1')->value(isset($employee) ? $employee->dep_id : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="emp_type">Employee type</label>
                                {{ aire()->select(EmployeeType::all()->pluck('name', 'id')->prepend('Select Employee Type', ''),'emp_type')->id('emp_type')->class('form-control pt-1')->value(isset($employee) ? $employee->emp_type : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="designation">Designation</label>
                                {{ aire()->input('designation')->placeholder('Enter Designation')->id('designation')->class('form-control pt-1')->value(isset($employee) ? $employee->designation : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="shift">Shift</label>
                                {{ aire()->select(Shift::all()->pluck('name', 'id')->prepend('Select Employee Shift', ''),'shift_id')->id('shift_id')->class('form-control pt-1')->value(isset($employee) ? $employee->shift_id : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="joining_date">Date Of Joining</label>
                                {{ aire()->date('joining_date')->placeholder('Joining Date')->id('joining_date')->class('form-control pt-1')->value(isset($employee) ? $employee->joining_date : '') }}
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="alternative_no">Office No</label>
                                {{ aire()->input('alternative_no')->placeholder('Enter Office No')->id('alternative_no')->class('form-control pt-1')->value(isset($employee) ? $employee->alternative_no : '') }}
                            </div>
                        </div>
                    </div>
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
                <h5 class="card-title emp-name pt-2 mb-0"></h5>
                <p class="card-text text-muted emp-email">name@email.com</p>
            </div>
            <div class="card ms-3 me-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6" style="position: relative;">
                            <div class="card-heading">Annual Leaves</div>
                            <ul class="list-style-none mt-4">
                                <li class="d-flex align-items-center">
                                    <i class="fas fa-circle text-cyan font-10 me-2"></i>
                                    <span class="text-muted">Availed:</span>
                                    <span class="text-light ms-2 font-weight-medium avail-annual">(0)</span>
                                </li>
                                <li class="mt-2 d-flex align-items-center">
                                    <i class="fas fa-circle text-danger font-10 me-2"></i>
                                    <span class="text-muted">Remaining</span>
                                    <span class="text-light ms-2 font-weight-medium rem-annual">(5)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <div id="campaign-v2" style="height: 134px; width: 100%; max-height: 158px;" class="mt-2 c3"></div>
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
                                    <i class="fas fa-circle text-cyan font-10 me-2"></i>
                                    <span class="text-muted">Availed:</span>
                                    <span class="text-light ms-2 font-weight-medium avail-sick">(0)</span>
                                </li>
                                <li class="mt-2 d-flex align-items-center">
                                    <i class="fas fa-circle text-danger font-10 me-2"></i>
                                    <span class="text-muted">Remaining</span>
                                    <span class="text-light ms-2 font-weight-medium rem-sick">(5)</span>
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
                            <i class="fas fa-circle text-cyan font-10 me-2"></i>
                            <span class="text-muted">Availed:</span>
                            <span class="text-light ms-2 font-weight-medium">(0)</span>
                        </li>
                        <li class="mt-2 d-flex align-items-center">
                            <i class="fas fa-circle text-danger font-10 me-2"></i>
                            <span class="text-muted">Remaining</span>
                            <span class="text-light ms-2 font-weight-medium">(5)</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col md mb-3">
                    <a href="#" id="save_emp" class="btn btn-primary pt-3">Save Changes</a>
                </div>
                <div class="col md 6">
                    <a href="#" id="cancel" class="btn btn-primary pt-3" style="background-color: #202425; border: 1px solid #27B9C2;">Cancel</a>
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

    .card.active {
        background-color: #232B2E;
    }

                .card-body::-webkit-scrollbar {
                    width: 10px;
                }

                /* Scrollbar Track */
                .card-body::-webkit-scrollbar-track {
                    background-color: #f1f1f1;
                }

                /* Scrollbar Handle */
                .card-body::-webkit-scrollbar-thumb {
                    background-color: #888;
                }

                /* Scrollbar Handle on Hover */
                .card-body::-webkit-scrollbar-thumb:hover {
                    background-color: #555;
                }
    
</style>

@endpush

@push('header-scripts')

@endpush


@push('header-scripts')

@endpush

@push('footer-scripts')
<script>

</script>
@endpush
