@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        @include('components.errors')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-info" onclick="show()" role="button">
                            {{__('admin.activity.btn_add')}}
                        </button>
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
                                    <th>{{__('admin.activity.col_activity')}}</th>
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
                                              method="post" class="form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-warning" title="{{__('global.btn_edit')}}"
                                                    onclick="show('{{$model->activity}}', '{{route('admin.activities.update', ['activity_type' => $model])}}')">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
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
                <!-- Modal -->
                <div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-purple">
                                <h4 id="header" class="modal-title">{{__('admin.activity.add_activity')}}</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.activities.store')}}" method="POST"
                                      id="form" onsubmit="submit.disabled = true">
                                    @csrf
                                    <input type="hidden" name="_method" id="_method" value="POST">
                                    <div class="form-group">
                                        <label for="activity">{{__('admin.activity.activity')}}</label>
                                        <input type="text" name="activity" id="activity" class="form-control">
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
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/default.js'}}"></script>
<script>
    function show(activity = '', route) {
        $('#form').attr('action', route ? route : '{{route('admin.activities.store')}}');
        $('#header').text(activity ? "{{__('admin.activity.edit_activity')}}" : "{{__('admin.activity.add_activity')}}");
        $('#activity').val(activity);
        $('#_method').val(activity ? 'PUT' : 'POST');

        $('#modal').modal();
    }

    function remove(btn) {
        Swal.fire({
            title: "{{__('admin.activity.alert_title')}}",
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

    toast("{{session()->get('msg')}}", "{{session()->get('msg_type')}}");
</script>
@endsection
