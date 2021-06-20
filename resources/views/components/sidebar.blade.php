<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{'/img/logo.png'}}" alt="HududGaz" class="w-100">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php($items = MenuItems())
                @foreach($items as $menu)
                    @if ($menu->href == '#')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="{{$menu->icon}}"></i>
                            <p>
                                <span>@lang($menu->title)</span>
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <!-- Dropdown menu -->
                        <ul class="nav nav-treeview" style="display: none;">
                            @for($i = $loop->index + 1; $i < $loop->count; $i ++)
                                <li class="nav-item">
                                    <a href="{{route($items[$i]->href)}}" class="nav-link">
                                        <i class="{{$items[$i]->icon}}"></i>
                                        <span>@lang($items[$i]->title)</span>
                                    </a>
                                </li>
                            @endfor
                        </ul>
                        @break
                    </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{route($menu->href)}}" class="nav-link">
                            <i class="{{$menu->icon}}"></i>
                            <span>@lang($menu->title)</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
