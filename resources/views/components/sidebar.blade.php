<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{'/img/logo.png'}}" alt="HududGaz" class="w-100">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.users')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Foydalanuvchilar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.equipments')}}" class="nav-link">
                        <i class="nav-icon fas fa-drafting-compass"></i>
                        <p>Jihozlar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.designers')}}" class="nav-link">
                        <i class="nav-icon fas fa-pencil-ruler"></i>
                        <p>Loyihachilar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.mounters')}}" class="nav-link">
                        <i class="nav-icon fas fa-network-wired"></i>
                        <p>Montajchilar</p>
                    </a>
                </li>
                <!-- Dropdown menu -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Sozlamalar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a target="_self" href="{{route('admin.settings')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tashkilot</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/admin/regions" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Idoralar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/admin/statuses" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Holatlar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/admin/activity-type" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Faoliyat turlari</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.timetable')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ish jadvali</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
