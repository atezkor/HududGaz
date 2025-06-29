<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- navbar left -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul id="navbar" class="navbar-nav" style="display: none">
        <li class="nav-item ml-5">
            <div>
                <h3 class="card-title">@lang('global.navbar.today'): <span>{{$numbers[0]}}</span></h3>
            </div>
        </li>
        <li class="nav-item ml-5">
            <div>
                <h3 class="card-title">@lang('global.navbar.process'): <span>{{$numbers[1]}}</span></h3>
            </div>
        </li>
        <li class="nav-item ml-5">
            <div>
                <h3 class="card-title">@lang('global.navbar.late'): <span>{{$numbers[2]}}</span></h3>
            </div>
        </li>
        <li class="nav-item ml-5">
            <div>
                <h3 class="card-title">@lang('global.navbar.year'): <span>{{$numbers[3]}}</span></h3>
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
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="nav-link logout btn" title="@lang('global.logout')">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>@lang('global.logout')</span>
                </button>
            </form>
        </li>
    </ul>
</nav>
