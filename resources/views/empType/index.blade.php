@extends('layouts.app')
@section('title')
    Locations
@endsection
@php
    use App\Models\LeaveType;
    use App\Models\EmployeeType;
@endphp


@section('bread_crumb')
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h2 class="page-title text-truncate text-light font-weight-medium mb-1">Employee Type</h2>
        </div>
        <div class="col-5 text-end">
            <a class="btn pt-3" href="#add-emp-type" data-bs-toggle="modal" data-bs-target="#add-emp-type" style="width: 186px; height: 60px; margin-right: 160px; border: 1px solid #27B9C2; border-radius: 12px; color: #ffffff;">Add Employee Type +</a>
        </div>        
    </div>
    {{-- <div class="toast-success">
        <img src="{{ asset('assets/images/icons/toast-success }}.svg') }}" style="width: 24px; height: 24px; background: #232B2E; border-radius: 6px;" alt="toast-success">
        <span class="toast-message"></span>
    </div> --}}
    <div class="toast-bar mt-3 pt-2" style="display: none;">
        <span class="toast-icon"></span>
        <span class="toast-message" style="vertical-align: top;"></span>
    </div>
    
</div>


@endsection

@section('content')
<div class="row">
    @foreach ($empTypes as $type)
    <div class="col-md-4 mb-4">
        <div class="display-card w-100">
            <div class="card-body d-flex align-items-center justify-content-between">
                <h5 class="card-title" style="color: #fff">{{ $type->name }}</h5>
                <a href="#" class="text-decoration-none" style="color: #fff"><i class="fas fa-ellipsis-v"></i></a>
            </div>
        </div>
    </div>
    
    @endforeach
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
    
</style>

@endpush

@push('modals')
<div class="modal fade" id="add-emp-type" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-heading">Employee Type</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="row pt-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="emp-type">Employee Type</label>
                        {{ aire()->input('type')->placeholder('Enter Employee Type')->id('type')->class('form-control pt-1') }}
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="leave-type">Assign To</label>
                        {{ aire()->select(LeaveType::all()->pluck('type', 'id')->prepend('Select Leave Type', ''),'leave_type')->id('emp_type')->class('form-control pt-1') }}
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="form-group mb-3">
                        <label class="form-label" for="nol">No Of Leaves</label>
                        {{ aire()->input('nol')->placeholder('Enter No Of Leaves')->id('nol')->class('form-control pt-1') }}
                    </div>
                </div>
                <div class="text-end pt-3">
                    <a href="#" onclick="add_emp_type()" id="add_emp_type" class="btn btn-primary pt-3">Add</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush


@push('header-scripts')

@endpush


@push('header-scripts')

@endpush

@push('footer-scripts')
<script>
    //Token for Post requests(Added once)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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
    }

    function add_emp_type(){
        var type = $("#type").val();
        $.ajax({
            url: '{{ route("emp.type.store") }}',
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
                }
                else
                {
                    //Show Success message on saving employee type and hide form modal
                    $('#add-emp-type').modal('hide') 
                    $('.toast-bar').removeClass('toast-danger').addClass('toast-success');
                    $('.toast-icon').removeClass().addClass('toast-icon-success');
                    $('.toast-message').text(result.message);
                    $('.toast-bar').show();        
                    $('.toast-bar').fadeIn().delay(2000).fadeOut();
   
                }
            },
            error: function(xhr, status, error) {
                $('#add-emp-type').modal('hide') 
                $('.toast-bar').removeClass('toast-success').addClass('toast-danger');
                $('.toast-icon').removeClass().addClass('toast-icon-danger');
                $('.toast-message').text('Error occurred during the request.');
                $('.toast-bar').show();
                $('.toast-bar').fadeIn().delay(2000).fadeOut();

            }
        });
    }
    </script>
@endpush
