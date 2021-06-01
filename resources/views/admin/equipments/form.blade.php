@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    @if($method == 'POST')
                        {{__('admin.equipment.heading_create')}}
                    @else
                        {{__('admin.equipment.heading_edit')}}
                    @endif
                </h3>
            </div>
            <form action="{{$action}}" method="post">
                @csrf
                @method($method)
                @include('components.errors')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{__('admin.equipment.name')}}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{$model->name}}">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">{{__('global.btn_save')}}</button>
                    <a href="{{route('admin.equipments.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                    <button type="reset" class="btn btn-default float-right">{{__('global.btn_reset')}}</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
