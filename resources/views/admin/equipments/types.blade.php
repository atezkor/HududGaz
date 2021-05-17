@extends('layout')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/default.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('components.errors')
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-info" onclick="show()">{{__('table.equipments.btn_add')}}</button>
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
                                    <th>{{__('table.equipments.equip_type')}}</th>
                                    <th>{{__('table.equipments.equip_order')}}</th>
                                    <th style="width: 1px"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$model->type}}</td>
                                    <td>{{$model->order}}</td>
                                    <td>
                                        <form action="{{route('admin.equip_type.del', ['type' => $model])}}" method="post"
                                              id="form-{{$model->id}}" class="form">
                                            @csrf
                                            <button type="button" class="btn btn-warning" title="{{__('global.btn_edit')}}"
                                                    onclick="show('{{$model->type}}', {{$model->order}},
                                                        '{{route('admin.equip_type.renew', ['equipment' => $equipment, 'type' => $model])}}')" role="button">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="remove('form-{{$model->id}}')"
                                                    data-toggle="tooltip" title="{{__('global.btn_del')}}" role="button" >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-purple">
                                    <h4 id="header" class="modal-title">{{__('table.equipments.add_type')}}</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.equip_type.add', ['equipment' => $equipment])}}"
                                          method="POST" id="form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="type">{{__('table.equipments.equip_type')}}</label>
                                            <input type="text" name="type" id="type" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="order">{{__('table.equipments.equip_order')}}</label>
                                            <input type="number" name="order" id="order" class="form-control">
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="submit" class="btn btn-success">{{__('global.btn_save')}}</button>
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
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script>
        $('#search').keyup(function () {
            let value = this.value.toLowerCase();
            $('tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            })
        });

        function remove(form) {
            Swal.fire({
                title: '{{__('table.equipments.alert_type_msg')}}',
                text: "{{__('table.general.alert_text')}}",
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

        function show(type = '', order = '', route) {
            $('#form').attr('action', route ? route : '{{route('admin.equip_type.add', ['equipment' => $equipment])}}');
            $('#header').text(type ? "{{__('table.equipments.edit_type')}}" : "{{__('table.equipments.add_type')}}");
            $('#type').val(type);
            $('#order').val(order);

            $('#modal').modal();
        }
    </script>
@endsection
