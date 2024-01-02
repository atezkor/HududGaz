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
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="#completed" class="nav-link active" data-toggle="tab">
                                @lang('organ.completed')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#uncompleted" class="nav-link" data-toggle="tab">
                                @lang('organ.uncompleted')
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div id="completed" class="tab-pane active">
                            <table id="table1" class="table table-bordered table-striped table-center">
                                <thead>
                                    <tr>
                                        <th>@lang('global.index')</th>
                                        <th>@lang('global.proposition.number')</th>
                                        <th>@lang('global.consumer')</th>
                                        <th>@lang('organ.recommendation.name')</th>
                                        <th>@lang('global.tech_condition')</th>
                                        <th>@lang('global.project')</th>
                                        <th>@lang('global.montage')</th>
                                        <th>@lang('global.proposition.date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($propositions as $model)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('propositions.show', $model->id)}}" target="_blank">
                                                    <span>{{$model->number}}</span>
                                                </a>
                                            </td>
                                            <td>{{$model->applicant->name}} ({{$model->applicant->tin_pin}})</td>
                                            <td>
                                                <a href="{{route('organ.recommendation.show', $model->recommendation->id)}}"
                                                   target="_blank">
                                                    <span>@lang('global.btn_show')</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('propositions.show', $model->id)}}" target="_blank">
                                                    <span>@lang('global.btn_show')</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('propositions.show', $model->id)}}" target="_blank">
                                                    <span>@lang('global.btn_show')</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('propositions.show', $model->id)}}" target="_blank">
                                                    <span>@lang('global.btn_show')</span>
                                                </a>
                                            </td>
                                            <td>{{$model->created_at->format('d.m.Y H:i')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="uncompleted" class="tab-pane fade">
                            <table id="table2" class="table table-bordered table-striped table-center">
                                <thead>
                                    <tr>
                                        <th>@lang('global.index')</th>
                                        <th>@lang('global.proposition.number')</th>
                                        <th>@lang('global.consumer')</th>
                                        <th>@lang('global.proposition.name')</th>
                                        <th>@lang('organ.recommendation.name')</th>
                                        <th>@lang('organ.tech_condition')</th>
                                        <th>@lang('organ.recommendation.reason')</th>
                                        <th>@lang('global.proposition.date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $model)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$model->number}}</td>
                                            <td>{{$model->applicant->name}} ({{$model->applicant->tin_pin}})</td>
                                            <td>
                                                <a href="{{$provider($model->proposition)}}"
                                                   target="_blank">@lang('global.btn_show')</a>
                                            </td>
                                            <td>
                                                <a href="{{$provider($model->recommendation)}}"
                                                   target="_blank">@lang('global.btn_show')</a>
                                            </td>
                                            <td>
                                                <a href="{{$provider($model->condition)}}"
                                                   target="_blank">@lang('global.btn_show')</a>
                                            </td>
                                            <td>{{$model->reason}}</td>
                                            <td>{{$model->created_at->format('d.m.Y H:i')}}</td>
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
        }, 'table1', 'table2');
    </script>
@endsection
