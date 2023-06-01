@extends('layouts.app')
@section('title')
    Reports
@endsection
@php
    use App\Models\CheckinType;
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
                        <li class="breadcrumb-item"><a href="">Reports</a>
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
                <input type="text" name="searchTerm" id="searchTerm" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Reports" autocomplete="off">
            </div>
            <!--end::Search-->
        </div>
        @include('report.include.tabledata')              
<!--end::Content-->
@endsection

@section('footer')

@endsection

@push('header-css')

@endpush

@push('modals')
{{-- View Report Modal --}}
<div class="modal fade" id="view_report_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="fw-bolder">Report</h2>
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
                            <span class="required">Login Date</span>
                        </label>
                        {{ aire()->date('login_date')->id('login_date')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Clock In</span>
                        </label>
                        {{ aire()->time('office_in')->id('office_in')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Clock Out</span>
                        </label>
                        {{ aire()->time('office_out')->id('office_out')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Checkin Type</span>
                        </label>
                        {{ aire()->select(CheckinType::all()->pluck('type', 'id'), 'checkin_type')->id('checkin_type')->class('form-control form-control-solid selectjs2') }}
                    </div>
                    <div class="col-md-12 fv-row">
                        <label class="fs-6 fw-bold">
                            <span class="required">Working Hours</span>
                        </label>
                        {{ aire()->time('total_work_hours')->id('total_work_hours')->class('form-control form-control-solid')->readOnly() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- View Report Modal --}}

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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
            url:"{{url('/report/load-table?page=')}}"+page+"&search_item="+search_item,
            success:function(data){
                $('#table').html(data);
            }
        });
    }
});


    $(".btnClosePopup").click(function () {
        $("#add_wfh_modal").modal("hide");
    });
</script>
@endpush
