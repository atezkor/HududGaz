@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    @if ($method == "POST")
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a href="#individual" class="nav-link active" onclick="changeType(1)" data-toggle="tab">
                                    @lang('global.proposition.individual')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#legal_entity" class="nav-link" onclick="changeType(2)" data-toggle="tab">
                                    @lang('global.proposition.legal_entity')
                                </a>
                            </li>
                        </ul>
                    @else
                        <h3>@lang('technic.proposition.heading_edit')</h3>
                    @endif
                    </div>
                    <form action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        @include('components.errors')
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="number" class="col-2">@lang('technic.proposition.prop_num')</label>
                                <div class="col-10">
                                    <input type="number" name="number" id="number" value="{{$model->number}}" class="form-control">
                                </div>
                            </div>

                            <div class="tab-content">
                                <div id="individual" class="tap-pane active">
                                    <div class="form-group row">
                                        <label for="stir" class="col-2">@lang('technic.proposition.stir')</label>
                                        <div class="col-10">
                                            <input type="number" name="stir" id="stir" onblur="checkTin(1, this.value)"
                                                   value="{{$applicant->stir}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="passport" class="col-2">@lang('technic.proposition.passport')</label>
                                        <div class="col-10">
                                            <input type="text" name="passport" id="passport" value="{{$applicant->passport}}"
                                                   class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="full_name" class="col-2">@lang('technic.proposition.full_name')</label>
                                        <div class="col-10">
                                            <input type="text" name="full_name" id="full_name" value="{{$applicant->full_name}}"
                                                   class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div id="legal_entity" class="tap-pane">
                                    <div class="form-group row">
                                        <label for="legal_stir" class="col-2">@lang('technic.proposition.legal_stir')</label>
                                        <div class="col-10">
                                            <input type="number" name="legal_stir" id="legal_stir" onblur="checkTin(2, this.value)"
                                                   value="{{$applicant->legal_stir}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="legal_name" class="col-2">@lang('technic.proposition.legal_name')</label>
                                        <div class="col-10">
                                            <input type="text" name="legal_name" id="legal_name" value="{{$applicant->legal_name}}" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="leader" class="col-2">@lang('technic.proposition.leader')</label>
                                        <div class="col-10">
                                            <input type="text" name="leader" id="leader" value="{{$applicant->leader}}" class="form-control" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="leader_stir" class="col-2">@lang('technic.proposition.leader_stir')</label>
                                        <div class="col-10">
                                            <input type="number" name="leader_stir" id="leader_stir" onblur="checkTin(3, this.value)"
                                                   value="{{$applicant->leader_stir}}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-2">@lang('technic.proposition.email')</label>
                                        <div class="col-10">
                                            <input type="email" name="email" id="email" value="{{$applicant->email}}" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-2">@lang('technic.proposition.phone')</label>
                                <div class="col-10">
                                    <input type="tel" name="phone" id="phone" value="{{$applicant->phone}}"
                                           class="form-control" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="activity_type" class="col-2">@lang('technic.proposition.activity_type')</label>
                                <div class="col-10">
                                    <select name="activity_type" id="activity_type" class="form-control">
                                        <option value="">@lang('technic.proposition.activity_type')</option>
                                        @foreach($activities as $key => $activity)
                                            <option value="{{$key}}" @if($model->activity_type == $key) selected @endif>
                                                {{$activity}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="build_type" class="col-2">@lang('technic.proposition.build_type')</label>
                                <div class="col-10">
                                    <select name="build_type" id="build_type" class="form-control">
                                        <option value="1">@lang('technic.proposition.residential')</option>
                                        <option value="2" @if($model->build_type == 2){{'selected'}}@endif>@lang('technic.proposition.non_residential')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="organ" class="col-2">@lang('technic.proposition.organ')</label>
                                <div class="col-10">
                                    <select name="organ" id="organ" class="form-control">
                                        <option value="">@lang('technic.proposition.organ_select')</option>
                                        @foreach($organs as $key => $organ)
                                            <option value="{{$key}}" @if($model->organ == $key) selected @endif>
                                                {{$organ}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="file" class="col-2">@lang('technic.proposition.file')</label>
                                <div class="col-10">
                                    <div class="custom-file">
                                        <input type="file" name="file" id="file" class="custom-file-input"
                                               @if($method == "POST") required @endif>
                                        <label class="custom-file-label" for="file">
                                            <span id="file_hint">@lang('technic.proposition.file_hint')</span>
                                            <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="type" id="type" value="1">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">@lang('global.btn_save')</button>
                            <a href="{{route('propositions.index')}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">@lang('global.btn_reset')</button>
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
<script src="{{'/js/default.js'}}"></script>
<script>
    fileUpload('reset', 'file', 'file_hint', "@lang('technic.proposition.file_hint')")

    function changeType(type) {
        $('#type').val(type);
    }

    $(document).ready(function() {
        if ({{$model->type ?? 1}} === 2) {
            $('#legal_entity').tab('show');
            $('#individual').removeClass('active');
            $('#type').val(2);
        }
    });

    function checkTin(type, stir) {
        $.get(`{{route('technic.check_stir')}}/${type}/${stir}`, function(data) {
            if (data.length === 0)
                return;

            toast(`<a href="{{route('technic.propositions')}}/${type}/${stir}" target="_blank" class="text-danger">Bunday stirli ariza mavjud (${Object.keys(data).length})</a>`,
                'warning', 5000)
        });
    }

    showNavbar();
</script>
@endsection
