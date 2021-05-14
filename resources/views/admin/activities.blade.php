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

                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-info" onclick="show()" role="button">
                                {{__('table.activities.btn_add')}}
                            </button>
                            <div class="card-tools mt-2">
                                <div class="input-group input-group-sm" style="width: 150px; font-size: 14px;">
                                    <input type="text" id="search" class="form-control float-right"
                                           placeholder="{{__('table.search')}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <small><i class="fas fa-search"></i></small>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{__('table.general.col_index')}}</th>
                                        <th>{{__('table.activities.col_activity')}}</th>
                                        <th style="width: 1px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$model->activity}}</td>
                                        <td>
                                            <form action="{{route('admin.activities.delete', ['activity_type' => $model])}}"
                                                  method="post" id="form-{{$model->id}}" class="form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-warning" title="{{__('table.btn_edit')}}"
                                                        onclick="show('{{$model->activity}}', '{{route('admin.activities.update', ['activity_type' => $model])}}')"
                                                        role="button">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" onclick="remove('form-{{$model->id}}')" class="btn btn-danger"
                                                        title="{{__('table.btn_del')}}" role="button">
                                                    <i class="far fa-trash-alt"></i>
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
                                        <h4 id="header" class="modal-title">{{__('table.activities.add_activity')}}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('admin.activities.store')}}"
                                              method="POST" id="form">
                                            @csrf
                                            <input type="hidden" name="_method" id="_method" value="POST">
                                            <div class="form-group">
                                                <label for="activity">{{__('table.activities.activity')}}</label>
                                                <input type="text" name="activity" id="activity" class="form-control">
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="submit" class="btn btn-success">{{__('table.btn_save')}}</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    {{__('table.btn_cancel')}}
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

        function show(activity = '', route) {
            $('#form').attr('action', route ? route : '{{route('admin.activities.store')}}');
            $('#header').text(activity ? "{{__('table.activities.edit_activity')}}" : "{{__('table.activities.add_activity')}}");
            $('#activity').val(activity);
            $('#_method').val(activity ? 'PUT' : 'POST');

            $('#modal').modal();
        }

        function remove(form) {
            Swal.fire({
                title: '{{__('table.activities.alert_message')}}',
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
