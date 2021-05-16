@extends('layout')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/default.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a href="#individual" class="nav-link active" onclick="changeType(1)" data-toggle="tab">
                                            {{__('technic.propositions.individual')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#legal_entity" class="nav-link" onclick="changeType(2)" data-toggle="tab">
                                            {{__('technic.propositions.legal')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <form action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('components.errors')
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="number" class="col-2">{{__('technic.prop_num')}}</label>
                                <div class="col-10">
                                    <input type="number" name="number" id="number" value="{{$model->number}}" class="form-control">
                                </div>
                            </div>

                            <div class="tab-content">
                                <div id="individual" class="tap-pane active">
                                    <div class="form-group row">
                                        <label for="stir" class="col-2">{{__('technic.propositions.stir')}}</label>
                                        <div class="col-10">
                                            <input type="number" name="stir" id="stir" value="{{$model->stir}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="passport" class="col-2">{{__('technic.propositions.passport')}}</label>
                                        <div class="col-10">
                                            <input type="text" name="passport" id="passport" value="{{$model->passport}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="full_name" class="col-2">{{__('technic.propositions.full_name')}}</label>
                                        <div class="col-10">
                                            <input type="text" name="full_name" id="full_name" value="{{$model->full_name}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div id="legal_entity" class="tap-pane">
                                    <div class="form-group row">
                                        <label for="legal_stir" class="col-2">{{__('technic.propositions.legal_stir')}}</label>
                                        <div class="col-10">
                                            <input type="number" name="legal_stir" id="legal_stir" value="{{$model->legal_stir}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="legal_name" class="col-2">{{__('technic.propositions.legal_name')}}</label>
                                        <div class="col-10">
                                            <input type="text" name="legal_name" id="legal_name" value="{{$model->legal_name}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="leader" class="col-2">{{__('technic.propositions.leader')}}</label>
                                        <div class="col-10">
                                            <input type="text" name="leader" id="leader" value="{{$model->leader}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="leader_stir" class="col-2">{{__('technic.propositions.leader_stir')}}</label>
                                        <div class="col-10">
                                            <input type="number" name="leader_stir" id="leader_stir" value="{{$model->leader_stir}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-2">{{__('technic.propositions.email')}}</label>
                                        <div class="col-10">
                                            <input type="email" name="email" id="email" value="{{$model->email}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-2">{{__('technic.propositions.phone')}}</label>
                                <div class="col-10">
                                    <input type="tel" name="phone" id="phone" value="{{$model->phone}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="activity_type" class="col-2">{{__('technic.propositions.activity_type')}}</label>
                                <div class="col-10">
                                    <select name="activity_type" id="activity_type" class="form-control">
                                        <option value="">@lang('technic.propositions.activity_type')</option>
                                        @foreach($activities as $key => $activity)
                                        <option value="{{$key + 1}}" @if($model->activity_type == $key + 1) selected @endif>
                                            {{$activity->activity}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="build_type" class="col-2">{{__('technic.propositions.build_type')}}</label>
                                <div class="col-10">
                                    <select name="build_type" id="build_type" class="form-control">
                                        <option value="1">@lang('technic.propositions.residential')</option>
                                        <option value="2">@lang('technic.propositions.non_residential')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="district" class="col-2">{{__('technic.propositions.district')}}</label>
                                <div class="col-10">
                                    <select name="district" id="district" class="form-control">
                                        <option value="">@lang('technic.propositions.district_select')</option>
                                        @foreach($districts as $key => $district)
                                        <option value="{{$key}}" @if($model->district == $key) selected @endif>
                                            {{$district}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="document" class="col-2">@lang('technic.propositions.file')</label>
                                <div class="col-10">
                                    <div class="custom-file">
                                        <input type="file" name="file" id="document" class="custom-file-input"
                                               @if($method == "POST") required @endif>
                                        <label class="custom-file-label" for="document">
                                            <span id="document_label">@lang('technic.propositions.file_hint')</span>
                                            <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" id="type" value="1">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">@lang('technic.btn_save')</button>
                            <a href="{{route('propositions.index')}}" class="btn btn-outline-secondary">@lang('technic.btn_back')</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">@lang('table.btn_reset')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script>
    $('#document').change(function(input) {
        try {
            $('#document_label').text(input.target.files[0].name)
        } catch (e) {}
    })

    $('#reset').on('click', function () {
        $('#document_label').text('{{__('technic.propositions.file_hint')}}');
    });

    function changeType(type) {
        $('#type').val(type);
    }
</script>
@endsection
