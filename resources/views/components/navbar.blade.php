<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <style>
        .nav-link.logout {
            display: flex;
            align-items: center;
        }

        .nav-link.logout i {
            margin-right: 2px;
        }
    </style>

    <!-- navbar left -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item pt-2 ml-5">
            <div>
                <h3 class="card-title">Bugungi: 1</h3>
            </div>
        </li>
        <li class="nav-item pt-2 ml-5">
            <div>
                <h3 class="card-title">Soatlik: 1</h3>
            </div>
        </li>
        <li class="nav-item pt-2 ml-5">
            <div>
                <h3 class="card-title">Haftada: 1</h3>
            </div>
        </li>
        <li class="nav-item pt-2 ml-5">
            <div>
                <h3 class="card-title">Yilda: 1</h3>
            </div>
        </li>
    </ul>

    <!-- navbar right -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <div class="user-panel d-flex" style="margin-top: 3px">
                <div class="image">
                    <img src="{{'/img/profile/user1.jpg'}}" class="img-circle elevation-2" alt="img">
                </div>
                <div class="info">
                    <a href="{{route('login')}}" class="d-block" style="color: rgba(0, 0, 0, 0.5)">
                        {{auth()->user()->name}}
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button class="nav-link logout btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Chiqish</span>
                </button>
            </form>
        </li>
    </ul>
</nav>
