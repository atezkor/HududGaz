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
                                <label for="org_number" class="col-3">{{__('admin.organ.org_num')}}</label>
                                <div class="col-9">
                                    <input type="number" name="org_number" id="org_number" value="{{$model->org_number}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="region" class="col-3">{{__('admin.organ.select_hint')}}</label>
                                <div class="col-9">
                                    <select name="region" id="region" class="custom-select">
                                        <option value="">{{__('admin.select')}}</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{$key}}"
                                                    @if ($key == $model->region) selected @endif>
                                                {{$district}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="org_name" class="col-3">{{__('admin.org_name')}}</label>
                                <div class="col-9">
                                    <input type="text" name="org_name" id="org_name" value="{{$model->org_name}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lead_engineer" class="col-3">{{__('admin.organ.engineer')}}</label>
                                <div class="col-9">
                                    <input type="text" name="lead_engineer" id="lead_engineer" value="{{$model->lead_engineer}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="section_leader" class="col-3">{{__('admin.organ.section_leader')}}</label>
                                <div class="col-9">
                                    <input type="text" name="section_leader" id="section_leader" value="{{$model->section_leader}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-3">{{__('admin.organ.email')}}</label>
                                <div class="col-9">
                                    <input type="email" name="email" id="email" value="{{$model->email}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-3">{{__('admin.phone')}}</label>
                                <div class="col-9">
                                    <input type="tel" name="phone" id="phone" value="{{ $model->phone }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-3">{{__('admin.organ.address')}}</label>
                                <div class="col-9">
                                    <input type="text" name="address" id="address" value="{{ $model->address }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address_krill" class="col-3">{{__('admin.organ.address_krill')}}</label>
                                <div class="col-9">
                                    <input type="text" name="address_krill" id="address_krill" value="{{ $model->address_krill }}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="fax" class="col-3">{{__('admin.organ.fax')}}</label>
                                <div class="col-9">
                                    <input type="text" name="fax" id="fax" value="{{ $model->fax }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{__('global.btn_save')}}</button>
                            <a href="{{route('admin.regions.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                            <button type="reset" class="btn btn-default float-right">{{__('global.btn_reset')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
