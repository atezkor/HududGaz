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
                                    {{__('table.districts.heading_create')}}
                                @else
                                    {{__('table.districts.heading_edit')}}
                                @endif
                            </h3>
                        </div>
                        <form action="{{$action}}" method="post">
                            @csrf
                            @method($method)
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="org_number" class="col-3">{{__('table.districts.org_num')}}</label>
                                    <div class="col-9">
                                        <input type="number" name="org_number" id="org_number" value="{{$model->org_number}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="region" class="col-3">{{__('table.districts.region_select')}}</label>
                                    <div class="col-9">
                                        <select name="region" id="region" class="custom-select" required>
                                            <option>{{__('table.general.select')}}</option>
                                            @foreach($regions as $key => $region)
                                                <option value="{{$key}}"
                                                        @if ($key == $model->region) selected @endif
                                                >
                                                    {{$region}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="org_name" class="col-3">{{__('table.districts.org_name')}}</label>
                                    <div class="col-9">
                                        <input type="text" name="org_name" id="org_name" value="{{$model->org_name}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lead_engineer" class="col-3">{{__('table.districts.engineer')}}</label>
                                    <div class="col-9">
                                        <input type="text" name="lead_engineer" id="lead_engineer" value="{{$model->lead_engineer}}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="section_leader" class="col-3">{{__('table.districts.section_leader')}}</label>
                                    <div class="col-9">
                                        <input type="text" name="section_leader" value="{{$model->section_leader}}" class="form-control" id="section_leader">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-3">{{__('table.districts.email')}}</label>
                                    <div class="col-9">
                                        <input type="email" name="email" value="{{$model->email}}" class="form-control" id="email" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-3">{{__('table.districts.phone')}}</label>
                                    <div class="col-9">
                                        <input type="tel" name="phone" value="{{ $model->phone }}" class="form-control" id="phone">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address_latin" class="col-3">{{__('table.districts.address_latin')}}</label>
                                    <div class="col-9">
                                        <input type="text" name="address_latin" value="{{ $model->address_latin }}" class="form-control" id="address_latin">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-3">{{__('table.districts.address')}}</label>
                                    <div class="col-9">
                                        <input type="text" name="address" value="{{ $model->address }}" class="form-control" id="address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fax" class="col-3">{{__('table.districts.fax')}}</label>
                                    <div class="col-9">
                                        <input type="text" name="fax" value="{{ $model->fax }}" class="form-control" id="fax">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">{{__('table.btn_save')}}</button>
                                <a href="{{route('admin.regions.index')}}" class="btn btn-outline-secondary">{{__('table.btn_back')}}</a>
                                <button type="reset" class="btn btn-default float-right">{{__('table.btn_reset')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
