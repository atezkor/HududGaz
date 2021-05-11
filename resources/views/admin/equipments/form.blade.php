@extends('layout')
@section('title', 'Y')
@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if($method)
                                {{__('table.equipments.heading_create')}}
                            @else
                                {{__('table.equipments.heading_edit')}}
                            @endif
                        </h3>
                    </div>
                    <form action="{{$action}}" method="post">
                        @csrf
                        @method($method)
{{--                        @includeFirst(['voyager::components.errors'],['errors' => $errors])--}}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{__('table.equipments.name')}}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$model->name}}">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{__('table.btn_save')}}</button>
                            <a href="{{route('admin.equipments.index')}}" class="btn btn-outline-secondary">{{__('table.btn_back')}}</a>
                            <button type="reset" class="btn btn-default float-right">{{__('table.btn_reset')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
