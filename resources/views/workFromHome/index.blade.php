@extends('layouts.app')
@section('title')
    Work From Home
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
                        <li class="breadcrumb-item"><a href="">Requests</a>
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
{{-- <div class="card"> --}}
    {{-- <div class="card-header border-0 pt-6"> --}}
        <!--begin::Card title-->
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
                <input type="text" name="searchTerm" id="searchTerm" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Requests" autocomplete="off">
            </div>
            <!--end::Search-->
        </div>
            {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <!--begin::Add user-->
                <a href="#add_wfh_modal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_wfh_modal">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"></rect>
                        <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1"></rect>
                    </svg>
                </span>
                <!--end::Svg Icon-->Add Leaves</a>
            </div> --}}
    {{-- <div class="card-body pt-0"> --}}
        @include('workFromHome.include.tabledata')              
<!--end::Content-->
@endsection

@section('footer')

@endsection

@push('header-css')

@endpush

@push('modals')
{{-- View WFH Modal --}}
<div class="modal fade" id="view_wfh_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">WFH Request</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="row">
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Employee Name</span>
                        </label>
                        {{ aire()->input('name')->id('name')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Start Date</span>
                        </label>
                        {{ aire()->date('start_date')->id('start_date')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">End Date</span>
                        </label>
                        {{ aire()->date('end_date')->id('end_date')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Reason</span>
                        </label>
                        {{ aire()->input('reason')->id('reason')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Status</span>
                        </label>
                        {{ aire()->input('status')->id('status')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- View WFH Modal --}}

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
        url:"{{url('/work-from-home/load-table?page=')}}"+page+"&search_item="+search_item,
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
//Store Leave Type data via ajax
function storeLeaveType(){
  // get the form values
    var type = $("#type").val();
//   make the ajax request
    $.ajax({
        url: '{{ route("leaveType.store") }}',
        type: 'POST',
        data: {
            type: type
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
                //Show Success message on saving leave type and hide form modal
                $('#add_wfh_modal').hide() 
                $('.show_message').append('Leave Type Added Successfully')
                    $('#success_message').modal('show');
                    setTimeout(function(){
                    window.location.reload();
                    }, 2000);
                // jQuery('.alert-danger').hide();
                // $('#open').hide();
                // $('#add_guest').modal('hide');
                // //User Already Reigstered
                // if (result.type == 'danger') {
                //     $('#alert-div').find('h4').text('User Already Registered');
                //     $('#alert-div').find('span').text(result.message);
                //     $('#alert-div').show();
                    
                // } else {
                //     //Success bookinng
                // }                
            }
        }
    });
}

//UPDATE LEAVE Leave VIA AJAX
function updateLeave(id){
  // get the form values
    var type = $("#edit_type").val();
//   make the ajax request
    $.ajax({
        url:  "{{url('/leave-type/update')}}/"+id,
        type: 'POST',
        data: {
            type: type
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
                //Show Success message on saving leave type and hide form modal
                $('#edit_leave_type_modal').hide() 
                $('.show_message').append('leave Type Updated Successfully')
                    $('#success_message').modal('show');
                    setTimeout(function(){
                    window.location.reload();
                    }, 2000);             
            }
        }
    });
}

    $(".btnClosePopup").click(function () {
        $("#add_wfh_modal").modal("hide");
    });
</script>
@endpush
