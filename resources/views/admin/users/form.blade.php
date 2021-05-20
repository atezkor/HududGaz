@extends('layout')
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                @if($method == 'POST')
                                    {{__('admin.user.heading_create')}}
                                @else
                                    {{__('admin.user.heading_edit')}}
                                @endif
                            </h3>
                        </div>
                        <form action="{{$action}}" method="post">
                            @csrf
                            @method($method)
                            @include('components.errors')

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('admin.user.name')}}</label>
                                    <input type="text" name="name" id="name" value="{{$model->name}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="lastname">{{__('admin.user.lastname')}}</label>
                                    <input type="text" name="lastname" id="lastname" value="{{$model->lastname}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="patronymic">{{__('admin.user.patronymic')}}</label>
                                    <input type="text" name="patronymic" id="patronymic" value="{{$model->patronymic}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="email">{{__('admin.user.email')}}</label>
                                    <input type="text" name="email" id="email" value="{{$model->email}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('admin.user.password')}}</label>
                                    <input type="text" name="password" id="password" value="{{$model->password}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="role">{{__('admin.user.role')}}</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="">{{__('admin.user.select_role')}}</option>
                                        @foreach(roles() as $key => $role)
                                            <option value="{{$key}}"
                                                @if($key == $model->role){{'selected'}}@endif
                                            >{{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="organ">{{__('admin.user.organ')}}</label>
                                    <select name="organ" id="organ" class="form-control">
                                        <option value="">{{__('admin.user.select_organ')}}</option>
                                        @foreach(roles() as $key => $role)
                                            <option value="{{$key}}">{{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="locale">{{__('admin.user.locale')}}</label>
                                    <select name="locale" id="locale" class="form-control">
                                        <option value="uz">{{__('admin.uz')}}</option>
                                        <option value="uzk">{{__('admin.uzk')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="position">{{__('admin.user.position')}}</label>
                                    <input type="text" name="position" id="position" value="{{$model->position}}" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">
                                @if($method == 'POST')
                                    {{__('global.btn_save')}}
                                @else
                                    {{__('global.btn_renew')}}
                                @endif
                                </button>
                                <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                                <button type="reset" id="reset" class="btn btn-default float-right">{{__('global.btn_reset')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
