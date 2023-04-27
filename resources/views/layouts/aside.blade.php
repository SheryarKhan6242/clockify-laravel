<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'selected':'' }}"> 
                    <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="list-divider"></li>
                @foreach ( config('aside') as $menu )
                @if (isset($menu['sub-menu']))
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="javascript:void(0);" aria-expanded="false">
                            <i data-feather="message-square" class="{{ $menu['icon'] }}"></i>
                            <span class="hide-menu">{{ $menu['label'] }}</span>
                        </a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            @foreach ($menu['sub-menu'] as $submenu)
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route($submenu['route']) }}">
                                        <i class="{{ $submenu['icon'] }}"></i>
                                        <span class="hide-menu">{{ $submenu['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="list-divider"></li>
                @else
                    <li class="sidebar-item">
                        <a class="sidebar-link sidebar-link" href="{{ $menu['route'] != '#' ? route($menu['route']) : $menu['route'] }}"
                            aria-expanded="false">
                            <i data-feather="message-square" class="{{ $menu['icon'] }}"></i>
                            <span class="hide-menu">{{ $menu['label'] }}</span>
                        </a>
                    </li>
                    <li class="list-divider"></li>
                @endif
            @endforeach
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
