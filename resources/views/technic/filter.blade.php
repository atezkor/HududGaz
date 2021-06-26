@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/datatable/datatables.bootstrap4.min.css'}}">
    <link rel="stylesheet" href="{{'/css/datatable/responsive.bootstrap4.min.css'}}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <table id="table" class="table table-bordered table-striped table-center">
                                <thead>
                                    <tr>
                                        <th>@lang('global.index')</th>
                                        <th>@lang('global.proposition.number')</th>
                                    @if($type == 1)
                                        <th>@lang('global.proposition.stir')</th>
                                    @elseif($type == 2)
                                        <th>@lang('global.proposition.legal_stir')</th>
                                    @else
                                        <th>@lang('technic.proposition.leader_stir')</th>
                                    @endif
                                        <th>@lang('technic.organ')</th>
                                        <th>@lang('global.proposition.name')</th>
                                        <th>@lang('global.proposition.date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$model->number}}</td>
                                        <td>{{$stir}}</td>
                                        <td>{{$organs[$model->organ]}}</td>
                                        <td>
                                            <a href="{{route('propositions.show', ['proposition' => $model])}}" target="_blank">
                                                @lang('global.proposition.show')
                                            </a>
                                        </td>
                                        <td>{{$model->created_at}}</td>
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
@section('javascript')
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
