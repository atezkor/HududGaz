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
                            <div class="row">
                                <div class="form-group col-6 pr-4">
                                    <label for="org_name">{{__('admin.org_name')}}</label>
                                    <input type="text" name="org_name" id="org_name" value="{{$model->org_name}}" class="form-control">
                                </div>

                                <div class="form-group col-6 pl-4">
                                    <label for="district">{{__('admin.organ.select_hint')}}</label>
                                    <select name="district" id="district" class="custom-select">
                                        <option value="">{{__('admin.select')}}</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{$key}}"
                                                    @if ($key == $model->district) selected @endif>
                                                {{$district}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6 pr-4">
                                    <label for="lead_engineer">{{__('admin.organ.engineer')}}</label>
                                    <input type="text" name="lead_engineer" id="lead_engineer" value="{{$model->lead_engineer}}" class="form-control">
                                </div>
                                <div class="form-group col-6 pl-4">
                                    <label for="section_leader">{{__('admin.organ.section_leader')}}</label>
                                    <input type="text" name="section_leader" id="section_leader" value="{{$model->section_leader}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6 pr-4">
                                    <label for="org_number">{{__('admin.organ.org_num')}}</label>
                                    <input type="number" name="org_number" id="org_number" value="{{$model->org_number}}" class="form-control">
                                </div>

                                <div class="form-group col-6 pl-4">
                                    <label for="email">{{__('admin.organ.email')}}</label>
                                    <input type="email" name="email" id="email" value="{{$model->email}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6 pr-4">
                                    <label for="address">{{__('admin.organ.address')}}</label>
                                    <input type="text" name="address" id="address" value="{{ $model->address }}" class="form-control">
                                </div>

                                <div class="form-group col-6 pl-4">
                                    <label for="address_krill">{{__('admin.organ.address_krill')}}</label>
                                    <input type="text" name="address_krill" id="address_krill" value="{{ $model->address_krill }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">{{__('admin.phone')}}</label>
                                <textarea name="phone" id="phone" class="form-control">{{ $model->phone }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="fax">{{__('admin.organ.fax')}}</label>
                                <input type="text" name="fax" id="fax" value="{{ $model->fax }}" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{__('global.btn_save')}}</button>
                            <div class="float-right">
                                <a href="{{route('admin.organs.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                                <button type="reset" class="btn btn-default">{{__('global.btn_reset')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
