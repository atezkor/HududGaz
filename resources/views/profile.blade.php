@php
    if (isPrimaryTheme())
        $layout = 'layout';
    else
        $layout = 'secondary';
@endphp
@extends($layout)
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a href="#main" id="nav-main" class="nav-link active" data-toggle="tab">
                                                @lang('global.profile.main')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#extra" id="nav-pass" class="nav-link" data-toggle="tab">
                                                @lang('global.profile.extra')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="main" class="tap-pane active">
                                    <form action="{{route('profile.update', $model->id)}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="username" class="col-2">@lang('global.profile.username')</label>
                                            <div class="col-10">
                                                <input type="text" name="username" id="username"
                                                       class="form-control @error('name'){{ "is-invalid" }}@enderror"
                                                       value="{{old('username', $model->username)}}">
                                                <span class="error invalid-feedback">
                                                    @error('username'){{ $message  }}@enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-2">@lang('global.profile.name')</label>
                                            <div class="col-10">
                                                <input type="text" name="name" id="name"
                                                       class="form-control @error('name'){{ "is-invalid" }}@enderror"
                                                       value="{{old('name', $model->name)}}" autocomplete="off">
                                                <span class="error invalid-feedback">
                                                    @error('name'){{ $message  }}@enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="lastname" class="col-2">@lang('global.profile.lastname')</label>
                                            <div class="col-10">
                                                <input type="text" name="lastname" id="lastname"
                                                       class="form-control @error('lastname') is-invalid @enderror"
                                                       value="{{old('lastname', $model->lastname)}}" autocomplete="off">
                                                <span class="error invalid-feedback">
                                                    @error('lastname'){{ $message  }}@enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="patronymic"
                                                   class="col-2">@lang('global.profile.patronymic')</label>
                                            <div class="col-10">
                                                <input type="text" name="patronymic" id="patronymic"
                                                       class="form-control"
                                                       value="{{old('patronymic', $model->patronymic)}}"
                                                       autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="position" class="col-2">@lang('global.profile.position')</label>
                                            <div class="col-10">
                                                <input type="text" name="position" id="position" class="form-control"
                                                       value="{{old('position', $model->position)}}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="locale" class="col-2">@lang('global.profile.locale')</label>
                                            <div class="col-10">
                                                <select name="locale" id="locale" class="form-control">
                                                    <option value="uz">@lang('global.profile.uz')</option>
                                                    <option
                                                        value="uzk" @if ($model->locale == 'uzk') {{'selected'}} @endif>
                                                        @lang('global.profile.uzk')
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-2">
                                                <img src="{{setImage($model)}}" id="img"
                                                     class="profile-user-img img-circle" alt="{{$model->avatar}}">
                                            </div>
                                            <div class="col-10">
                                                <div class="custom-file mt-4">
                                                    <input type="file" name="avatar" id="avatar"
                                                           onchange="changeImg(this)" class="custom-file-input">
                                                    <label for="avatar" class="custom-file-label">
                                                        <span id="file_hint">@lang('global.profile.img')</span>
                                                        <span class="btn btn-info"><i
                                                                class="fas fa-file-image"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <span>@lang('global.btn_save')</span>
                                            </button>
                                            <a href="{{route('dashboard')}}" class="btn btn-outline-secondary">
                                                <span>@lang('global.btn_back')</span>
                                            </a>
                                            <button type="reset" class="btn btn-default float-right">
                                                <span>@lang('global.btn_reset')</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div id="extra" class="tap-pane fade">
                                    <form action="{{route('profile.update', $model->id)}}" method="POST">
                                        @csrf

                                        <input type="hidden" name="pass" value="1">

                                        <div class="form-group row">
                                            <label for="password_old"
                                                   class="col-2">@lang('global.profile.pass_old')</label>
                                            <div class="col-10">
                                                <input type="password" name="password_old" id="password_old"
                                                       class="form-control @error("password_old"){{ "is-invalid" }}@enderror"
                                                       value="{{old('password_old')}}">
                                                <span class="error invalid-feedback">
                                                    @error("password_old"){{ $message }}@enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-2">@lang('global.profile.password')</label>
                                            <div class="col-10">
                                                <input type="password" name="password" id="password"
                                                       class="form-control @error("password"){{ "is-invalid" }}@enderror"
                                                       value="{{old('password')}}">
                                                <span class="error invalid-feedback">
                                                    @error("password"){{ $message }}@enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password_confirm" class="col-2">
                                                @lang('global.profile.pass_confirm')
                                            </label>
                                            <div class="col-10">
                                                <input type="password" name="password_confirm" id="password_confirm"
                                                       class="form-control @error("password_confirm"){{ "is-invalid" }}@enderror"
                                                       value="{{old('password_confirm')}}">
                                                <span class="error invalid-feedback">
                                                    @error("password_confirm"){{ $message }}@enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <span>@lang('global.btn_save')</span>
                                            </button>
                                            <a href="{{route('dashboard')}}" class="btn btn-outline-secondary">
                                                <span>@lang('global.btn_back')</span>
                                            </a>
                                            <button type="reset" class="btn btn-default float-right">
                                                <span>@lang('global.btn_reset')</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script>
        function changeImg(input) {
            $('#img').attr('src', URL.createObjectURL(input.files[0]));
            $('#file_hint').text(input.files[0].name);
        }

        $('#reset').on('click', function() {
            $('#file_hint').text("@lang('global.profile.img')");
            $('#img').attr('src', "{{'/img/avatar.svg'}}");
        });

        $(document).ready(() => {
            @if(old('pass'))
            $("#nav-pass").tab("show")
            @endif
        });
    </script>
@endsection
