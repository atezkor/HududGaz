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
                            {{__('admin.status.heading_edit')}}
                        </h3>
                    </div>
                    <form action="{{$action}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="description" class="col-2">{{__('admin.status.description')}}</label>
                                <div class="col-10">
                                    <input type="text" name="description" id="description" value="{{$model->description}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transitions" class="col-2">{{__('admin.status.transitions')}}</label>
                                <div class="col-10">
                                    <input type="text" name="transitions" id="transitions" value="{{$model->transitions}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="term" class="col-2">{{__('admin.status.term')}}</label>
                                <div class="col-10">
                                    <input type="number" name="term" id="term" value="{{$model->term}}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{__('global.btn_renew')}}</button>
                            <a href="{{route('admin.statuses.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                            <button type="reset" class="btn btn-default float-right">{{__('global.btn_reset')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
