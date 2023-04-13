<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite([
        'resources/js/app.js',
    ])

    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" type="text/css">
      <!-- Custom CSS -->
      <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    @stack('header-css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0px !important;
        }
        .select2-container .select2-selection--single {
            height: 38px !important;
            padding-left: 6px;
            padding-top: 9px;
        }
    </style>
    @stack('header-css')
    @stack('header-scripts')
</head>
<body id="kt_body">
<!--begin::Main-->
<!--begin::Wrapper-->
<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
    <!--begin::Header-->
    @include('layouts.header')
    <!--end::Header-->
     <!--begin::Aside-->
     @include('layouts.aside')
     <!--end::Aside-->
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div id="kt_content_container" class="container">
            {{-- {{ $slot }} --}}
            {{-- @if(session()->has('message'))
                <x-utility.alert type="{{ session()->get('type', 'primary') }}">
                    {{ session()->get('message', 'Execution complete!') }}
                </x-utility.alert>
            @endif --}}
            @yield('content')
        </div>
        <!--end::Container-->
    </div>
    <!-- Page Content -->
</div>
    @stack('modals')
    <!--end::Content-->
    <!--begin::Footer-->
    @include('layouts.footer')
    <!--end::Footer-->
<!--end::Root-->
<!--end::Main-->
@yield('footer')
@stack('footer-scripts')
<script>
    $(".selectjs2").select2({
        
    });
</script>
</body>
</html>
