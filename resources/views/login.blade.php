<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HududGaz | Kirish</title>
    <link rel="shortcut icon" href="{{'/img/favicon.png'}}" type="image/x-icon">

    <link rel="stylesheet" href="{{'/css/sans-pro.css'}}">
    <!-- CSS links -->
    <link rel="stylesheet" href="{{'/css/adminlte.min.css'}}">
    <!-- This is link for checkbox -->
    <link rel="stylesheet" href="{{asset('css/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{'/css/font-awesome-all.min.css'}}">
</head>
<body class="login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b>HUDUDGAZ XORAZM</b>
                <p>GAZ TA&#8217;MINOTI FILIALI</p>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Kirish uchun o&#8216;z maxfiy ma&#8217;lumotlaringizdan foydalaning</p>
                <form action="" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        {{-- old funksiyasi tasdiqlanmagan maydonni qayta to'ldrish uchun kerak --}}
                        <input type="text" name="username" value="{{old('username')}}" class="form-control"
                               placeholder="Foydalanuvchi nomi"
                               autocomplete="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Yashirin so&#8216;z">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" value="1">
                                <label for="remember">Eslab qol</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Kirish</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{'/js/jquery.min.js'}}"></script>
    <script src="{{"/js/bootstrap.bundle.min.js"}}"></script>
    <script src="{{'/js/adminlte.min.js'}}"></script>
</body>
</html>
