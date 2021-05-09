<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- CSS links -->
{{--    <link rel="stylesheet" href="{{'/css/bootstrap.min.css'}}">--}}
    <link rel="stylesheet" href="{{'/css/adminlte.min.css'}}">
    <link rel="stylesheet" href="{{'/css/font-awesome-all.min.css'}}">
    <!-- Additional CSS files -->
    @yield('css')
</head>
<body>
    <div class="preloader flex-column justify-content-center align-items-center">
        <img src="{{'/img/logo.png'}}" alt="logo" class="animation__shake" width="30%">
    </div>
    <div class="wrapper">
        @include('components.navbar')
        @include('components.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="{{'/js/jquery.min.js'}}"></script>
{{--    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>--}}
    <script src="{{'/js/adminlte.min.js'}}"></script> {{-- Preloader in this --}}
    @yield('javascript')
</body>
</html>
