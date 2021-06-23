<nav class="main-header navbar navbar-expand navbar-white navbar-light">
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
    @php($user = auth()->user())
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <div class="user-panel d-flex" style="margin-top: 3px">
                <div class="image">
                    <img src="{{setImage($user)}}" class="img-circle elevation-1" alt="img">
                </div>
                <div class="info">
                    <a href="{{route('profile.edit', ['user' => $user->getAuthIdentifier()])}}" class="d-block" style="color: rgba(0, 0, 0, 0.5)">
                        {{$user->name ?? ''}}
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link logout btn" data-toggle="tooltip" title="@lang('global.logout')">
                <i class="fas fa-sign-out-alt"></i>
                <span>@lang('global.logout')</span>
            </a>
        </li>
    </ul>
</nav>
