@extends('layout')
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools mt-2">
                                <div class="input-group w-75 ml-auto">
                                    <input type="search" id="search" oninput="search(this)" class="form-control"
                                           placeholder="@lang('global.search')">
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>@lang('global.index')</th>
                                        <th>@lang('admin.organ.col_name')</th>
                                        <th>@lang('admin.organ.col_num')</th>
                                        <th>@lang('admin.organ.col_engineer')</th>
                                        <th>@lang('admin.email')</th>
                                        <th>@lang('admin.organ.col_phone')</th>
                                        <th>@lang('admin.organ.col_address')</th>
                                        <th style="width: 1px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $model)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$model->name}}</td>
                                            <td>{{$model->tin}}</td>
                                            <td>{{$model->lead_engineer}}</td>
                                            <td>{{$model->email}}</td>
                                            <td>{{$model->phone}}</td>
                                            <td>{{$model->address}}</td>
                                            <td>
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
    </section>
@endsection
