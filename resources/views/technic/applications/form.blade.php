@php
    use App\Models\Proposition
    /* @var Proposition $model */;
@endphp

<form action="{{$action}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('components.errors')
    <div class="card-body">
        <div class="form-group row">
            <label for="number" class="col-2">@lang('technic.proposition.prop_num')</label>
            <div class="col-10">
                <input type="number" name="number" id="number" value="{{$model->number}}"
                       class="form-control">
            </div>
        </div>

        <div class="tab-content">
            <div id="individual" class="tap-pane active">
                <div class="form-group row">
                    <label for="tin" class="col-2">@lang('technic.proposition.tin')</label>
                    <div class="col-10">
                        <input type="number" name="tin" id="tin"
                               onblur="checkTin({{ $model::PHYSICAL }}, this.value)"
                               value="{{$applicant->tin}}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="passport"
                           class="col-2">@lang('technic.proposition.passport')</label>
                    <div class="col-10">
                        <input type="text" name="passport" id="passport"
                               value="{{$applicant->passport}}"
                               class="form-control" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="full_name"
                           class="col-2">@lang('technic.proposition.full_name')</label>
                    <div class="col-10">
                        <input type="text" name="full_name" id="full_name"
                               value="{{$applicant->full_name}}"
                               class="form-control" autocomplete="off">
                    </div>
                </div>
            </div>

            <div id="legal" class="tap-pane">
                <div class="form-group row">
                    <label for="tin"
                           class="col-2">@lang('technic.proposition.legal_tin')</label>
                    <div class="col-10">
                        <input type="number" name="tin" id="tin"
                               onblur="checkTin({{ $model::LEGAL}}, this.value)"
                               value="{{$applicant->tin}}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="legal_name"
                           class="col-2">@lang('technic.proposition.legal_name')</label>
                    <div class="col-10">
                        <input type="text" name="legal_name" id="legal_name"
                               value="{{$applicant->legal_name}}" class="form-control"
                               autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="director"
                           class="col-2">@lang('technic.proposition.director')</label>
                    <div class="col-10">
                        <input type="text" name="director" id="director"
                               value="{{$applicant->director}}" class="form-control"
                               autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="director_pin_fl"
                           class="col-2">@lang('technic.proposition.director_pin_fl')</label>
                    <div class="col-10">
                        <input type="number" name="director_pin_fl" id="director_pin_fl"
                               onblur="checkTin(0, this.value)"
                               value="{{$applicant->director_pin_fl}}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-2">@lang('technic.proposition.email')</label>
                    <div class="col-10">
                        <input type="email" name="email" id="email"
                               value="{{$applicant->email}}" class="form-control"
                               autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="activity_type"
                           class="col-2">@lang('technic.proposition.activity_type')</label>
                    <div class="col-10">
                        <select name="activity_type" id="activity_type" class="form-control">
                            <option value="">@lang('technic.proposition.activity_type')</option>
                            @foreach($activities as $key => $activity)
                                <option value="{{$key}}"
                                        @if($model->activity_type == $key) selected @endif>
                                    {{$activity}}
                                </option>
                            @endforeach
                        </select>
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
            <label for="build_type"
                   class="col-2">@lang('technic.proposition.build_type')</label>
            <div class="col-10">
                <select name="build_type" id="build_type" class="form-control">
                    <option value="1">
                        @lang('global.proposition.residential')
                    </option>
                    <option value="2"@if($model->build_type == 2){{'selected'}}@endif>
                        @lang('global.proposition.non_residential')
                    </option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="organization_id" class="col-2">@lang('technic.proposition.organ')</label>
            <div class="col-10">
                <select name="organization_id" id="organization_id" class="form-control">
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
                           @if($model->id) required @endif>
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
        <button type="submit" class="btn btn-primary">@lang('global.btn_save')</button>
        <div class="float-right">
            <a href="{{route('propositions.index')}}"
               class="btn btn-outline-secondary">@lang('global.btn_back')</a>
            <button type="reset" id="reset"
                    class="btn btn-default">@lang('global.btn_reset')</button>
        </div>
    </div>
</form>
