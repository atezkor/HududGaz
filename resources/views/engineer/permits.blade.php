@extends('layout')
@section('title', getName())

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
                                <th>@lang('engineer.permit')</th>
                                <th>@lang('engineer.project.name')</th>
                                <th>@lang('engineer.montage.name')</th>
                                <th>@lang('engineer.district')</th>
                                <th>@lang('global.status')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($models as $key => $model)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$model->applicant}}</td>
                                <td>
                                    <a href="{{route('engineer.permit.show', ['permit' => $model])}}" target="_blank">
                                        @lang('global.btn_show')
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('designer.project.show', ['project' => $model->project])}}" target="_blank">
                                        @lang('global.btn_show')
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('mounter.montage.show', ['montage' => $model->montage])}}" target="_blank">
                                        @lang('global.btn_show')
                                    </a>
                                </td>
                                <td>{{$districts[$model->district]}}</td>
                                <td>
                                @if($model->status == 1)
                                    @can('crud_permit')
                                    <form action="{{route('engineer.permit.upload', ['permit' => $model])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="file" id="file-{{$key}}" class="d-none" onchange="this.parentNode.submit()">
                                        <label for="file-{{$key}}" class="btn btn-outline-info text-bold my-0" title="@lang('global.btn_upload')">
                                            <i class="fas fa-upload"></i>
                                        </label>
                                    </form>
                                    @else
                                    <span>@lang('global.unloaded')</span>
                                    @endcan
                                @else
                                    <span>@lang('global.uploaded')</span>
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
