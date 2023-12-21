<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container-fluid" style="width: 90%">
        <a href="{{route('dashboard')}}" class="navbar-brand col-3" style="min-width: 250px">
            <img src="{{'/img/logo.png'}}" alt="{{getName()}}" class="col-12">
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @php($user = auth()->user())
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav custom-navbar">
            @php($items = menuItems())
            @foreach($items as $key => $menu)
                <li class="nav-item">
                    <a href="{{route($menu->href)}}" class="nav-link text-nowrap">
                        <span>@lang($menu->title)</span>
                        <span class="badge {{$menu->icon}}">{{$numbers[$key]}}</span>
                    </a>
                </li>
            @endforeach
            </ul>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <div class="user-panel d-flex" style="margin-top: 3px">
                    <div class="image">
                        <img src="{{setImage($user)}}" class="img-circle elevation-1" alt="img">
                    </div>
                    <div class="info">
                        <a href="{{route('profile.edit', ['user' => $user->getAuthIdentifier()])}}" class="d-block" style="color: rgba(0, 0, 0, 0.5)">
                            {{$user->name}}
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
    </div>
</nav>
