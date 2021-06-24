@php
    if (in_array(request()->user()->role, [1, 2, 5, 7]))
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
                                            <a href="#main" class="nav-link active" data-toggle="tab">
                                                @lang('global.profile.main')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#extra" class="nav-link" data-toggle="tab">
                                                @lang('global.profile.extra')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form action="{{$action}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('components.errors')
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="main" class="tap-pane active">
                                        <div class="form-group row">
                                            <label for="username" class="col-2">@lang('global.profile.username')</label>
                                            <div class="col-10">
                                                <input type="text" name="username" id="username" value="{{$model->username}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-2">@lang('global.profile.name')</label>
                                            <div class="col-10">
                                                <input type="text" name="name" id="name" value="{{$model->name}}"
                                                       class="form-control" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="lastname" class="col-2">@lang('global.profile.lastname')</label>
                                            <div class="col-10">
                                                <input type="text" name="lastname" id="lastname" value="{{$model->lastname}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="patronymic" class="col-2">@lang('global.profile.patronymic')</label>
                                            <div class="col-10">
                                                <input type="text" name="patronymic" id="patronymic" value="{{$model->patronymic}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="position" class="col-2">@lang('global.profile.position')</label>
                                            <div class="col-10">
                                                <input type="text" name="position" id="position" value="{{$model->position}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="locale" class="col-2">@lang('global.profile.locale')</label>
                                            <div class="col-10">
                                                <select name="locale" id="locale" class="form-control">
                                                    <option value="uz">@lang('global.profile.uz')</option>
                                                    <option value="uzk" @if ($model->locale == 'uzk') {{'selected'}} @endif>
                                                        @lang('global.profile.uzk')
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-2">
                                                <img src="{{setImage($model)}}" id="img" class="profile-user-img img-circle" alt="{{$model->avatar}}">
                                            </div>
                                            <div class="col-10">
                                                <div class="custom-file mt-4">
                                                    <input type="file" name="avatar" id="avatar" onchange="changeImg(this)" class="custom-file-input">
                                                    <label for="avatar" class="custom-file-label">
                                                        <span id="file_hint">@lang('global.profile.img')</span>
                                                        <span class="btn btn-info"><i class="fas fa-file-image"></i></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="extra" class="tap-pane fade">
                                        <div class="form-group row">
                                            <label for="old_pass" class="col-2">@lang('global.profile.old_pass')</label>
                                            <div class="col-10">
                                                <input type="password" name="old_pass" id="old_pass" value="{{old('old_pass')}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-2">@lang('global.profile.password')</label>
                                            <div class="col-10">
                                                <input type="password" name="password" id="password" value="{{old('password')}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="confirm_pass" class="col-2">@lang('global.profile.confirm_pass')</label>
                                            <div class="col-10">
                                                <input type="password" name="confirm_pass" id="confirm_pass" value="{{old('confirm_pass')}}"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">@lang('global.btn_save')</button>
                                <a href="{{route('dashboard')}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                                <button type="reset" id="reset" class="btn btn-default float-right">@lang('global.btn_reset')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('javascript')
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
    </script>
@endsection
