<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg">
        <div class="navbar-header" data-logobg="skin6">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand d-flex justify-content-center align-items-center">
                <!-- Logo icon -->
                <a href="index.html">
                    <img src="http://localhost/clockify-laravel/public/assets/images/inaq-logo.png" alt="" class="img-fluid">
                </a>
            </div>            
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
            </ul>
            <ul class="navbar-nav float-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}" style="width: 100%;">
                    </a>                     
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ auth()->user()->getAvatarAttribute(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->profile_photo_path }}" class="rounded-circle"
                            width="40">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="user"
                                class="svg-icon me-2 ms-1"></i>
                            My Profile</a>
                        {{-- <a class="dropdown-item" href="javascript:void(0)"><i data-feather="credit-card"
                                class="svg-icon me-2 ms-1"></i>
                            My Balance</a>
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="mail"
                                class="svg-icon me-2 ms-1"></i>
                            Inbox</a> --}}
                        {{-- <div class="dropdown-divider"></div> --}}
                            {{-- <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"
                                class="svg-icon me-2 ms-1"></i>
                            Account Setting</a> --}}
                        <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"  class="dropdown-item"><i data-feather="power"
                                    class="svg-icon me-2 ms-1"></i>
                                Logout</button>
                            </form>
                        {{-- <div class="dropdown-divider"></div> --}}
                        {{-- <div class="pl-4 p-3"><a href="javascript:void(0)" class="btn btn-sm btn-info">View
                                Profile</a></div> --}}
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>