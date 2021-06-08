@extends('layout')
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                @if($method == 'POST')
                                    {{__('admin.organ.heading_create')}}
                                @else
                                    {{__('admin.organ.heading_edit')}}
                                @endif
                            </h3>
                        </div>
                        <form action="{{$action}}" method="post">
                            @csrf
                            @method($method)
                            @include('components.errors')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-3">@lang('admin.timetable.name')</label>
                                    <div class="col-9">
                                        <input type="text" name="name" id="name" value="{{$model->name}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="interval" class="col-3">@lang('admin.timetable.interval')</label>
                                    <div class="col-9">
                                        <input type="date" name="interval" id="interval" value="{{$model->name}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="type" class="col-3">@lang('admin.timetable.type')</label>
                                    <div class="col-9">
                                        <select name="type" id="type" class="custom-select">
                                            <option value="1">@lang('admin.timetable.holiday_days')</option>
                                            <option value="2" @if($model->type == 2) selected @endif>@lang('admin.timetable.extra_work_days')</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">@lang('global.btn_save')</button>
                                <a href="{{route('admin.timetable.index')}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                                <button type="reset" class="btn btn-default float-right">@lang('global.btn_reset')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
