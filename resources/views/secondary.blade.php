<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('meta')

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{'/img/favicon.png'}}" type="image/x-icon">

    <!-- CSS links -->
    <link rel="stylesheet" href="{{'/css/sans-pro.css'}}">
    <link rel="stylesheet" href="{{'/css/adminlte.min.css'}}">
    <link rel="stylesheet" href="{{'/css/font-awesome-all.min.css'}}">
    <link rel="stylesheet" href="{{'/css/sweetalert2.css'}}">
    <!-- Additional CSS files -->
    @yield('link')

    <link rel="stylesheet" href="{{'/css/default.css'}}">
</head>
<body class="layout-top-nav">
<div class="preloader flex-column justify-content-center align-items-center">
    <img src="{{'/img/logo.png'}}" alt="logo" class="animation__shake" width="30%">
</div>

<div class="wrapper">
    @include('components.menu')
    <div class="content-wrapper">
        <div class="mx-auto" style="width: 90%">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{'/js/jquery.min.js'}}"></script>
<script src="{{'/js/adminlte.min.js'}}"></script>
<script src="{{'/js/sweetalert2.js'}}"></script>
@yield('javascript')
</body>
</html>
