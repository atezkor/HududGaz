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
                                <th>@lang('district.recommendation.reason')</th>
                                <th>@lang('global.proposition.date')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
