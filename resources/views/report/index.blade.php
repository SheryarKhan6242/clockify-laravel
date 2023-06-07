@extends('layouts.app')
@section('title')
    Reports
@endsection
@php
    use App\Models\CheckinType;
    use App\Models\Employee;
    use App\Models\Shift;
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control form-control-solid selectjs2 text-gray-900 select2js" name="month"
                                id="month">
                                <option value="" selected="">Select Month</option>
                                @foreach ($months as $value => $name)
                                    <option value="{{ $value }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span id="monthError" class="invalid-feedback">Please select a month.</span>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-solid selectjs2 text-gray-900 select2js"
                                data-aire-component="select" name="filter_attendance" id="filter_attendance"
                                data-aire-for="filter_attendance">
                                <option value="3" selected="">All</option>
                                <option value="1">Present</option>
                                <option value="0">Absent</option>
                            </select>
                            <span id="attendanceError" class="invalid-feedback">Please select an attendance status.</span>
                        </div>
                        <div class="col-md-3">
                            {{-- {{ aire()->select(Employee::all()->pluck('first_name', 'id')->prepend('Select Employee',''), 'first_name')->id('first_name')->class('form-control form-control-solid selectjs2') }} --}}
                            {{ aire()->select(
                                    Employee::whereHas('user', function ($query) {
                                        $query->where('status', true)->orderBy('username');
                                    })->get()->pluck('full_name', 'id')->prepend('Select Employee', ''),
                                    'emp_name',
                                )->id('emp_name')->class('form-control select2js') }}
                            <span id="userError" class="invalid-feedback">Please select an employee.</span>
                        </div>
                        <div class="col-md-2">
                            <a type="button" id="GenerateReportsBtn" onclick="generateReport(this)"
                                class="btn btn-primary mr-2">Generate Report</a>
                               
                        </div>
                        <div class="col-md-1">
                            <div class="spinner-grow d-none" id="loader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="reports-data"></div>
                    <!--end::Search-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection

@push('header-css')

@endpush

@push('modals')

    {{-- Add Report Modal --}}
    <div class="modal fade" id="add_report_modal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fw-bolder">Add Report</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="row">
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Employee Name</span>
                            </label>
                            {{ aire()->input('name')->id('add_name')->class('form-control form-control-solid') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Login Date</span>
                            </label>
                            {{ aire()->date('login_date')->id('add_login_date')->class('form-control form-control-solid') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Clock In</span>
                            </label>
                            {{ aire()->time('office_in')->id('add_office_in')->class('form-control form-control-solid') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Clock Out</span>
                            </label>
                            {{ aire()->time('office_out')->id('add_office_out')->class('form-control form-control-solid') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Checkin Type</span>
                            </label>
                            {{ aire()->select(CheckinType::all()->pluck('type', 'id'), 'checkin_type')->id('add_checkin_type')->class('form-control form-control-solid selectjs2') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Shift</span>
                            </label>
                            {{ aire()->select(Shift::all()->pluck('name', 'id')->prepend('Select Employee shift', ''),'add_shift_id')->id('add_shift_id')->class('form-control form-control-solid selectjs2') }}
                        </div>
                        <div class="text-center pt-15 show_update">
                            <a href="#" id="btnClosePopup" class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                            <a href="#" id="add_report" onclick="addReport()"
                                class="btn btn-rounded btn-success btn-change">Add Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Add Report Modal --}}

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
                                <span class="required">Shift</span>
                            </label>
                            {{ aire()->select(Shift::all()->pluck('name', 'id'), 'shift_id')->id('shift_id')->class('form-control form-control-solid selectjs2') }}
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

    {{-- Edit Report Modal --}}
    <div class="modal fade" id="edit_report_modal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="fw-bolder">Edit Report</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="row">
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Employee Name</span>
                            </label>
                            {{ aire()->input('edit_name')->id('edit_name')->class('form-control form-control-solid')->readOnly() }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Login Date</span>
                            </label>
                            {{ aire()->date('edit_login_date')->id('edit_login_date')->class('form-control form-control-solid')->readOnly() }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Clock In</span>
                            </label>
                            {{ aire()->time('edit_office_in')->id('edit_office_in')->class('form-control form-control-solid') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Clock Out</span>
                            </label>
                            {{ aire()->time('edit_office_out')->id('edit_office_out')->class('form-control form-control-solid') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Checkin Type</span>
                            </label>
                            {{ aire()->select(CheckinType::all()->pluck('type', 'id'), 'edit_checkin_type')->id('edit_checkin_type')->class('form-control form-control-solid selectjs2') }}
                        </div>
                        <div class="col-md-12 fv-row">
                            <label class="fs-6 fw-bold">
                                <span class="required">Shift</span>
                            </label>
                            {{ aire()->select(Shift::all()->pluck('name', 'id'), 'edit_shift_id')->id('edit_shift_id')->class('form-control form-control-solid selectjs2') }}
                        </div>
                        <div class="text-center pt-15 show_update">
                            <a href="#" id="btnClosePopup"
                                class="btn btn-rounded btn-danger btnClosePopup">Cancel</a>
                            <a href="#" id="update_report" onclick="updateReport()"
                                class="btn btn-rounded btn-success btn-change">Update Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Report Modal --}}

    <div class="modal fade" id="success_message" tabindex="-1" aria-hidden="true">
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

            $(document).ready(function() {

                $('#searchTerm').on('keyup', function() {
                    search_item = $(this).val();
                    var page = $('#hidden_page').val();
                    fetch_data(page, search_item);
                })

                $(document).on('click', '.pagination a', function(event) {
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    var search_item = $('#searchTerm').val();
                    fetch_data(page, search_item);
                });

                function fetch_data(page, search_item) {
                    if (search_item === undefined) {
                        search_item = "";
                    }

                    $.ajax({
                        url: "{{ url('/report/load-table?page=') }}" + page + "&search_item=" + search_item,
                        success: function(data) {
                            $('#table').html(data);
                        }
                    });
                }
            });

            function addReport() {
                // alert("Ok")
                // Get the Report values
                var user_id = $('#emp_name').val();
                var login_date = $('#add_login_date').val();
                var office_in = $('#add_office_in').val();
                var office_out = $('#add_office_out').val();
                var checkin_id = $('#add_checkin_type').val();
                var shift_id = $('#add_shift_id').val();

                // Create the data object to be sent in the AJAX request
                var data = {
                    user_id: user_id,
                    login_date: login_date,
                    office_in: office_in,
                    office_out: office_out,
                    checkin_id: checkin_id,
                    shift_id: shift_id
                };

                $.ajax({
                    url: '{{ route('report.store') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        // success handling
                        if (response.errors) {
                            jQuery.each(response.errors, function(fieldName, errorMsg) {
                                var field = $('[name="' + fieldName + '"]');
                                field.addClass('is-invalid');
                                field.after('<div class="invalid-feedback">' + errorMsg + '</div>');
                            });
                            // Remove the error message and is-invalid class when the user corrects the input
                            $('input, select').on('input', function() {
                                var field = $(this);
                                field.removeClass('is-invalid');
                                field.next('.invalid-feedback').remove();
                            });
                        } else {
                            //Show Success message on saving Report and hide form modal
                            $('#add_report_modal').hide()
                            $('.show_message').append('Report Updated Successfully')
                            $('#success_message').modal('show');
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
            }

            function updateReport(id) {
                // Get the updated values from the edit modal inputs
                var updatedLoginDate = $('#edit_login_date').val();
                var updatedOfficeIn = $('#edit_office_in').val();
                var updatedOfficeOut = $('#edit_office_out').val();
                var updatedCheckinType = $('#edit_checkin_type').val();
                var updatedShiftId = $('#edit_shift_id').val();

                // Create the data object to be sent in the AJAX request
                var data = {
                    login_date: updatedLoginDate,
                    office_in: updatedOfficeIn,
                    office_out: updatedOfficeOut,
                    checkin_id: updatedCheckinType,
                    shift_id: updatedShiftId
                };

                $.ajax({
                    url: "{{ url('/report/update') }}/" + id,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        // success handling
                        if (response.errors) {
                            jQuery.each(response.errors, function(fieldName, errorMsg) {
                                var field = $('[name="' + fieldName + '"]');
                                field.addClass('is-invalid');
                                field.after('<div class="invalid-feedback">' + errorMsg + '</div>');
                            });
                            // Remove the error message and is-invalid class when the user corrects the input
                            $('input, select').on('input', function() {
                                var field = $(this);
                                field.removeClass('is-invalid');
                                field.next('.invalid-feedback').remove();
                            });
                        } else {
                            //Show Success message on saving Report and hide form modal
                            $('#edit_report_modal').hide()
                            $('.show_message').append('Report Updated Successfully')
                            $('#success_message').modal('show');
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
            }

            function generateReport(event) {

                var month = $('#month').val();
                var attendance_status = $('#filter_attendance').val();
                var user_id = $('#emp_name').val();
                var isValid = true;

                // Perform validation
                if (!month) {
                    $('#month').addClass('is-invalid');
                    $('#monthError').show();
                    isValid = false;
                } else {
                    $('#month').removeClass('is-invalid');
                    $('#monthError').hide();
                }

                if (!attendance_status) {
                    $('#filter_attendance').addClass('is-invalid');
                    $('#attendanceError').show();
                    isValid = false;
                } else {
                    $('#filter_attendance').removeClass('is-invalid');
                    $('#attendanceError').hide();
                }

                if (!user_id) {
                    $('#emp_name').addClass('is-invalid');
                    $('#userError').show();
                    isValid = false;
                } else {
                    $('#emp_name').removeClass('is-invalid');
                    $('#userError').hide();
                }

                if (!isValid)
                {
                    return;
                }
                
                $('#loader').removeClass('d-none');
                $.ajax({
                    url: "{{ url('/report/generate') }}/" + user_id,
                    method: 'POST',
                    data: {
                        user_id: user_id,
                        month: month,
                        attendance_status: attendance_status
                    },
                    success: function(response) {
                        $('.reports-data').html('');
                        $('#loader').addClass('d-none');
                        $('.reports-data').append(response.html);
                        // console.log(response.html)

                    }
                });

            }
            // Remove validation error styles when the inputs are focused
            $('#month, #filter_attendance, #emp_name').focus(function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').hide();
            });

            $(".btnClosePopup").click(function() {
                $("#add_wfh_modal").modal("hide");
            });
        </script>
    @endpush
