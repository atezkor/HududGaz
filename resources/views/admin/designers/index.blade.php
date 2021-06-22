@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('admin.designers.create')}}" class="btn btn-info">{{__('admin.designer.btn_new')}}</a>
                        <div class="card-tools mt-2">
                            <div class="input-group w-75 ml-auto">
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
                                    <th>{{__('admin.org_name')}}</th>
                                    <th>{{__('admin.org_leader')}}</th>
                                    <th>{{__('admin.address')}}</th>
                                    <th>{{__('admin.period_activity')}}</th>
                                    <th style="width: 1px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$model->org_name}}</td>
                                    <td>{{$model->leader}}</td>
                                    <td>{{$model->address}}</td>
                                    <td>{{formatDate($model->date_reg)}} - {{formatDate($model->date_end)}}</td>
                                    <td>
                                        <form action="{{route('admin.designers.delete', ['designer' => $model])}}"
                                              method="post" class="form">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{route('admin.designers.edit', ['designer' => $model])}}" class="btn btn-warning"
                                               title="{{__('global.btn_edit')}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
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
@section('javascript')
<script src="{{'/js/default.js'}}"></script>
<script>
    function remove(btn) {
        Swal.fire({
            title: '{{__('admin.designer.alert_title')}}',
            text: "{{__('admin.alert_text')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: "{{__('global.btn_yes')}}",
            cancelButtonText: "{{__('global.btn_no')}}"
        }).then((result) => {
            if (result.isConfirmed) {
                btn.parentNode.submit();
                Swal.fire({
                    title: "{{__('global.del_process')}}",
                    icon: 'success',
                    showConfirmButton: false
                });
            }
        });
    }
</script>
@endsection
