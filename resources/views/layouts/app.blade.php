<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    {{-- @vite([
        'resources/js/app.js',
    ]) --}}

    <!-- Custom CSS -->
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
    <style>
        .sidebar-nav #sidebarnav .sidebar-item.selected>.sidebar-link
        {
            background: linear-gradient(to right,#27E1EC,#2BCED8,#2AC0C9,#27B9C2,#27B9C2);
        }
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
    @stack('header-css')
    @stack('header-scripts')
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('layouts.aside')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            @yield('bread_crumb')
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- *************************************************************** -->
                <!-- Start First Cards -->
                <!-- *************************************************************** -->
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
        <script>
            setInterval(() => $("#dateTime").text(new Date().toLocaleString('en-US',{month: 'long', day: '2-digit', year: 'numeric',hour: '2-digit',minute: '2-digit',second: '2-digit',timeZone: 'Asia/Karachi'})), 1000);
        </script>
    <!--end::Root-->
    <!--end::Main-->
@yield('footer')
@stack('footer-scripts')
</body>
</html>
