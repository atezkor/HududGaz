@extends('secondary')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/datatable/datatables.bootstrap4.min.css'}}">
    <link rel="stylesheet" href="{{'/css/datatable/responsive.bootstrap4.min.css'}}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-center">
                        <thead>
                            <tr>
                                <th>@lang('global.index')</th>
                                <th>@lang('global.consumer')</th>
                                <th>@lang('mounter.tech_condition')</th>
                                <th>@lang('mounter.project.name')</th>
                                <th>@lang('mounter.montage')</th>
                                <th>@lang('mounter.organ')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($models as $key => $model)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$model->applicant}}</td>
                                    <td>
                                        <a href="{{route('technic.tech_condition.show', $model->tech_condition_id)}}"
                                           target="_blank">
                                            @lang('global.btn_show')
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('designer.project.show', $model->project_id)}}"
                                           target="_blank">
                                            @lang('global.btn_show')
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('mounter.montage.show', $model->id)}}" target="_blank">
                                            @lang('global.btn_show')
                                        </a>
                                    </td>
                                    <td>{{$organs[$model->organ]}}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="{{$model->progressColor($model->percent($limit))}}"
                                                 style="width: {{$model->percent($limit)}}%">
                                            </div>
                                        </div>
                                        <div class="text-center">{{$limit}} @lang('global.hour')</div>
                                    </td>
                                    <td>
                                        <form action="{{route('mounter.montage.upload', $model->id)}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" id="file-{{$key}}"
                                                   onchange="this.parentElement.submit()" hidden>
                                            <label for="file-{{$key}}" class="btn btn-outline-info text-bold my-0"
                                                   title="@lang('global.btn_upload')">
                                                <i class="fas fa-upload"></i>
                                            </label>
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
@endsection
@section('js')
    <script src="{{'/js/jquery.min.js'}}"></script>
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script src="{{'/js/datatable/datatables.jquery.min.js'}}"></script>
    <script src="{{'/js/datatable/datatables.bootstrap4.min.js'}}"></script>
    <script src="{{'/js/datatable/datatables.responsive.min.js'}}"></script>
    <script src="{{'/js/default.js'}}"></script>
    <script>
        datatable({
            emptyTable: "@lang('global.datatables.emptyTable')",
            infoEmpty: "@lang('global.datatables.infoEmpty')",
            sSearch: "@lang('global.datatables.search')",
            oPaginate: {
                sPrevious: "@lang('global.datatables.previous')",
                sNext: "@lang('global.datatables.next')",
            },
            sInfo: "@lang('global.datatables.info')",
            sZeroRecords: "@lang('global.datatables.zeroRecords')",
            sInfoFiltered: "@lang('global.datatables.infoFiltered')"
        }, 'table');
    </script>
@endsection

