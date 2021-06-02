@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{route('admin.equipments.create')}}" class="btn btn-info">{{__('admin.equipment.heading_create')}}</a>
                <div class="card-tools mt-2">
                    <div class="input-group w-75 ml-auto">
                        <input type="search" id="search" class="form-control"
                               placeholder="{{__('global.search')}}">
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th class="col-12">{{__('admin.equipment.name')}}</th>
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
                                    <a href="{{route('admin.equip_type', ['equipment' => $model])}}" class="btn btn-outline-info mr-2">
                                        {{__('admin.equipment.equip_types')}}
                                    </a>
                                    <a href="{{route('admin.equipments.edit', ['equipment' => $model])}}" class="btn btn-warning"
                                       title="{{__('global.btn_edit')}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" onclick="remove('form-{{$model->id}}')"
                                            title="{{__('global.btn_del')}}" role="button">
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
</section>
@stop
@section('javascript')
<script>
    $('#search').keyup(function() {
        let value = this.value.toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    function remove(form) {
        Swal.fire({
            title: '{{__('admin.equipment.alert_title')}}',
            text: "{{__('admin.alert_text')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{__('global.btn_yes')}}',
            cancelButtonText: '{{__('global.btn_no')}}'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#${form}`).submit()
                Swal.fire({
                    title: '{{__('global.del_process')}}',
                    icon: 'success',
                    showConfirmButton: false,
                })
            }
        })
    }
</script>
@endsection
