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
                                    <label for="username">{{__('admin.user.username')}}</label>
                                    <input type="text" name="username" id="username" value="{{$model->username}}" class="form-control" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('admin.user.password')}}</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        @if($model->password) placeholder="******" @endif>
                                </div>

                                <div class="form-group">
                                    <label for="role">{{__('admin.user.role')}}</label>
                                    <select name="role" id="role" onchange="changeRole(this.value)" class="form-control">
                                        <option value="">{{__('admin.user.select_role')}}</option>
                                        @foreach(roles() as $key => $role)
                                            <option value="{{$key}}"
                                                @if($key == $model->role){{'selected'}}@endif
                                            >{{$role}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="organs" class="form-group" style="display: none">
                                    <label for="organ">{{__('admin.user.organ')}}</label>
                                    <select name="organ" id="organ" class="form-control">
                                        <option value="">{{__('admin.user.select_organ')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="locale">{{__('admin.user.locale')}}</label>
                                    <select name="locale" id="locale" class="form-control">
                                        <option value="uz">{{__('admin.uz')}}</option>
                                        <option value="uzk" @if($model->locale == 'uzk') selected @endif>{{__('admin.uzk')}}</option>
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
@section('javascript')
    <script>
        let organs = $('#organs');
        let organ_id = {{$model->organ + 0}};
        function changeRole(role) {
            if (!role || [1, 2, 5].includes(parseInt(role))) {
                organs.hide(250);
                $('#organ').attr('required', false);
                return;
            }

            organs.show(250);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });
            $.ajax({
                url: '{{route('admin.change_role')}}' + `/${role}`,
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    dynamicSelect(data);
                }
            });
        }

        function dynamicSelect(data) {
            let organ = $('#organ');
            organ.attr('required', true);
            $(organ).children().each((index, e) => { // Remove all options
                if (index !== 0) {
                    e.remove();
                }
            });

            let j = 0; // Only not showing warnings. It's working less 'j'
            for (let i in data) {
                j = i;
                let option = document.createElement('option');
                if (organ_id === parseInt(j))
                    option.selected = true;

                option.value = j;
                option.text = data[j];
                organ.append(option);
            }
        }

        $(document).ready(function() {
            changeRole({{$model->role}});
        })
    </script>
@endsection
