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
                                <th>@lang('global.proposition.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$model->applicant->name}} ({{$model->applicant->tin_pin}})</td>
                                    <td>
                                        <a href="{{route('mounter.tech-condition.view', $model->tech_condition_id)}}"
                                           target="_blank">
                                            <span>@lang('global.btn_show')</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('mounter.project.view', $model->project_id)}}"
                                           target="_blank">
                                            <span>@lang('global.btn_show')</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('mounter.montage.view', $model)}}" target="_blank">
                                            <span>@lang('global.btn_show')</span>
                                        </a>
                                    </td>
                                    <td>{{$organs[$model->organ_id]}}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div
                                                class="{{$model->progressColor($model->percent($limit($model->status)))}}"
                                                style="width: {{$model->percent($limit($model->status))}}%">
                                            </div>
                                        </div>
                                        <div class="text-center">{{$limit($model->status)}} @lang('global.hour')</div>
                                    </td>
                                    <td>
                                        <span>{{$model->created_at->format('d.m.Y H:i')}}</span>
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

