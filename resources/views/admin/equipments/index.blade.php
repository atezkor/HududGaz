@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <button onclick="addEquipment()" class="btn btn-info">{{__('admin.equipment.heading_create')}}</button>
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
                            <th class="col-12">{{__('admin.equipment.name')}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                        <tr>
                            <td>{{$model->name}}</td>
                            <td>
                                <form action="{{route('admin.equipments.delete', ['equipment' => $model])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('admin.equip_type', ['equipment' => $model])}}" class="btn btn-outline-info mr-2">
                                        {{__('admin.equipment.equip_types')}}
                                    </a>
                                    <button type="button" onclick="edit('{{route('admin.equipments.update', ['equipment' => $model])}}', '{{$model->name}}')"
                                            class="btn btn-warning" title="{{__('global.btn_edit')}}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="remove(this)"
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
        <!-- Modal -->
        <div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary">
                        <h4 id="header" class="modal-title">{{__('admin.equipment.heading_create')}}</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.equipments.store')}}" method="POST"
                              id="form" onsubmit="submit.disabled = true">
                            @csrf
                            <input type="hidden" id="method" name="_method" value="POST">
                            <div class="form-group">
                                <label for="name">{{__('admin.equipment.name')}}</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" id="submit" class="btn btn-primary">{{__('global.btn_add')}}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('global.btn_cancel')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('javascript')
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/default.js'}}"></script>
<script>
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
                form.parentNode.submit()
                Swal.fire({
                    title: '{{__('global.del_process')}}',
                    icon: 'success',
                    showConfirmButton: false,
                });
            }
        });
    }

    function addEquipment() {
        $('#modal').modal();
        $('#name').val(null);
        $('#method').val('POST');
        $('#header').text('{{__('admin.equipment.heading_create')}}');
        $('#submit').text('{{__('global.btn_add')}}');

        $('#form').attr('action', '{{route('admin.equipments.store')}}');
    }

    function edit(url, name) {
        $('#modal').modal();
        $('#name').val(name);
        $('#method').val('PUT');
        $('#header').text('{{__('admin.equipment.heading_edit')}}');
        $('#submit').text('{{__('global.btn_upd')}}');

        $('#form').attr('action', url);
    }
</script>
@endsection
