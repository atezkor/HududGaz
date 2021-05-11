<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{'/img/logo.png'}}" alt="HududGaz" class="w-100">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach(MenuItems() as $menu)
                    <li class="nav-item">
                        <a href="{{route($menu['href'])}}" class="nav-link">
                            <i class="{{$menu['icons']}}"></i>
                            <p>{{$menu['title']}}</p>
                        </a>
                    </li>
                @endforeach

                <li class="nav-item">
                    <!-- Dropdown menu -->
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Sozlamalar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        @foreach(MenuItemChildrens() as $menu)
                            <li class="nav-item">
                                <a href="{{route($menu['href'])}}" class="nav-link">
                                    <i class="{{$menu['icons']}}"></i>
                                    <p>{{$menu['title']}}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
