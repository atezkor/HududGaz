@extends('layout')
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
                    @can('crud_tech')
                        @php($show = true)
                    @else
                        @php($show = false)
                    @endcan
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-center">
                        <thead>
                            <tr>
                                <th>@lang('global.index')</th>
                                <th>@lang('global.proposition.number')</th>
                                <th>@lang('global.consumer')</th>
                                <th>@lang('technic.tech_condition.name')</th>
                                <th>@lang('technic.organ')</th>
                                <th>@lang('global.proposition.date')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
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
                                        <a href="{{route('technic.tech-condition.view', $model->techCondition->id)}}"
                                           target="_blank">
                                            @lang('technic.tech_condition.show')
                                        </a>
                                    </td>
                                    <td>{{$model->organ->name}}</td>
                                    <td>{{$model->techCondition->created_at->format('d.m.Y H:i')}}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="{{$model->techCondition->progressColor($model->percent($limit))}}"
                                                 style="width: {{$model->techCondition->percent($limit)}}%">
                                            </div>
                                        </div>
                                        <div class="text-center">{{$limit}} @lang('global.hour')</div>
                                    </td>
                                    <td>
                                        @if($show)
                                            <form
                                                action="{{route('technic.tech-condition.finish', $model->techCondition->id)}}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                <a href="{{route('technic.tech-condition.edit', $model->techCondition->id)}}"
                                                   class="btn btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <input type="file" name="pdf" id="pdf-{{$model->id}}"
                                                       onchange="this.parentNode.submit()" hidden>
                                                <label for="pdf-{{$model->id}}" class="btn btn-primary text-bold my-0"
                                                       title="@lang('global.btn_upload')">
                                                    <i class="fas fa-upload"></i>
                                                </label>
                                            </form>
                                        @endif
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
        let lang = {
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
        }
        datatable(lang, 'table');

        showNavbar();
    </script>
@endsection
