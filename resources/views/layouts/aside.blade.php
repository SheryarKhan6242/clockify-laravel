 {{-- <aside class="left-sidebar" data-sidebarbg="skin6">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'selected' : '' }}"> 
                    <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <img src="{{ asset('assets/images/icons/dashboard.svg') }}" class="icon-image">
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="list-divider"></li>
                @foreach (config('aside') as $menu)
                    @if (isset($menu['sub-menu']))
                        <li class="sidebar-item">
                            <a class="sidebar-link sidebar-link-toggle" href="javascript:void(0);" aria-expanded="false">
                                @if(isset($menu['icon-image']))
                                    <img src="{{ asset('assets/images/icons/' . $menu['icon-image'] . '.svg') }}" alt="{{ $menu['label'] }}" class="icon-image">
                                @else
                                    <i data-feather="{{ $menu['icon'] }}" class="feather-icon"></i>
                                @endif
                                <span class="hide-menu">{{ $menu['label'] }}</span>
                                <span class="sidebar-arrow">
                                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="icon-image">
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @foreach ($menu['sub-menu'] as $submenu)
                                    @if (isset($submenu['sub-menu']))
                                        <li class="sidebar-item">
                                            <a class="sidebar-link sidebar-link-toggle" href="javascript:void(0);" aria-expanded="false">
                                                @if(isset($submenu['icon-image']))
                                                    <img src="{{ asset('assets/images/icons/' . $submenu['icon-image'] . '.svg') }}" alt="{{ $submenu['label'] }}" class="icon-image">
                                                @else
                                                    <i class="{{ $submenu['icon'] }}"></i>
                                                @endif
                                                <span class="hide-menu">{{ $submenu['label'] }}</span>
                                                <span class="sidebar-arrow">
                                                    <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="icon-image">
                                                </span>
                                            </a>
                                            <ul aria-expanded="false" class="collapse second-level">
                                                @foreach ($submenu['sub-menu'] as $subsubmenu)
                                                    <li class="sidebar-item">
                                                        <a class="sidebar-link" href="{{ route($subsubmenu['route']) }}">
                                                            @if(isset($subsubmenu['icon-image']))
                                                                <img src="{{ asset('assets/images/icons/' . $subsubmenu['icon-image'] . '.svg') }}" alt="{{ $subsubmenu['label'] }}" class="icon-image">
                                                            @else
                                                                <i class="{{ $subsubmenu['icon'] }}"></i>
                                                            @endif
                                                            <span class="hide-menu">{{ $subsubmenu['label'] }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="{{ route($submenu['route']) }}">
                                                @if(isset($submenu['icon-image']))
                                                    <img src="{{ asset('assets/images/icons/' . $submenu['icon-image'] . '.svg') }}" alt="{{ $submenu['label'] }}" class="icon-image">
                                                @else
                                                    <i class="{{ $submenu['icon'] }}"></i>
                                                @endif
                                                <span class="hide-menu">{{ $submenu['label'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        <li class="list-divider"></li>
                    @else
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ $menu['route'] != '#' ? route($menu['route']) : $menu['route'] }}" aria-expanded="false">
                                @if(isset($menu['icon-image']))
                                    <img src="{{ asset('assets/images/icons/' . $menu['icon-image'] . '.svg') }}" alt="{{ $menu['label'] }}" class="icon-image">
                                @else
                                    <i data-feather="{{ $menu['icon'] }}" class="feather-icon"></i>
                                @endif
                                <span class="hide-menu">{{ $menu['label'] }}</span>
                            </a>
                        </li>
                        <li class="list-divider"></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside> --}}
{{-- 
<aside class="left-sidebar" data-sidebarbg="skin6">
<nav class="sidebar-nav">
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <ul id="sidebarnav" class="sidebar-menu in">
            @foreach (config('aside') as $menu)
                <li class="sidebar-item ">
                    <a href="#" class="sidebar-link">
                        @if(isset($menu['icon-image']))
                            <img src="{{ asset('assets/images/icons/' . $menu['icon-image'] . '.svg') }}" alt="{{ $menu['label'] }}" class="icon-image">
                        @endif
                        {{ $menu['label'] }}
                        @if (isset($menu['sub-menu']))
                            <i class="arrow fas fa-angle-up"></i>
                        @endif
                    </a>
                    @if (isset($menu['sub-menu']))
                        <ul class="submenu">
                            @foreach ($menu['sub-menu'] as $subMenu)
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">
                                        @if(isset($subMenu['icon-image']))
                                            <img src="{{ asset('assets/images/icons/' . $subMenu['icon-image'] . '.svg') }}" alt="{{ $subMenu['label'] }}" class="icon-image">
                                        @endif
                                        {{ $subMenu['label'] }}
                                        @if (isset($subMenu['sub-menu']))
                                            <i class="arrow fas fa-angle-up"></i>
                                        @endif
                                    </a>
                                    @if (isset($subMenu['sub-menu']))
                                        <ul class="sub-submenu">
                                            @foreach ($subMenu['sub-menu'] as $subSubMenu)
                                                <li class="sidebar-item">
                                                    @if(isset($subSubMenu['icon-image']))
                                                        <img src="{{ asset('assets/images/icons/' . $subSubMenu['icon-image'] . '.svg') }}" alt="{{ $subSubMenu['label'] }}" class="icon-image">
                                                    @endif
                                                    <a class="sidebar-link" href="#">{{ $subSubMenu['label'] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</nav>    
</aside> --}}
    
{{-- <aside class="left-sidebar" data-sidebarbg="skin6">
    <nav class="sidebar-nav">
        <div class="scroll-sidebar" data-sidebarbg="skin6">
            <ul id="sidebarnav" class="sidebar-menu in">
                @foreach (config('aside') as $menu)
                    <li class="sidebar-item ">
                        <a href="#" class="sidebar-link">
                            @if(isset($menu['icon-image']))
                                <img src="{{ asset('assets/images/icons/' . $menu['icon-image'] . '.svg') }}" alt="{{ $menu['label'] }}" class="icon-image">
                            @endif
                            {{ $menu['label'] }}
                            @if (isset($menu['sub-menu']))
                                <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="icon-image arrow">
                            @endif
                        </a>
                        @if (isset($menu['sub-menu']))
                            <ul class="submenu">
                                @foreach ($menu['sub-menu'] as $subMenu)
                                    <li class="sidebar-item">
                                        <a href="#" class="sidebar-link">
                                            @if(isset($subMenu['icon-image']))
                                                <img src="{{ asset('assets/images/icons/' . $subMenu['icon-image'] . '.svg') }}" alt="{{ $subMenu['label'] }}" class="icon-image">
                                            @endif
                                            {{ $subMenu['label'] }}
                                            @if (isset($subMenu['sub-menu']))
                                                <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="icon-image arrow">
                                            @endif
                                        </a>
                                        @if (isset($subMenu['sub-menu']))
                                            <ul class="sub-submenu">
                                                @foreach ($subMenu['sub-menu'] as $subSubMenu)
                                                    <li class="sidebar-item">
                                                        @if(isset($subSubMenu['icon-image']))
                                                            <img src="{{ asset('assets/images/icons/' . $subSubMenu['icon-image'] . '.svg') }}" alt="{{ $subSubMenu['label'] }}" class="icon-image">
                                                        @endif
                                                        <a class="sidebar-link" href="#">{{ $subSubMenu['label'] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</aside> --}}
<aside class="left-sidebar" data-sidebarbg="skin6">
    <nav class="sidebar-nav">
        <div class="scroll-sidebar" data-sidebarbg="skin6">
            <ul id="sidebarnav" class="sidebar-menu">
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'selected' : '' }}"> 
                    <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <img src="{{ asset('assets/images/icons/dashboard.svg') }}" class="icon-image">
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                @foreach (config('aside') as $menu)
                    <li class="sidebar-item">
                        <a href="{{ $menu['route'] != '#' ? route($menu['route']) : $menu['route'] }}" class="sidebar-link">
                            @if(isset($menu['icon-image']))
                                <img src="{{ asset('assets/images/icons/' . $menu['icon-image'] . '.svg') }}" alt="{{ $menu['label'] }}" class="icon-image">
                            @endif
                            {{ $menu['label'] }}
                            @if (isset($menu['sub-menu']))
                                <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="icon-image arrow">
                            @endif
                        </a>
                        @if (isset($menu['sub-menu']))
                            <ul class="submenu" style="display: none;">
                                @foreach ($menu['sub-menu'] as $subMenu)
                                    <li class="sidebar-item">
                                        <a href="{{ $subMenu['route'] != '#' ? route($subMenu['route']) : $subMenu['route'] }}" class="sidebar-link">
                                            @if(isset($subMenu['icon-image']))
                                                <img src="{{ asset('assets/images/icons/' . $subMenu['icon-image'] . '.svg') }}" alt="{{ $subMenu['label'] }}" class="icon-image">
                                            @endif
                                            {{ $subMenu['label'] }}
                                            @if (isset($subMenu['sub-menu']))
                                                <img src="{{ asset('assets/images/icons/arrow-down.svg') }}" class="icon-image arrow">
                                            @endif
                                        </a>
                                        @if (isset($subMenu['sub-menu']))
                                            <ul class="sub-submenu" style="display: none;">
                                                @foreach ($subMenu['sub-menu'] as $subSubMenu)
                                                    <li class="sidebar-item">
                                                        @if(isset($subSubMenu['icon-image']))
                                                            <img src="{{ asset('assets/images/icons/' . $subSubMenu['icon-image'] . '.svg') }}" alt="{{ $subSubMenu['label'] }}" class="icon-image">
                                                        @endif
                                                        <a class="sidebar-link" href="{{ $subMenu['route'] != '#' ? route($subMenu['route']) : $subMenu['route'] }}">{{ $subSubMenu['label'] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    <li class="list-divider"></li>
                @endforeach
            </ul>
        </div>
    </nav>
</aside>



@push('header-css')
<style>
    .sidebar-menu {
        list-style-type: none;
        padding: 0;
    }
    
    .submenu {
        display: none;
        list-style-type: none;
        padding: 0;
        margin-left: 10px; /* Indent submenus */
    }
    
    .sub-submenu {
        display: none;
        list-style-type: none;
        padding: 0;
        margin-left: 10px; /* Indent sub-submenus */
    }

    .arrow {
        float: right; /* Float the arrow to the right corner */
        margin-top: 5px; /* Add some margin for positioning */
        margin-left: 15px !important; /* Move the arrow to the far right */
    }

</style>
@endpush

@push('footer-scripts')
<script>
// $(document).ready(function() {
//     // Toggle submenu visibility
//     $('.sidebar-link').click(function(e) {
//         e.preventDefault();
//         $(this).next('.submenu, .sub-submenu').slideToggle();
//         $(this).find('.arrow').toggleClass('fa-angle-up fa-angle-down');
//     });
// });


// $(document).ready(function() {
//     // Toggle submenu visibility
//     $('.sidebar-link').click(function(e) {
//         var submenu = $(this).next('.submenu, .sub-submenu');

//         if (submenu.length > 0) {
//             e.preventDefault();
//             submenu.slideToggle();

//             var arrow = $(this).find('.arrow');
//             arrow.toggleClass('fa-angle-up fa-angle-down');

//             if (arrow.hasClass('fa-angle-up')) {
//                 arrow.attr('src', "{{ asset('assets/images/icons/arrow-up.svg') }}");
//             } else {
//                 arrow.attr('src', "{{ asset('assets/images/icons/arrow-down.svg') }}");
//             }
//         }
//     });
// });

$(document).ready(function() {
    // Toggle submenu visibility
    $('.sidebar-link').click(function(e) {
        var submenu = $(this).next('.submenu, .sub-submenu');

        if (submenu.length > 0) {
            e.preventDefault();

            // Check if the submenu is already visible
            if (submenu.is(':visible')) {
                // Redirect to the submenu link
                var link = $(this).attr('href');
                window.location.href = link;
            } else {
                // Open the submenu
                submenu.slideToggle();

                var arrow = $(this).find('.arrow');
                arrow.toggleClass('fa-angle-up fa-angle-down');

                if (arrow.hasClass('fa-angle-up')) {
                    arrow.attr('src', "{{ asset('assets/images/icons/arrow-up.svg') }}");
                } else {
                    arrow.attr('src', "{{ asset('assets/images/icons/arrow-down.svg') }}");
                }
            }
        }
    });
});



</script>
@endpush

