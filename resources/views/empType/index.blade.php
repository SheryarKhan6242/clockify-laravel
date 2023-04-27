@extends('layouts.app')
@section('title')
    Locations
@endsection
@section('bread_crumb')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
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

@endpush

@push('modals')
{{-- ADD TYPE MODAL --}}
<div class="modal fade" id="add_emp_type_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Add New Type</h2>
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
                        <span class="required">Type</span>
                        {{-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="It is recommended a unique name is used!" aria-label="It is recommended a unique name is used!"></i> --}}
                    </label>
                    {{ aire()->input('name')->placeholder('Employee Type')->id('name')->class('form-control form-control-solid')->required() }}
                    {{-- <div class = "alert-text" id = "dep_name_error" style="display:none">Location Name is Required!</div> --}}
                </div>
                {{-- <div class="text-gray-600">Once a grade is added, it can't be deleted, only deactivated.</div> --}}
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                    <a href="#" onclick="storeType()" class="btn btn-rounded btn-success btn-change">Add Type</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ADD TYPE MODAL --}}

{{-- EDIT TYPE MODAL --}}
<div class="modal fade" id="edit_emp_type_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Edit Type</h2>
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
                        <span class="required">Type</span>
                        {{-- <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="It is recommended a unique name is used!" aria-label="It is recommended a unique name is used!"></i> --}}
                    </label>
                    {{ aire()->input('name')->placeholder('Employee Type')->id('edit_name')->class('form-control form-control-solid')->required() }}
                    {{-- <div class = "alert-text" id = "dep_name_error" style="display:none">Location Name is Required!</div> --}}
                </div>
                {{-- <div class="text-gray-600">Once a grade is added, it can't be deleted, only deactivated.</div> --}}
                <div class="text-center pt-15 show_update">
                    <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                    <a href="#" id="update_emp_type" onclick="updateType()" class="btn btn-rounded btn-success btn-change">Update Type</a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- EDIT TYPE MODAL --}}
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
        url:"{{url('/emp-type/load-emp-type-table?page=')}}"+page+"&search_item="+search_item,
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


//AJAX TO GET EMPLOYEE TYPE DATA BY ID
function getTypeById(id){
    $.ajax({
        url:  "{{url('/emp-type/edit')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
        // success handling
        console.log(response.empTypes)
        if(response.success == true && response.empType != undefined){
                //Fill Up edit modal values
                $('#edit_name').val(response.empType.name);
                //Add Update empType onclick event and append ID 
                $('#update_emp_type').attr('onclick', $('#update_emp_type').attr('onclick').replace('()', '(' + response.empType.id + ')'));
                $('#edit_emp_type_modal').modal("show");
            }
        }
    });
}
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

//Delete Employee Type data via ajax
function deleteEmpType(id){
//   make the ajax request
    $.ajax({
        url:  "{{url('/emp-type/delete')}}/"+id,
        type: 'GET',
        dataType: 'json',
        success: function(result) {
        //Show Success message on employee type and hide form modal 
        $('.show_message').append('Type Deleted Successfully')
            $('#success_message').modal('show');
            setTimeout(function(){
            window.location.reload();
            }, 2000);                
        }
    });
}

$(".btnClosePopup").click(function () {
    $("#add_emp_type_modal").modal("hide");
});
</script>
@endpush
