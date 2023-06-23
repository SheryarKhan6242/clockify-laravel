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
                        @if (isset($menu['route']) && $menu['route'] !== '#')
                            <a href="{{ route($menu['route']) }}" class="sidebar-link">
                        @else
                            <a href="#" class="sidebar-link">
                        @endif
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
                                        @if (isset($subMenu['route']) && $subMenu['route'] !== '#')
                                            <a href="{{ route($subMenu['route']) }}" class="sidebar-link">
                                        @else
                                            <a href="#" class="sidebar-link">
                                        @endif
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
                                                        @if (isset($subSubMenu['route']) && $subSubMenu['route'] !== '#')
                                                            <a href="{{ route($subSubMenu['route']) }}" class="sidebar-link">
                                                        @else
                                                            <a href="#" class="sidebar-link">
                                                        @endif
                                                            @if(isset($subSubMenu['icon-image']))
                                                                <img src="{{ asset('assets/images/icons/' . $subSubMenu['icon-image'] . '.svg') }}" alt="{{ $subSubMenu['label'] }}" class="icon-image">
                                                            @endif
                                                            {{ $subSubMenu['label'] }}
                                                        </a>
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
$(document).ready(function() {
    $('.sidebar-link').click(function(e) {
    var submenu = $(this).next('.submenu, .sub-submenu');
    if (submenu.length > 0) {
        e.preventDefault();
        submenu.slideToggle();
        
        var arrow = $(this).find('.arrow');
        arrow.toggleClass('fa-angle-up fa-angle-down');

        if (arrow.hasClass('fa-angle-up')) {
            arrow.attr('src', '{{ asset('assets/images/icons/arrow-up.svg') }}');
        } else {
            arrow.attr('src', '{{ asset('assets/images/icons/arrow-down.svg') }}');
        }
    }
});


});



</script>
@endpush

