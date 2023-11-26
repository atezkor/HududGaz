@extends('layout')
@section('title', $branch)

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('admin.users.create')}}" class="btn btn-info">
                            @lang('admin.user.btn_add')
                        </a>
                        <div class="card-tools mt-2">
                            <div class="input-group ml-auto">
                                <input type="search" id="search" oninput="search(this)" class="form-control"
                                       placeholder="{{__('global.search')}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{__('global.index')}}</th>
                                    <th>{{__('admin.user.col_name')}}</th>
                                    <th>{{__('admin.user.col_position')}}</th>
                                    <th>{{__('admin.user.username')}}</th>
                                    <th>{{__('admin.user.col_role')}}</th>
                                    <th style="width: 1px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$model->name}}</td>
                                    <td>{{$model->position}}</td>
                                    <td>{{$model->username}}</td>
                                    <td>{{$roles[$model->role_id]}}</td>
                                    <td>
                                        <form action="{{route('admin.users.delete', $model->id)}}" method="post">
                                            <a href="{{route('admin.users.edit', $model->id)}}"
                                               class="btn btn-warning"
                                               title="{{__('global.btn_edit')}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="remove(this)" class="btn btn-danger"
                                                    title="{{__('global.btn_del')}}" role="button">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{'/js/default.js'}}"></script>
<script>
    function remove(btn) {
        Swal.fire({
            title: "@lang('admin.user.alert_title')",
            text: "@lang('admin.alert_text')",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: "@lang('global.btn_yes')",
            cancelButtonText: "@lang('global.btn_no')"
        }).then((result) => {
            if (result.isConfirmed) {
                btn.parentNode.submit()
                Swal.fire({
                    title: "@lang('global.del_process')",
                    icon: 'success',
                    showConfirmButton: false
                });
            }
        });
    }

    toast("{{session()->get('msg')}}", "{{session()->get('msg_type')}}");
</script>
@endsection
