@extends('layouts.app')
@section('title')
    Employee Types
@endsection
@php
 use App\Models\LeaveType;
@endphp
@section('bread_crumb')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="">Employee Types</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
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
        <input type="text" name="searchTerm" id="searchTerm" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Types" autocomplete="off">
    </div>
    <!--end::Search-->
</div>
<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
    <!--begin::Add user-->
    <a href="#add_emp_type_modal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_emp_type_modal">
    <span class="svg-icon svg-icon-2">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"></rect>
            <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1"></rect>
        </svg>
    </span>
    <!--end::Svg Icon-->Add Employee Type</a>
</div>
{{-- <div class="card-body pt-0"> --}}
    @include('empType.include.tabledata')
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
{{-- ADD EMPLOYEE TYPE MODAL --}}
<div class="modal fade" id="add_emp_type_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Add New Type</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Type</span>
                    </label>
                    {{ aire()->input('name')->placeholder('Employee Type')->id('name')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" data-dismiss="modal" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                    <a href="#" onclick="storeType()" class="btn btn-rounded btn-success btn-change">Add Type</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ADD EMPLOYEE TYPE MODAL --}}

{{-- EDIT EMPLOYEE TYPE MODAL --}}
<div class="modal fade" id="edit_emp_type_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Edit Type</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="fv-row mb-7">
                    <label class="fs-6 fw-bold">
                        <span class="required">Type</span>
                    </label>
                    {{ aire()->input('name')->placeholder('Employee Type')->id('edit_name')->class('form-control form-control-solid')->required() }}
                </div>
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                    <a href="#" id="update_emp_type" onclick="updateType()" class="btn btn-rounded btn-success btn-change">Update Type</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- EDIT EMPLOYEE TYPE MODAL --}}

{{-- ADD EMPLOYEE TYPE LEAVE MODAL --}}
{{-- 
TYPES: Annual, Sick, Casual,Hald day
Set the leaves per/type --}}
{{-- <div class="modal fade" id="add_emp_type_leave_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Add Employee Type leaves</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="single-entity row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="fs-6 fw-bold">
                                    <span class="required">Leave Type</span>
                                </label>
                                <div class="col-sm-9">
                                    {{ aire()->select(LeaveType::all()->pluck('type', 'id')->prepend('Select Leave type',''), 'leave_0')->id('leave_0')->class('form-control form-control-solid selectjs2') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="fs-6 fw-bold">
                                    <span class="required">No Of Leaves</span>
                                </label>
                                <div class="col-sm-9">
                                    {{ aire()->input('nol_0')->placeholder('No Of Leaves')->id('nol_0')->class('form-control form-control-solid')->required() }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 pb-2">
                            <div class="form-group row change">
                                <a onclick="remove_setup_leaves(8,)" class="btn btn-danger remove_leave_field_8">Remove</a>
                            </div>
                        </div>
                    </div>
                <i class="fas fa-plus-circle"></i>
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup" data-dismiss="modal">Cancel</a>
                    <a href="#" onclick="storeEmpTypeLeave()" class="btn btn-rounded btn-success btn-change">Add Leave Type</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="modal" id="add_emp_type_leave_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Manage Employee Type leaves</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="leave-row row">
                    <div class="col-sm-5">
                        {{ aire()->select(LeaveType::all()->pluck('type', 'id')->prepend('Select Leave type',''), 'leave_type[]')->id('leave_type[]')->class('form-control form-control-solid selectjs2 leave-type') }}
                    </div>
                    <div class="col-sm-5">
                        {{ aire()->input('leave_count[]')->placeholder('No Of Leaves')->id('leave_count[]')->class('form-control form-control-solid leave-count')->required() }}
                    </div>
                    <div class="col-md-2 pb-2">
                        <button type="button" class="remove-leave btn btn-rounded btn-danger">Remove</button>
                    </div>
                </div>
                  <button type="button" id="add-leave" class="btn btn-rounded btn-primary">Add</button>
                  {{-- <button type="button" id="save-leave">Save</button> --}}
                  <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup" data-dismiss="modal">Cancel</a>
                    <a href="#" onclick="storeEmpTypeLeave()" class="btn btn-rounded btn-success btn-change">Add Leave Type</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ADD TYPE MODAL --}}
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

    $('#add-leave').click(function() {
        // Clone first row 
        // var newRow = $('.leave-row:first').clone();
        var newRow = `
        <div class="leave-row row">
        <div class="col-sm-5">
            <select class="form-control form-control-solid selectjs2 leave-type text-gray-900" data-aire-component="select" name="leave_type[]" id="leave_type[]" data-aire-for="leave_type">
                <option value="">
                    Select Leave type
                </option>
                <option value="1">
                    Annual
                </option>
                <option value="2">
                    Sick
                </option>
                <option value="3">
                    Casual
                </option>
                <option value="4">
                    Half Day
                </option>
                </select>
        </div>
        <div class="col-sm-5">
            <input type="text" class="form-control form-control-solid leave-count p-2 text-base rounded-sm text-gray-900" data-aire-component="input" name="leave_count[]" placeholder="No Of Leaves" id="leave_count[]" value="" required="" data-aire-for="leave_count">
        </div>
            <div class="col-md-2 pb-2">
                <button type="button" class="remove-leave btn btn-rounded btn-danger">Remove</button>
            </div>
        `;
        // Clear select value
        // newRow.find('.leave-type').val('');
        // newRow.find('.leave-count').val('');
        // // Reset leave count to 1          
        // // newRow.find('.leave-count').val('1');      
        // // Show remove button  
        // newRow.find('.remove-leave').show();       
        // Insert new row before the "Add" button
        $(this).before(newRow);                  
    });

    // Remove leave row
    $('.modal-body').on('click', '.remove-leave', function() {
        // $(this).parent().remove();  // Remove leave row
        $(this).closest(".leave-row").remove();
    });

    // Save leave data
    $('#save-leave').click(function() {
        var leaveData = [];
        $('.leave-row').each(function() {
            var leaveType = $(this).find('.leave-type').val();
            var leaveCount = $(this).find('.leave-count').val();
            if (leaveType && leaveCount) {
                leaveData.push({
                    'type': leaveType,
                    'count': leaveCount
                });
            }
        });

        // Send leave data to server using AJAX
        $.ajax({
            url: 'save_leave_data.php',
            method: 'POST',
            data: {
                leave_data: leaveData
            },
            success: function(response) {
                alert('Leave data saved successfully!');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        // Hide modal
        $('#add_emp_type_leave_modal').hide();
    });


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
        url:"{{url('/emp-type/load-emp-type-table?page=')}}"+page+"&search_item="+search_item,
        success:function(data){
            $('#table').html(data);
        }
    });
}

//Add Additional Employee type leaves    

// //Delete Additional Employee type leaves
// $("#add_emp_type_leave_modal .fa-minus-circle").click(function() {
//     if(counter > 1) {
//         $("#add_emp_type_leave_modal .add-emp-type-leave").last().remove();
//         counter--; // decrement the counter variable
//     }
//     if(counter == 1) {
//         $(this).attr('disabled', true);
//     }
// });

//Delete Additional Employee type leaves



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

});

$(document).ready(function() {
    $('#mng_emp_type_leave').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        mngEmpTypeLeave(id);
    });
});


//Store Emp Type data via ajax
function storeType(){
  // get the form values
    var name = $("#name").val();
    //   make the ajax request
    $.ajax({
        url: '{{ route("emp.type.store") }}',
        type: 'POST',
        data: {
            name: name,
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
                //Show Success message on saving Employee Type and hide form modal
                $('#add_emp_type_modal').hide() 
                $('.show_message').append('Type Added Successfully')
                    $('#success_message').modal('show');
                    setTimeout(function(){
                    window.location.reload();
                    }, 2000);
            }
        }
    });
}

//Update Employee Type data via ajax
function updateType(id){
  // get the form values
    var name = $("#edit_name").val();
//   make the ajax request
    $.ajax({
        url:  "{{url('/emp-type/update')}}/"+id,
        type: 'POST',
        data: {
            name: name,
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
                //Show Success message on saving employee type and hide form modal
                $('#edit_emp_type_modal').hide() 
                $('.show_message').append('Type Updated Successfully')
                $('#success_message').modal('show');
                setTimeout(function(){
                window.location.reload();
                }, 2000);
            }
        }
    });
}

function storeEmpTypeLeave(){
// loop through each pair of employee type and no of leaves
var nolValues = [];
var leaveTypeValues = [];
//Fetch Hidden Emp Type Id
var empTypeId = $('.hidden_emp_type_id').data('id');

$("input[name='leave_count[]']").each(function() {
    var value = $(this).val();
    nolValues.push(value);
});

$("select[name='leave_type[]']").each(function() {
    var value = $(this).val();
    leaveTypeValues.push(value);
});

$.ajax({
        url:  "{{url('/ajax/store-emp-type-leave')}}",
        type: 'POST',
        data: {
            leaveTypeValues: leaveTypeValues,
            nolValues: nolValues,
            empTypeId: empTypeId
        },
        dataType: 'json',
        success: function(response) {
        //Show Success message on saving Employee and hide form modal
        if(response.success){
            $('#add_emp_type_leave_modal').hide() 
            $('.show_message').append('Employee Type Leave Added Successfully')
                $('#success_message').modal('show');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        }
    });
// });
}

// $("#add_emp_type_leave_modal form").submit(function(event) {
//         event.preventDefault();
//         var formData = $(this).serializeArray();
//         var typeAndNolArr = [];
//         for (var i = 0; i < formData.length; i += 2) {
//             var typeAndNol = {};
//             typeAndNol.type = formData[i].value;
//             typeAndNol.nol = formData[i + 1].value;
//             typeAndNolArr.push(typeAndNol);
//         }
//         var typeAndNolJson = JSON.stringify(typeAndNolArr);
//         console.log(typeAndNolJson);
//         // You can now send the typeAndNolJson to the server using AJAX or submit the form normally
//     });

function remove_setup_leaves(emp_id, el) {
    "use strict";
    console.log("removing leaves");
    if (el == undefined)
        var el = window.event.target;
    var ecount = jQuery('#leave_fields_length_' + emp_id).val();
    var d = ecount;
    jQuery(el).parent().parent().parent('.single-entity').remove();
    jQuery('#leave_fields_length_' + emp_id).val(d - 1);

};
//EMPLOYEE LEAVES SETUP

$(".btnClosePopup").click(function () {
    $("#add_emp_type_modal").modal("hide");
    $("#add_emp_type_leave_modal").modal("hide");
    
});
</script>
@endpush
