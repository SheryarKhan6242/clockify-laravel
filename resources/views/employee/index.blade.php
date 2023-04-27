@extends('layouts.app')
@section('title')
    Locations
@endsection
@php
 use App\Models\Country;
 use App\Models\MaritalStatus;
 use App\Models\EmployeeType;
 use App\Models\Department;
 use App\Models\Shift;
 use App\Models\Gender;

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

@endpush

@push('modals')
{{-- ADD EMP MODAL --}}
<div class="modal fade" id="add_emp_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
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
                            <span class="required">First Name</span>
                        </label>
                        {{ aire()->input('first_name')->placeholder('First Name')->id('first_name')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Last Name</span>
                        </label>
                        {{ aire()->input('last_name')->placeholder('Last Name')->id('last_name')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Gender</span>
                        </label>
                        {{ aire()->select(Gender::all()->pluck('name', 'id')->prepend('Select Gender',''), 'gen_id')->id('gen_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Marital Status</span>
                        </label>
                        {{ aire()->select(MaritalStatus::all()->pluck('status', 'id')->prepend('Select Marital status',''), 'marital_status')->id('marital_status')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Employee Type</span>
                        </label>
                        {{ aire()->select(EmployeeType::all()->pluck('name', 'id')->prepend('Select Employee type',''), 'emp_type')->id('emp_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Department</span>
                        </label>
                        {{ aire()->select(Department::all()->pluck('name', 'id')->prepend('Select Employee department',''), 'dep_id')->id('dep_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Shift</span>
                        </label>
                        {{ aire()->select(Shift::all()->pluck('name', 'id')->prepend('Select Employee shift',''), 'shift_id')->id('shift_id')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Permanent Address</span>
                        </label>
                        {{ aire()->input('permanent_address')->placeholder('Permanent Address')->id('permanent_address')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Country</span>
                        </label>
                        {{ aire()->select(Country::all()->pluck('name', 'id')->prepend('Select your country',''), 'country_id')->id('country_id')->class('form-control form-control-solid selectjs2')->value(old('country_id') ?? '')->setAttribute('onChange',"cities(this)") }}
                    </div>
                    <div class="col-md-6 fv-row city-call-back">
                        <label class="fs-6 fw-bold">
                            <span class="required">City</span>
                        </label>
                        {{ aire()->select(['' => 'Select your city'],'city_id', '')->id('city_id')->class('form-control form-control-solid')->value(old('city') ?? '') }}
                    </div>
                </div>
                <div class="row g-9">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Mobile No</span>
                        </label>
                        {{ aire()->input('mobile_no')->placeholder('Mobile No')->id('mobile_no')->class('form-control form-control-solid')->required() }}
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Emergency No</span>
                        </label>
                        {{ aire()->input('emergency_no')->placeholder('Emergency No')->id('emergency_no')->class('form-control form-control-solid')->required() }}
                    </div>
                </div>
                <div class="col-md-6 fv-row">
                    <label class="fs-6 fw-bold">
                        <span class="required">Designation</span>
                    </label>
                    {{ aire()->input('designation')->placeholder('Designation')->id('designation')->class('form-control form-control-solid')->required() }}
                </div>
                {{-- <div class="text-gray-600">Once a grade is added, it can't be deleted, only deactivated.</div> --}}
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
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">First Name</span>
                    </label>
                    {{ aire()->input('edit_first_name')->placeholder('First Name')->id('edit_first_name')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Last Name</span>
                    </label>
                    {{ aire()->input('edit_last_name')->placeholder('Last Name')->id('edit_last_name')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Gender</span>
                    </label>
                    {{ aire()->select(Gender::all()->pluck('name', 'id')->prepend('Select Gender',''), 'edit_gen_id')->id('edit_gen_id')->class('form-control form-control-solid selectjs2') }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Marital Status</span>
                    </label>
                    {{ aire()->select(MaritalStatus::all()->pluck('status', 'id')->prepend('Select Marital status',''), 'edit_marital_status')->id('edit_marital_status')->class('form-control form-control-solid selectjs2') }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Employee Type</span>
                    </label>
                    {{ aire()->select(EmployeeType::all()->pluck('name', 'id')->prepend('Select Employee type',''), 'edit_emp_type')->id('edit_emp_type')->class('form-control form-control-solid selectjs2') }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Department</span>
                    </label>
                    {{ aire()->select(Department::all()->pluck('name', 'id')->prepend('Select Employee department',''), 'edit_dep_id')->id('edit_dep_id')->class('form-control form-control-solid selectjs2') }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Shift</span>
                    </label>
                    {{ aire()->select(Shift::all()->pluck('name', 'id')->prepend('Select Employee shift',''), 'edit_shift_id')->id('edit_shift_id')->class('form-control form-control-solid selectjs2') }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Permanent Address</span>
                    </label>
                    {{ aire()->input('edit_permanent_address')->placeholder('Permanent Address')->id('edit_permanent_address')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Country</span>
                    </label>
                    {{ aire()->select(Country::all()->pluck('name', 'id')->prepend('Select your country',''), 'edit_country_id')->id('edit_country_id')->class('form-control form-control-solid selectjs2')->value(old('country_id') ?? '')->setAttribute('onChange',"cities(this)") }}
                </div>
                <div class="fv-row mb-7 city-call-back">
                    <label class="fs-6 fw-bold">
                        <span class="required">City</span>
                    </label>
                    {{ aire()->select(['' => 'Select your city'],'edit_city_id', '')->id('edit_city_id')->class('form-control form-control-solid')->value(old('city') ?? '') }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Mobile No</span>
                    </label>
                    {{ aire()->input('edit_mobile_no')->placeholder('Mobile No')->id('edit_mobile_no')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Emergency No</span>
                    </label>
                    {{ aire()->input('edit_emergency_no')->placeholder('Emergency No')->id('edit_emergency_no')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Designation</span>
                    </label>
                    {{ aire()->input('edit_designation')->placeholder('Designation')->id('edit_designation')->class('form-control form-control-solid')->required() }}
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


//AJAX TO GET EMPLOYEE DATA BY ID
function getEmpById(id){
    $.ajax({
        url:  "{{url('/employee/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // success handling
            console.log(response.employees)
            if(response.success == true && response.employees != undefined){
                //Fill Up edit modal values
                $('#edit_first_name').val(response.employees.first_name);
                $('#edit_last_name').val(response.employees.last_name);
                $('#edit_permanent_address').val(response.employees.permanent_address);
                $('#edit_country_id').val(response.employees.country_id);
                $('#edit_city_id').val(response.employees.city_id);
                $('#edit_mobile_no').val(response.employees.mobile_no);
                $('#edit_emergency_no').val(response.employees.emergency_no);
                $('#edit_marital_status').val(response.employees.marital_status);
                $('#edit_emp_type').val(response.employees.emp_type);
                $('#edit_dep_id').val(response.employees.dep_id);
                $('#edit_shift_id').val(response.employees.shift_id);
                $('#edit_designation').val(response.employees.designation);
                //Add Update employee onclick event and append ID 
                $('#update_emp').attr('onclick', $('#update_emp').attr('onclick').replace('()', '(' + response.employees.id + ')'));
                //USED LATER WHEN WE FILL UP CITIES ON EDIT
                if ($('[id^="edit_country_id"]').length) {
                    var country_id = $('#edit_country_id').val();
                    var country_ids = document.querySelectorAll("#edit_country_id");
                    url = '/cities-selected'
                    if (location.hostname == 'localhost')
                        url = '/clockify-laravel/public/ajax/cities-selected'
                    for(var i = 0; i < country_ids.length; i++){
                        let country_id = country_ids[i].value
                        // let city_id = city_ids[i].value
                        // let id = ids[i].value
                        $.ajax({
                            url: url,
                            method: 'post',
                            cache: false,
                            //contentType: false,
                            //processData: false,
                            data: { country_id: country_id }

                        }).done(function(responseData) {
                            $('#edit_country_id').replaceWith(responseData)
                            // $('.city-wrapper_'+id).html(responseData);
                        }).fail(function(responseData) {

                        }).always(function() {
                            $(".preloader").hide();
                        });
                    }
                }
                    
                $('#edit_emp_modal').modal("show");
            }
        }
    });
}
//Store Emp data via ajax
function storeEmp(){
  // get the form values
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var gen_id = $("#gen_id").val();
    var permanent_address = $("#permanent_address").val();
    var country_id = $("#country_id").val();
    var city_id = $("#city_id").val();
    var mobile_no = $("#mobile_no").val();
    var emergency_no = $("#emergency_no").val();
    var marital_status = $("#marital_status").val();
    var emp_type = $("#emp_type").val();
    var dep_id = $("#dep_id").val();
    var shift_id = $("#shift_id").val();
    var designation = $("#designation").val();

    //   make the ajax request
    $.ajax({
        url: '{{ route("emp.store") }}',
        type: 'POST',
        data: {
            first_name: first_name,
            last_name: last_name,
            gen_id: gen_id,
            permanent_address: permanent_address,
            country_id: country_id,
            city_id: city_id,
            mobile_no: mobile_no,
            emergency_no: emergency_no,
            marital_status: marital_status,
            emp_type: emp_type,
            dep_id: dep_id,
            shift_id: shift_id,
            designation: designation,
        },
        dataType: 'json',
        success: function(result) {
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
    var gen_id = $("#edit_gen_id").val();
    var permanent_address = $("#edit_permanent_address").val();
    var country_id = $("#edit_country_id").val();
    var city_id = $("#edit_city_id").val();
    var mobile_no = $("#edit_mobile_no").val();
    var emergency_no = $("#edit_emergency_no").val();
    var marital_status = $("#edit_marital_status").val();
    var emp_type = $("#edit_emp_type").val();
    var dep_id = $("#edit_dep_id").val();
    var shift_id = $("#edit_shift_id").val();
    var designation = $("#edit_designation").val();
//   make the ajax request
    $.ajax({
        url:  "{{url('/employee/update')}}/"+id,
        type: 'POST',
        data: {
            first_name: first_name,
            last_name: last_name,
            gen_id: gen_id,
            permanent_address: permanent_address,
            country_id: country_id,
            city_id: city_id,
            mobile_no: mobile_no,
            emergency_no: emergency_no,
            marital_status: marital_status,
            emp_type: emp_type,
            dep_id: dep_id,
            shift_id: shift_id,
            designation: designation,
        },
        dataType: 'json',
        success: function(result) {
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

//Delete Employee data via ajax
function deleteEmp(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/employee/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on employee type and hide form modal 
        $('.show_message').append('Employee Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}



function cities(event){
    console.log("select cities")
    url = '/ajax/cities/'
    if (location.hostname == 'localhost')
        url = '/clockify-laravel/public/ajax/cities/'
    var country_id = event.value;
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

$(".btnClosePopup").click(function () {
    $("#add_emp_modal").modal("hide");
});
</script>
@endpush
