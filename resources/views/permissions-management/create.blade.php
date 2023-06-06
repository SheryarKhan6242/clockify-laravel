@extends('layouts.app')
@section('content')
<div class="card">
    <div class="ui-block-title">
        <h5 class="title font-weight-bold pt-3 ps-4">Add New Permission</h5>
    </div>
    <div class="card-body p-12">
        {{ aire()->open(route('permissions-management.store'))->rules([
                'name' => 'required',
            ])->id('permission-form') }}
        <div class="separator separator-dashed my-10"></div>
        @include('permissions-management.form')
        <div class="row gx-10 mb-5">
            <div class="col-lg-12">
                <div class="mb-0 float-end">
                    {{ aire()->submit('Add')->class('btn btn-success') }}
                </div>
            </div>
        </div>
        {{ aire()->close() }}
    </div>
</div>
@endsection

@section('footer')
@endsection

@push('header-css')
@endpush

@push('header-scripts')
@endpush

@push('footer-scripts')
@endpush
<style>
    .alert-danger {
        font-family: 'Teko';
        font-size: 20px;
    }
</style>
