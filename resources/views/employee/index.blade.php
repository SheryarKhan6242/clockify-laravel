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
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="">Employees</a>
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
<div class="card-title">
    <!--begin::Search-->
    <div class="d-flex align-items-center position-relative my-1">
        <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
        <span class="svg-icon svg-icon-1 position-absolute ms-6">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                </g>
            </svg>
        </span>
        <!--end::Svg Icon-->
        <input type="text" name="searchTerm" id="searchTerm" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Employee" autocomplete="off">
    </div>
    <!--end::Search-->
</div>
<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
    <!--begin::Add user-->
    <a href="#add_emp_modal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_emp_modal">
    <span class="svg-icon svg-icon-2">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"></rect>
            <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1"></rect>
        </svg>
    </span>
    <!--end::Svg Icon-->Add Employee</a>
</div>
{{-- <div class="card-body pt-0"> --}}
    @include('employee.include.tabledata')
<!--end::Content-->
@endsection

@section('footer')

@endsection

@push('header-css')
<style>
    .modal-dialog {
        max-width: none !important;
        width: 650px !important;
    }
</style>
@endpush

@push('modals')
{{-- ADD EMP MODAL --}}
<div class="modal fade" id="add_emp_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Add New Employee</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                        </svg>
                    </span>
                </div> --}}
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Reporting To</span>
                        </label>
                        {{ aire()->select(Employee::all()->pluck('first_name', 'id')->prepend('Select Your Lead',''), 'first_name')->id('first_name')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">Is Lead</label>
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            {{ aire()->checkbox('is_lead', '')->class('form-check-input')->id('is_lead') }}
                        </label>
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">First Name*</span>
                        </label>
                        {{ aire()->input('first_name')->placeholder('First Name')->id('first_name')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Last Name*</span>
                        </label>
                        {{ aire()->input('last_name')->placeholder('Last Name')->id('last_name')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Father Name</span>
                        </label>
                        {{ aire()->input('father_name')->placeholder('Father Name')->id('father_name')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">DOB*</span>
                        </label>
                        {{ aire()->date('dob')->placeholder('DOB')->id('dob')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Username*</span>
                        </label>
                        {{ aire()->input('username')->placeholder('Username')->id('username')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Work Type*</span>
                        </label>
                        {{ aire()->select(EmployeeWorkingType::all()->pluck('type', 'id')->prepend('Select Working Type',''), 'work_type')->id('work_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="work-type-add"></div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Email Address*</span>
                        </label>
                        {{ aire()->input('email')->placeholder('Email Address')->id('email')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Personal Email</span>
                        </label>
                        {{ aire()->input('personal_email')->placeholder('Personal Email')->id('personal_email')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Gender*</span>
                        </label>
                        {{ aire()->select(Gender::all()->pluck('name', 'id')->prepend('Select Gender',''), 'gen_id')->id('gen_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Marital Status*</span>
                        </label>
                        {{ aire()->select(MaritalStatus::all()->pluck('status', 'id')->prepend('Select Marital status',''), 'marital_status')->id('marital_status')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Employee Type*</span>
                        </label>
                        {{ aire()->select(EmployeeType::all()->pluck('name', 'id')->prepend('Select Employee type',''), 'emp_type')->id('emp_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Shift*</span>
                        </label>
                        {{ aire()->select(Shift::all()->pluck('name', 'id')->prepend('Select Employee shift',''), 'shift_id')->id('shift_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Country*</span>
                        </label>
                        {{ aire()->select(Country::all()->pluck('name', 'id')->prepend('Select your country',''), 'country_id')->id('country_id')->class('form-control form-control-solid selectjs2')->value(old('country_id') ?? '')->setAttribute('onChange',"cities(this)") }}
                    </div>
                    <div class="col-md-6 fv-row city-call-back">
                        <label class="fs-6 fw-bold">
                            <span class="required">City*</span>
                        </label>
                        {{ aire()->select(['' => 'Select your city'],'city_id', '')->id('city_id')->class('form-control form-control-solid')->value(old('city') ?? '') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Mobile No*</span>
                        </label>
                        {{ aire()->input('mobile_no')->placeholder('Mobile No')->id('mobile_no')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Emergency No*</span>
                        </label>
                        {{ aire()->input('emergency_no')->placeholder('Emergency No')->id('emergency_no')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Alternative No</span>
                        </label>
                        {{ aire()->input('alt_no')->placeholder('Alternative No')->id('alt_no')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">CNIC</span>
                        </label>
                        {{ aire()->input('cnic')->placeholder('CNIC')->id('cnic')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Permanent Address*</span>
                        </label>
                        {{ aire()->input('permanent_address')->placeholder('Permanent Address')->id('permanent_address')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Temporary Address</span>
                        </label>
                        {{ aire()->input('temporary_address')->placeholder('Temporary Address')->id('temporary_address')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Department*</span>
                        </label>
                        {{ aire()->select(Department::all()->pluck('name', 'id')->prepend('Select Employee department',''), 'dep_id')->id('dep_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Designation*</span>
                        </label>
                        {{ aire()->input('designation')->placeholder('Designation')->id('designation')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Joining Date*</span>
                        </label>
                        {{ aire()->date('joining_date')->placeholder('Joining Date')->id('joining_date')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Salary</span>
                        </label>
                        {{ aire()->input('salary')->placeholder('Salary')->id('salary')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Account Type</span>
                        </label>
                        {{ aire()->select(BankAccountType::all()->pluck('type', 'id')->prepend('Select Account Type',''), 'account_type')->id('account_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Account Holder</span>
                        </label>
                        {{ aire()->input('acc_holder')->placeholder('Enter Account Holder Name')->id('acc_holder')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Account Number</span>
                        </label>
                        {{ aire()->input('acc_no')->placeholder('Enter Account Number')->id('acc_no')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Branch Name</span>
                        </label>
                        {{ aire()->input('branch_name')->placeholder('Enter Branch Name')->id('branch_name')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Branch Location</span>
                        </label>
                        {{ aire()->input('branch_location')->placeholder('Enter Branch Location')->id('branch_location')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="emp-leaves row g-9 pb-4"></div>
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                    <a href="#" onclick="storeEmp()" class="btn btn-rounded btn-success btn-change">Add Employee</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ADD TYPE MODAL --}}

{{-- EDIT TYPE MODAL --}}
<div class="modal fade" id="edit_emp_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Edit Employee</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-permissions-modal-action="close">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                            </g>
                        </svg>
                    </span>
                </div> --}}
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="row g-9">
                    <div class="row g-9">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">First Name</span>
                            </label>
                            {{ aire()->input('edit_first_name')->placeholder('First Name')->id('edit_first_name')->class('form-control form-control-solid')->required() }}
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Last Name</span>
                            </label>
                            {{ aire()->input('edit_last_name')->placeholder('Last Name')->id('edit_last_name')->class('form-control form-control-solid')->required() }}
                        </div>
                    </div>
                    <div class="row g-9">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Father Name</span>
                            </label>
                            {{ aire()->input('edit_father_name')->placeholder('Father Name')->id('edit_father_name')->class('form-control form-control-solid')->required() }}
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">DOB*</span>
                            </label>
                            {{ aire()->date('edit_dob')->placeholder('DOB')->id('edit_dob')->class('form-control form-control-solid')->required() }}
                        </div>
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Username*</span>
                        </label>
                        {{ aire()->input('edit_username')->placeholder('Username')->id('edit_username')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Work Type*</span>
                        </label>
                        {{ aire()->select(EmployeeWorkingType::all()->pluck('type', 'id')->prepend('Select Working Type',''), 'edit_work_type')->id('edit_work_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="edit-work-type-add">
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Email Address</span>
                        </label>
                        {{ aire()->input('edit_email')->placeholder('Email Address')->id('edit_email')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Personal Email</span>
                        </label>
                        {{ aire()->input('edit_personal_email')->placeholder('Personal Email')->id('edit_personal_email')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Gender</span>
                        </label>
                        {{ aire()->select(Gender::all()->pluck('name', 'id')->prepend('Select Gender',''), 'edit_gen_id')->id('edit_gen_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Marital Status</span>
                        </label>
                        {{ aire()->select(MaritalStatus::all()->pluck('status', 'id')->prepend('Select Marital status',''), 'edit_marital_status')->id('edit_marital_status')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Employee Type</span>
                        </label>
                        {{ aire()->select(EmployeeType::all()->pluck('name', 'id')->prepend('Select Employee type',''), 'edit_emp_type')->id('edit_emp_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Shift</span>
                        </label>
                        {{ aire()->select(Shift::all()->pluck('name', 'id')->prepend('Select Employee shift',''), 'edit_shift_id')->id('edit_shift_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Country</span>
                        </label>
                        {{ aire()->select(Country::all()->pluck('name', 'id')->prepend('Select your country',''), 'edit_country_id')->id('edit_country_id')->class('form-control form-control-solid selectjs2')->value(old('country_id') ?? '')->setAttribute('onChange',"cities(this)") }}
                    </div>
                    <div class="col-md-6 fv-row city-call-back">
                        <label class="fs-6 fw-bold">
                            <span class="required">City</span>
                        </label>
                        {{ aire()->select(['' => 'Select your city'],'edit_city_id', '')->id('edit_city_id')->class('form-control form-control-solid')->value(old('city') ?? '') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Mobile No</span>
                        </label>
                        {{ aire()->input('edit_mobile_no')->placeholder('Mobile No')->id('edit_mobile_no')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Emergency No</span>
                        </label>
                        {{ aire()->input('edit_emergency_no')->placeholder('Emergency No')->id('edit_emergency_no')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Alternative No</span>
                        </label>
                        {{ aire()->input('edit_alt_no')->placeholder('Alternative No')->id('edit_alt_no')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">CNIC</span>
                        </label>
                        {{ aire()->input('edit_cnic')->placeholder('CNIC')->id('edit_cnic')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Permanent Address</span>
                        </label>
                        {{ aire()->input('edit_permanent_address')->placeholder('Permanent Address')->id('edit_permanent_address')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Temporary Address</span>
                        </label>
                        {{ aire()->input('edit_temporary_address')->placeholder('Temporary Address')->id('edit_temporary_address')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Department</span>
                        </label>
                        {{ aire()->select(Department::all()->pluck('name', 'id')->prepend('Select Employee department',''), 'edit_dep_id')->id('edit_dep_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Designation</span>
                        </label>
                        {{ aire()->input('edit_designation')->placeholder('Designation')->id('edit_designation')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Joining Date*</span>
                        </label>
                        {{ aire()->date('edit_joining_date')->placeholder('Joining Date')->id('edit_joining_date')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span>Salary</span>
                        </label>
                        {{ aire()->input('edit_salary')->placeholder('Salary')->id('edit_salary')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">Is Lead</label>
                        <label class="form-check form-switch form-check-custom form-check-solid">
                            {{ aire()->checkbox('edit_is_lead', '')->class('form-check-input')->id('edit_is_lead') }}
                        </label>
                    </div>
                </div>
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                    <a href="#" id="update_emp" onclick="updateEmp()" class="btn btn-rounded btn-success btn-change">Update Employee</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- EDIT EMP MODAL --}}
@endpush

<div class="modal fade" id="success_message" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="text-center show_message">

                </div>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
<script>

//AJAX FOR SEARCHING AND GET PAGINATION DATA
$(document).ready(function(){

$('#searchTerm').on('keyup',function(){
    search_item = $(this).val();
    var page =  $('#hidden_page').val();
    fetch_data(page,search_item);
})

$(document).on('click', '.pagination a', function(event){
    event.preventDefault(); 
    var page = $(this).attr('href').split('page=')[1];
    var search_item = $('#searchTerm').val();
    fetch_data(page,search_item);
});

function fetch_data(page,search_item)
{
    if(search_item === undefined){
        search_item = "";
    }

    $.ajax({
        url:"{{url('/employee/load-emp-table?page=')}}"+page+"&search_item="+search_item,
        success:function(data){
            $('#table').html(data);
        }
    });
}


});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Store Emp data via ajax
function storeEmp(){
  // get the form values
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var father_name = $("#father_name").val();
    var dob = $("#dob").val();
    var username = $("#username").val();
    var work_type = $("#work_type").val();
    var email = $("#email").val();
    var personal_email = $("#personal_email").val();
    var gen_id = $("#gen_id").val();
    var permanent_address = $("#permanent_address").val();
    var temporary_address = $("#temporary_address").val();
    var cnic_no = $("#cnic").val();
    var country_id = $("#country_id").val();
    var city_id = $("#city_id").val();
    var mobile_no = $("#mobile_no").val();
    var alternative_no = $("#alt_no").val();
    var emergency_no = $("#emergency_no").val();
    var marital_status = $("#marital_status").val();
    var emp_type = $("#emp_type").val();
    var dep_id = $("#dep_id").val();
    var shift_id = $("#shift_id").val();
    var designation = $("#designation").val();
    var joining_date = $("#joining_date").val();
    var salary = $("#salary").val();
    var is_lead = $("#is_lead").is(':checked');
    var per_day_hours = null
    if($('#per_day_hours').val()!= undefined && $('#per_day_hours').val()!= '' ){
        per_day_hours = $('#per_day_hours').val();
    }
     // Get the checked checkboxes
     var checkedBoxes = $('input[name="weekday[]"]:checked');
    // Loop through the checked checkboxes and get their values
    var weekdays = null;
    if(checkedBoxes !=undefined && checkedBoxes.length >0){
        var weekdays = [];
        checkedBoxes.each(function() {
            weekdays.push($(this).val());
        });
    }

    // loop through each pair of employee type and no of leaves
    var nolValues = [];
    var leaveTypeValues = [];

    $("input[name='leave_count[]']").each(function() {
        var value = $(this).val();
        nolValues.push(value);
    });

    $("select[name='leave_type[]']").each(function() {
        var value = $(this).val();
        leaveTypeValues.push(value);
    });

    //FINANCIAL INFO
    var acc_holder   = $("#acc_holder ").val();
    var account_type = $("#account_type").val();
    var acc_no = $("#acc_no").val();
    var branch_name = $("#branch_name").val();
    var branch_location = $("#branch_location").val();

    
    //   make the ajax request
    $.ajax({
        url: '{{ route("emp.store") }}',
        type: 'POST',
        data: {
            first_name: first_name,
            last_name: last_name,
            father_name: father_name,
            dob: dob,
            work_type: work_type,
            username: username,
            email:  email,
            personal_email: personal_email,
            gen_id: gen_id,
            permanent_address: permanent_address,
            temporary_address: temporary_address,
            country_id: country_id,
            city_id: city_id,
            mobile_no: mobile_no,
            alternative_no: alternative_no,
            emergency_no: emergency_no,
            cnic_no: cnic_no,
            marital_status: marital_status,
            emp_type: emp_type,
            dep_id: dep_id,
            shift_id: shift_id,
            designation: designation,
            joining_date: joining_date,
            salary: salary,
            is_lead: is_lead,
            per_day_hours: per_day_hours,
            weekdays: weekdays,
            leaveTypeValues: leaveTypeValues,
            nolValues: nolValues,
            account_holder: acc_holder,
            account_no: acc_no,
            account_type: account_type,
            branch_name: branch_name,
            branch_location: branch_location
        },
        dataType: 'json',
        success: function(result) {
        // success handling
        //Server side validation
            if(result.errors)
            {
                // jQuery.each(result.errors, function(fieldName, errorMsg){
                //     var field = $('[name="'+fieldName+'"]');
                //     field.addClass('is-invalid');
                //     field.after('<div class="invalid-feedback">'+errorMsg+'</div>');
                // });
                // // Remove the error message and is-invalid class when the user corrects the input
                // $('input, select').on('input', function() {
                //     var field = $(this);
                //     field.removeClass('is-invalid');
                //     field.next('.invalid-feedback').remove();
                // });

                jQuery.each(result.errors, function(fieldName, errorMsg){
                    var field = $('[name="'+fieldName+'"]');
                    field.html('');
                    field.addClass('is-invalid');
                    field.after('<div class="invalid-feedback">'+errorMsg+'</div>');
                });
                // Remove the error message and is-invalid class when the user corrects the input
                $('input, select').on('input', function() {
                    var field = $(this);
                    field.removeClass('is-invalid');
                    field.next('.invalid-feedback').remove();
                });
            }
            else
            {
                //Show Success message on saving Employee and hide form modal
                $('#add_emp_modal').hide() 
                $('.show_message').append('Employee Added Successfully')
                    $('#success_message').modal('show');
                    setTimeout(function(){
                        window.location.reload();
                    }, 2000);
            }
        }
    });
}

//Update Employee data via ajax
function updateEmp(id){
  // get the form values
    var first_name = $("#edit_first_name").val();
    var last_name = $("#edit_last_name").val();
    var father_name = $("#edit_father_name").val();
    var dob = $("#edit_dob").val();
    var work_type = $("#edit_work_type").val();
    var username = $("#username").val();
    var email = $("#edit_email").val();
    var personal_email = $("#edit_personal_email").val();
    var gen_id = $("#edit_gen_id").val();
    var permanent_address = $("#edit_permanent_address").val();
    var temporary_address = $("#edit_temporary_address").val();
    var country_id = $("#edit_country_id").val();
    var city_id = $("#edit_city_id").val();
    var mobile_no = $("#edit_mobile_no").val();
    var emergency_no = $("#edit_emergency_no").val();
    var alternative_no = $("#edit_alt_no").val();
    var cnic_no = $("#edit_cnic").val();
    var marital_status = $("#edit_marital_status").val();
    var emp_type = $("#edit_emp_type").val();
    var dep_id = $("#edit_dep_id").val();
    var shift_id = $("#edit_shift_id").val();
    var designation = $("#edit_designation").val();
    var joining_date = $("#edit_joining_date").val();
    var salary = $("#edit_salary").val();
    var is_lead = $("#edit_is_lead").is(':checked');
    var per_day_hours = null
    if($('#per_day_hours').val()!= undefined && $('#per_day_hours').val()!= '' ){
        per_day_hours = $('#per_day_hours').val();
    }
     // Get the checked checkboxes
     var checkedBoxes = $('input[name="weekday[]"]:checked');
    // Loop through the checked checkboxes and get their values
    var weekdays = null;
    if(checkedBoxes !=undefined && checkedBoxes.length >0){
        var weekdays = [];
        checkedBoxes.each(function() {
            weekdays.push($(this).val());
        });
    }
//   make the ajax request
    $.ajax({
        url:  "{{url('/employee/update')}}/"+id,
        type: 'POST',
        data: {
            first_name: first_name,
            last_name: last_name,
            father_name: father_name,
            dob: dob,
            work_type: work_type,
            username: username,
            email:  email,
            personal_email: personal_email,
            gen_id: gen_id,
            permanent_address: permanent_address,
            temporary_address: temporary_address,
            country_id: country_id,
            city_id: city_id,
            mobile_no: mobile_no,
            alternative_no: alternative_no,
            emergency_no: emergency_no,
            cnic_no: cnic_no,
            marital_status: marital_status,
            emp_type: emp_type,
            dep_id: dep_id,
            shift_id: shift_id,
            designation: designation,
            joining_date: joining_date,
            salary: salary,
            is_lead: is_lead,
            per_day_hours: per_day_hours,
            weekdays: weekdays,
        },
        dataType: 'json',
        success: function(result) {
            console.log("updated")
            console.log(result);
        // success handling
        //Server side validation
            if(result.errors)
            {
                jQuery.each(result.errors, function(fieldName, errorMsg){
                    var field = $('[name="'+fieldName+'"]');
                    field.addClass('is-invalid');
                    field.after('<div class="invalid-feedback">'+errorMsg+'</div>');
                });
                // Remove the error message and is-invalid class when the user corrects the input
                $('input, select').on('input', function() {
                    var field = $(this);
                    field.removeClass('is-invalid');
                    field.next('.invalid-feedback').remove();
                });
            }
            else
            {
                //Show Success message on saving employee and hide form modal
                $('#edit_emp_modal').hide() 
                $('.show_message').append('Employee Updated Successfully')
                $('#success_message').modal('show');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        }
    });
}


function cities(event){
    console.log("select cities")
    url = '/ajax/cities/'
    if (location.hostname == 'localhost')
        url = '/clockify-laravel/public/ajax/cities/'
    var country_id = event.value;
    console.log(country_id);
    $(".preloader").show();

    $.ajax({

        url: url + country_id,
        method: 'get',
        cache: false,
        contentType: false,
        processData: false,
        data: { country_id: country_id }

    }).done(function(responseData) {
        $('#city_id').replaceWith(responseData)
        // $('.city-wrapper').html(responseData);

    }).fail(function(responseData) {

    }).always(function() {

        $(".preloader").hide();

    });
}

function updateCities(event){
    console.log("select cities")
    url = '/ajax/cities/'
    if (location.hostname == 'localhost')
        url = '/clockify-laravel/public/ajax/cities/'
    var country_id = event.value;
    console.log(country_id);
    $(".preloader").show();

    $.ajax({

        url: url + country_id,
        method: 'get',
        cache: false,
        contentType: false,
        processData: false,
        data: { country_id: country_id }

    }).done(function(responseData) {
        $('#edit_city_id').replaceWith(responseData)
        // $('.city-wrapper').html(responseData);

    }).fail(function(responseData) {

    }).always(function() {

        $(".preloader").hide();

    });
}

// Add change event to the work type select box
$('#work_type').change(function() {
        // Get the selected value
        var selectedValue = $(this).find(':selected').text().trim();        
        console.log(selectedValue)
        $('.work-type-add').html('') 
        // Check if the value is Part Time
        if (selectedValue === 'Part Time') {
            console.log("Part time selected")
            // Create a new div with the integer field for per day hours
            var newDiv = $('<div class="row g-9 pb-2"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Per Day Hours*</span></label><input type="number" id="per_day_hours" name="per_day_hours" class="form-control form-control-solid" /></div></div>');
            // Insert the new div after the work type div
            $('.work-type-add').append(newDiv)
        }
        // Check if the value is Hybrid
        else if (selectedValue === 'Hybrid') {
            console.log("Hybrid selected")
            // Create a new div with the checkboxes for the weekdays
            var newDiv = $('<div class="row g-9 pb-2"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Weekdays*</span></label><div style="display: inline-flex;"><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Monday" /> Monday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Tuesday" /> Tuesday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Wednesday" /> Wednesday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Thursday" /> Thursday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Friday" /> Friday</label></div></div></div>');            // var newDiv = $('<div class="row g-9"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Weekdays*</span></label><br /><input type="checkbox" name="weekday[]" value="Monday" /> Monday<br /><input type="checkbox" name="weekday[]" value="Tuesday" /> Tuesday<br /><input type="checkbox" name="weekday[]" value="Wednesday" /> Wednesday<br /><input type="checkbox" name="weekday[]" value="Thursday" /> Thursday<br /><input type="checkbox" name="weekday[]" value="Friday" /> Friday</div></div>');
            // Insert the new div after the work type div
            $('.work-type-add').append(newDiv)
        }
        // If the value is neither Part Time nor Hybrid, remove any added fields
        else {
            $(this).closest('.fv-row').nextAll().remove();
        }
    });

// Add change event to the work type select box
$('#emp_type').change(function() {
        // Get the selected value
        var id = $(this).val();        
        console.log(id)
        $.ajax({
            url:  "{{url('/ajax/get-emp-type-leave')}}/"+id,
            type: 'GET',
            dataType: 'json',
            success: function(response){
                // console.log(response.empLeavetype.payload);
                var jsonPayload = response.empLeavetype.payload;
                var decodePayload = JSON.parse(jsonPayload)
                console.log(decodePayload);
                if (decodePayload !=undefined && decodePayload.length > 0) {
                    $('.emp-leaves').html('');
                    // Loop through each item and create a new row
                    $('.emp-leaves').append(`
                        <label class="fs-6 fw-bold">
                            <span class="required">Leaves</span>
                        </label>
                    `);
                    for(var i = 0; i < decodePayload.length; i++){
                        var leave_type = decodePayload[i].leave_type;
                        var nol = decodePayload[i].nol;
                        var row = $('<div>', { class: 'emp-leaves' });
                        // Create leave type select box and preselect the option
                        console.log(leave_type == 1)
                        var leaveTypeSelect = `
                        <div class="row g-9 leaves-row">
                            <div class="col-sm-5">
                                <select class="form-control form-control-solid selectjs2 leave-type text-gray-900" data-aire-component="select" name="leave_type[]" id="leave_type[]" data-aire-for="leave_type">
                                    <option value="">
                                        Select Leave type
                                    </option>
                                    <option value="1" ${leave_type == 1 ? ' selected' : ''}>
                                        Annual
                                    </option>
                                    <option value="2" ${leave_type == 2 ? ' selected' : ''}>
                                        Sick
                                    </option>
                                    <option value="3" ${leave_type == 3 ? ' selected' : ''}>
                                        Casual
                                    </option>
                                    <option value="4" ${leave_type == 4 ? ' selected' : ''}>
                                        Half Day
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control form-control-solid leave-count p-2 text-base rounded-sm text-gray-900" data-aire-component="input" name="leave_count[]" placeholder="No Of Leaves" id="leave_count[]" value="${nol}" required="" data-aire-for="leave_count">
                            </div>
                            <div class= 'col-md-2 pb-2'>
                                    <button type="button" class="remove-leave btn btn-rounded btn-danger">Remove</button>
                            </div>
                        </div>
                        `;
                        // Append columns to row
                        $('.emp-leaves').append(leaveTypeSelect);
                    }
                }
            },
        });
        // $('.work-type-add').html('') 
        // // Check if the value is Part Time
        // if (selectedValue === 'Part Time') {
        //     console.log("Part time selected")
        //     // Create a new div with the integer field for per day hours
        //     var newDiv = $('<div class="row g-9 pb-2"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Per Day Hours*</span></label><input type="number" id="per_day_hours" name="per_day_hours" class="form-control form-control-solid" /></div></div>');
        //     // Insert the new div after the work type div
        //     $('.work-type-add').append(newDiv)
        // }
        // // Check if the value is Hybrid
        // else if (selectedValue === 'Hybrid') {
        //     console.log("Hybrid selected")
        //     // Create a new div with the checkboxes for the weekdays
        //     var newDiv = $('<div class="row g-9 pb-2"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Weekdays*</span></label><div style="display: inline-flex;"><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Monday" /> Monday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Tuesday" /> Tuesday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Wednesday" /> Wednesday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Thursday" /> Thursday</label><label style="padding: 0 10px;"><input type="checkbox" name="weekday[]" value="Friday" /> Friday</label></div></div></div>');            // var newDiv = $('<div class="row g-9"><div class="col-md-6 fv-row"><label class="fs-6 fw-bold"><span class="required">Weekdays*</span></label><br /><input type="checkbox" name="weekday[]" value="Monday" /> Monday<br /><input type="checkbox" name="weekday[]" value="Tuesday" /> Tuesday<br /><input type="checkbox" name="weekday[]" value="Wednesday" /> Wednesday<br /><input type="checkbox" name="weekday[]" value="Thursday" /> Thursday<br /><input type="checkbox" name="weekday[]" value="Friday" /> Friday</div></div>');
        //     // Insert the new div after the work type div
        //     $('.work-type-add').append(newDiv)
        // }
        // // If the value is neither Part Time nor Hybrid, remove any added fields
        // else {
        //     $(this).closest('.fv-row').nextAll().remove();
        // }
    });

    // Remove leave row
    $('.modal-body').on('click', '.remove-leave', function() {
        // $(this).parent().remove();  // Remove leave row
        $(this).closest(".leaves-row").remove();
    });


$(".btnClosePopup").click(function () {
    $("#add_emp_modal").modal("hide");
});
</script>
@endpush