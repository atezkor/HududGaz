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
                                <th>@lang('global.proposition.number')</th>
                                <th>@lang('global.consumer')</th>
                                <th>@lang('district.recommendation.name')</th>
                                <th>@lang('global.proposition.date')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php($limit = limit(6, 5)[6])
                        @php($l = 0)
                        @php($p = 0)
                        @foreach($propositions as $key => $model)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$model->number}}</td>
                                <td>{{$applicant($physicals, $legals, $p, $l, $model->type)}}</td>
                                <td>
                                    <a href="{{route('district.recommendation.show', ['recommendation' => $models[$key]])}}" target="_blank">
                                        @lang('district.show')
                                    </a>
                                </td>
                                <td>{{$models[$key]->created_at}}</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="{{progressColor($model->percent($limit))}}"
                                             style="width: {{$model->percent($limit)}}%">
                                        </div>
                                    </div>
                                    <div class="text-center">{{$limit}} @lang('global.hour')</div>
                                </td>
                                <td>
                                    <a href="{{route('district.recommendation.edit', ['recommendation' => $models[$key]])}}"
                                       class="btn btn-outline-info">
                                        <i class="fas fa-tools"></i>
                                        <span>@lang('district.btn_correction')</span>
                                    </a>
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
                sZeroRecords: "@lang('global.datatables.zeroRecords')",
                sInfoFiltered: "@lang('global.datatables.infoFiltered')"
            }

            $("#table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                searching: true,
                language: lang
            });
        });
    </script>
@endsection
