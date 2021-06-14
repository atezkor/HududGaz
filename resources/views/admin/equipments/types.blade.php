@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        @include('components.errors')
        <div class="card">
            <div class="card-header">
                <button class="btn btn-info" onclick="show()">{{__('admin.equipment.add_type')}}</button>
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
                        <th>{{__('admin.equipment.equip_type')}}</th>
                        <th>{{__('admin.equipment.equip_order')}}</th>
                        <th style="width: 1px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                        <tr>
                            <td>{{$model->type}}</td>
                            <td>{{$model->order}}</td>
                            <td>
                                <form action="{{route('admin.equip_type.del', ['type' => $model])}}" method="post" class="form">
                                    @csrf
                                    <button type="button" class="btn btn-warning" title="{{__('global.btn_edit')}}"
                                            onclick="show('{{$model->type}}', {{$model->order}},
                                                '{{route('admin.equip_type.renew', ['equipment' => $equipment, 'type' => $model])}}')" role="button">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="remove(this)" title="{{__('global.btn_del')}}">
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
                    <div class="modal-header bg-purple">
                        <h4 id="header" class="modal-title">{{__('admin.equipment.add_type')}}</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('admin.equip_type.add', ['equipment' => $equipment])}}" method="POST"
                              id="form" onsubmit="submit.disabled = true">
                            @csrf
                            <div class="form-group">
                                <label for="type">{{__('admin.equipment.equip_type')}}</label>
                                <input type="text" name="type" id="type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="order">{{__('admin.equipment.equip_order')}}</label>
                                <input type="number" name="order" id="order" class="form-control">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" id="submit" class="btn btn-success">{{__('global.btn_save')}}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    {{__('global.btn_cancel')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/default.js'}}"></script>
<script>
    function remove(form) {
        Swal.fire({
            title: '{{__('admin.equipment.alert_type_msg')}}',
            text: "{{__('admin.alert_text')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{__('global.btn_yes')}}',
            cancelButtonText: '{{__('global.btn_no')}}'
        }).then((result) => {
            if (result.isConfirmed) {
                form.parentNode.submit();
                Swal.fire({
                    title: '{{__('global.del_process')}}',
                    icon: 'success',
                    showConfirmButton: false,
                });
            }
        });
    }

    function show(type = '', order = '', route) {
        $('#form').attr('action', route ? route : '{{route('admin.equip_type.add', ['equipment' => $equipment])}}');
        $('#header').text(type ? "{{__('admin.equipment.edit_type')}}" : "{{__('admin.equipment.add_type')}}");
        $('#type').val(type);
        $('#order').val(order);

        $('#modal').modal();
    }
</script>
@endsection
