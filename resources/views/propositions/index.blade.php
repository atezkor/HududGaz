@extends('layout')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/datatable/datatables.bootstrap4.min.css'}}">
<link rel="stylesheet" href="{{'/css/datatable/responsive.bootstrap4.min.css'}}">
<link rel="stylesheet" href="{{'/css/default.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a href="#individual" class="nav-link active" data-toggle="tab">
                                            @lang('technic.propositions.individual')
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#legal_entity" class="nav-link" data-toggle="tab">
                                            @lang('technic.propositions.legal')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col">
                                <a href="{{route('propositions.create')}}" class="btn btn-info float-md-right">
                                    @lang('technic.btn_new')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="individual" class="tab-pane active">
                                <table id="table1" class="table table-bordered table-striped table-center">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>@lang('technic.prop_num')</th>
                                            <th>@lang('technic.col_stir')</th>
                                            <th>@lang('technic.district')</th>
                                            <th>@lang('technic.col_prop')</th>
                                            <th>@lang('technic.col_date')</th>
                                            <th>@lang('technic.col_limit')</th>
                                            <th>@lang('technic.col_action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php($limit = term(4))
                                    @foreach($individuals as $model)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$model->number}}</td>
                                            <td>{{$physicals[$loop->index]->stir}}</td>
                                            <td>{{$district($model->district)}}</td>
                                            <td>
                                                <a href="{{route('propositions.show', ['proposition' => $model])}}" target="_blank">
                                                    @lang('technic.propositions.show')
                                                </a>
                                            </td>
                                            <td>{{$model->created_at}}</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="{{progressColor($model->percent($limit[$model->status - 1]->term))}}"
                                                         style="width: {{$model->percent($limit[$model->status - 1]->term)}}%"></div>
                                                </div>
                                                <div class="text-center">{{$limit[$model->status - 1]->term}} @lang('global.hour')</div>
                                            </td>
                                            <td>
                                                <form action="{{route('propositions.delete', ['proposition' => $model])}}"
                                                      method="post" id="form-{{$model->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{route('propositions.edit', ['proposition' => $model])}}" class="btn btn-outline-info"
                                                       title="@lang('global.btn_edit')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" onclick="remove('form-{{$model->id}}')" class="btn btn-outline-danger"
                                                            title="@lang('global.btn_del')" role="button">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div id="legal_entity" class="tap-pane">
                                <table id="table2" class="table table-bordered table-striped table-center">
                                    <thead>
                                        <tr>
                                            <th>@lang('technic.index')</th>
                                            <th>@lang('technic.prop_num')</th>
                                            <th>@lang('technic.col_legal_stir')</th>
                                            <th>@lang('technic.district')</th>
                                            <th>@lang('technic.col_prop')</th>
                                            <th>@lang('technic.col_date')</th>
                                            <th>@lang('technic.col_limit')</th>
                                            <th>@lang('technic.col_action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($legalEntities as $model)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$model->number}}</td>
                                            <td>{{$legals[$loop->index]->legal_stir}}</td>
                                            <td>{{$district($model->district)}}</td>
                                            <td>
                                                <a href="{{route('propositions.show', ['proposition' => $model])}}" target="_blank">
                                                    @lang('technic.propositions.show')
                                                </a>
                                            </td>
                                            <td>{{$model->created_at}}</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="{{progressColor($model->percent($limit[$model->status - 1]->term))}}"
                                                         style="width: {{$model->percent($limit[$model->status - 1]->term)}}%"></div>
                                                </div>
                                                <div class="text-center">{{$limit[$model->status - 1]->term}} @lang('global.hour')</div>
                                            </td>
                                            <td>
                                                <form action="{{route('propositions.delete', ['proposition' => $model])}}"
                                                      method="post" id="legal-form-{{$model->id}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{route('propositions.edit', ['proposition' => $model])}}" class="btn btn-outline-info"
                                                       title="@lang('global.btn_edit')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" onclick="remove('legal-form-{{$model->id}}')" class="btn btn-outline-danger"
                                                            title="@lang('global.btn_del')" role="button">
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
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{'/js/jquery.min.js'}}"></script>
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.jquery.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.bootstrap4.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.responsive.min.js'}}"></script>
<script>
    $(function () {
        let lang = {
            emptyTable: "@lang('global.datatables.emptyTable')",
            infoEmpty: "@lang('global.datatables.infoEmpty')",
            sSearch: "@lang('global.datatables.search')",
            oPaginate: {
                sPrevious: "@lang('global.datatables.previous')",
                sNext: "@lang('global.datatables.next')",
            },
            sInfo: "@lang('global.datatables.info')",
            sZeroRecords: "@lang('global.datatables.zeroRecords')"
        }

        $("#table1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            searching: true,
            language: lang
        });

        $('#table2').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            searching: true,
            language: lang
        });
    });

    function remove(form) {
        Swal.fire({
            title: '{{__('technic.propositions.alert_message')}}',
            text: "{{__('technic.propositions.alert_text')}}",
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
                });
            }
        });
    }
</script>
@endsection
