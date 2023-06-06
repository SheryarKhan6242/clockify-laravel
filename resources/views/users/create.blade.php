@extends('layouts.app')
@section('content')
@if (session()->has('type'))
    <div class="alert alert-{{ session('type') }}">
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-dark">{{ session('message', 'Execution complete!') }}</h4>
        </div>
    </div>
    @endif
<div class="card">
    <div class="ui-block-title">
        <h5 class="title font-weight-bold pt-3 ps-4">Create User</h5>
    </div>
    <div class="card-body">      
        <div class="row">
            {{ aire()->open(route('storeUser'))
            ->rules([
                    'name' => 'required',
                    'username' => 'required',
                    'email' => 'required',
                    'roles' => 'required',
                    'user_pass' => 'min:8',
                    'confirm_password' => 'same:user_pass|min:8',
                ]
                )->class('kt_invoice_form')
                // ->bind($topicPost)
                ->encType('multipart/form-data')
                }}
            @include('users.form')
            {{ aire()->submit('Create User')->class('float-end btn btn-md btn-success btn-change') }}
            <a href="{{url()->previous()}}" id="btnClosePopup" class="float-end btn btn-md btn-danger btn-change inline-block text-base rounded p-2 px-4 text-white bg-blue-600 border-blue-700 hover:bg-blue-700 hover:border-blue-900 ms-2">Cancel</a>                            
            {{ aire()->close() }}
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection

@push('header-css')
<style>
    .ck.ck-editor__main > .ck-editor__editable{
        height: 140px;
    }
</style>
@endpush

@push('header-scripts')

@endpush

@push('modals')

@endpush

@push('footer-scripts')
<script>

</script>
@endpush