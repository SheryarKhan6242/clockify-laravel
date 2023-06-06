@extends('layouts.app')
@section('heading')
    Permissions Management
@endsection
@section('sub-heading')
    View Permissions
@endsection
@section('content')
    @if (session()->has('type'))
    <div class="alert alert-{{ session('type') }}">
        <div class="d-flex flex-column">
            <h4 class="mb-1 text-dark">{{ session('message', 'Execution complete!') }}</h4>
        </div>
    </div>
    @endif
    <!--begin::Content-->
    <div class="card">
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                            height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <path
                                    d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                    fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                <path
                                    d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                    fill="#000000" fill-rule="nonzero"></path>
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" name="searchTerm" id="searchTerm" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search Permissions"
                        autocomplete="off">
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Add user-->
                    <a href="{{ route('permissions-management.create') }}" class="btn btn-secondary fw-bolder fs-8 fs-lg-base ms-5">
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <rect fill="#000000" x="4" y="11" width="16" height="2"
                                    rx="1"></rect>
                                <rect fill="#000000" opacity="0.5"
                                    transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)"
                                    x="4" y="11" width="16" height="2" rx="1"></rect>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->Add Premission
                    </a>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <div class="card-body pt-0">
            @include('permissions-management.include.tableData')
        </div>
    </div>
    <!--end::Content-->
@endsection

@section('footer')
@endsection

@push('header-css')
@endpush

@push('header-scripts')
@endpush
@push('footer-scripts')
    <script>
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
                    url: "{{ url('/dashboard/permissions-management/load-permissions-table?page=') }}" + page +
                        "&search_item=" + search_item,
                    success: function(data) {
                        $('#table').html(data);
                    }
                });
            }

        });
    </script>
@endpush
