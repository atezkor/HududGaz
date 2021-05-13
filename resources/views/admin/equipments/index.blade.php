@extends('layout')
@section('title', 'Jihozlar')

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
{{--                @include('voyager::alerts')--}}
                <div class="card">
                    <div class="card-header">
                        <a href="{{route('admin.equipments.create')}}" class="btn btn-info">{{__('table.equipments.btn_add')}}</a>
                        <div class="card-tools mt-2">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" id="search" class="form-control float-right"
                                       placeholder="{{__('table.search')}}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th class="col-6">{{__('table.equipments.col_name')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$model->name}}</td>
                                    <td>
                                        <form action="{{route('admin.equipments.delete', ['equipment' => $model])}}" method="post"
                                              id="form-{{$model->id}}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{route('admin.equip_type', ['equipment' => $model])}}" class="btn btn-info mr-2">
                                                {{__('table.equipments.equip_type')}}
                                            </a>
                                            <a href="{{route('admin.equipments.edit', ['equipment' => $model])}}" class="btn btn-warning"
                                               title="{{__('table.btn_edit')}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" onclick="remove('form-{{$model->id}}')"
                                                    title="{{__('table.btn_del')}}" role="button">
                                                <i class="fas fa-trash-alt"></i>
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
@stop
@section('javascript')
<script>
    $('#search').keyup(function () {
        let value = this.value.toLowerCase();
        $('tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        })
    });

    function remove(form) {
        Swal.fire({
            title: '{{__('table.equipments.alert_message')}}',
            text: "{{__('table.general.alert_text')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{__('table.btn_yes')}}',
            cancelButtonText: '{{__('table.btn_no')}}'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#${form}`).submit()
                Swal.fire({
                    title: '{{__('table.del_process')}}',
                    icon: 'success',
                    showConfirmButton: false,
                })
            }
        })
    }
</script>
@endsection
