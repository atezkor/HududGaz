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
                                        <th>№</th>
                                        <th>@lang('admin.org_name')</th>
                                        <th>@lang('admin.org_director')</th>
                                        <th>@lang('admin.address')</th>
                                        <th>@lang('admin.period_activity')</th>
                                        <th style="width: 1px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $model)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{$model->short_name}}</td>
                                            <td>{{$model->director}}</td>
                                            <td>{{$model->address}}</td>
                                            <td>
                                                <span>{{formatDate($model->date_registry)}} - {{formatDate($model->date_expiry)}}</span>
                                            </td>
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
