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
                                <th>@lang('global.proposition.name')</th>
                                <th>@lang('district.tech_condition')</th>
                                <th>@lang('district.recommendation.reason')</th>
                                <th>@lang('global.proposition.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($models as $model)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$model->prop_num}}</td>
                                <td>{{$model->applicant}}</td>
                                <td><a href="{{$provider($model->proposition)}}" target="_blank">@lang('district.btn_open')</a></td>
                                <td><a href="{{$provider($model->recommendation)}}" target="_blank">@lang('district.btn_open')</a></td>
                                <td><a href="{{$provider($model->condition)}}" target="_blank">@lang('district.btn_open')</a></td>
                                <td>{{$model->reason}}</td>
                                <td>{{$model->created_at}}</td>
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
