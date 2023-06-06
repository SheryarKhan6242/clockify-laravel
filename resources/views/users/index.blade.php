@extends('layouts.app')
@section('heading')
    Users
@endsection
@section('sub-heading')
    View Users
@endsection
@section('content')
    <!--begin::Content-->
    <div class="card">
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center justify-content-between position-relative my-1">
                    <div class="d-flex align-items-center position-relative">
                    </div>
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <a href="{{ route('createUser') }}" class="btn btn-secondary fw-bolder fs-8 fs-lg-base ms-5">Add User</a>
                </div>
            </div>
        </div>
        {{-- <div class="card-body pt-0"> --}}
            <div class="table-responsive"></div>
            <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
                <thead>
                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">USER NAME</th>
                        <th class="min-w-125px">EMAIL</th>
                        <th class="min-w-125px">ROLE</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-bold" id="tbody_render">
                    @foreach ($users as $user)
                        @if (!$user->hasRole('super-admin'))
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->first()->name ?? '' }}</td>
                                <td class="text-end">@include('users.actions', ['user' => $user])</td>
                            </tr>
                        @endif
                </tbody>
                @endforeach
            </table>
        {{-- </div> --}}
    </div>
    <!--end::Content-->
@endsection

@section('footer')
@endsection

@push('header-css')
@endpush

@push('header-scripts')
@endpush
