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
                <input type="text" name="number" id="number" class="form-control"
                       value="{{ old('number', $model->number) }}" autocomplete="off">
            </div>
        </div>

        <div class="tab-content">
            <div id="individual" class="tap-pane active">
                <div class="form-group row">
                    <label for="pin_fl" class="col-2">@lang('technic.applicant.pin_fl')</label>
                    <div class="col-10">
                        <input type="number" name="pin_fl" id="pin_fl" class="form-control"
                               onblur="checkByPinFl({{ $model::PHYSICAL }}, this.value)"
                               value="{{old('pin_fl', $applicant->pin_fl)}}" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="passport"
                           class="col-2">@lang('technic.applicant.passport')</label>
                    <div class="col-10">
                        <input type="text" name="passport" id="passport" class="form-control"
                               value="{{ old('passport', $applicant->passport) }}" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name"
                           class="col-2">@lang('technic.applicant.name')</label>
                    <div class="col-10">
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{$applicant->name}}" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="surname"
                           class="col-2">@lang('technic.applicant.surname')</label>
                    <div class="col-10">
                        <input type="text" name="surname" id="surname" class="form-control"
                               value="{{$applicant->surname}}" autocomplete="off">
                    </div>
                </div>
            </div>

            <div id="legal" class="tap-pane">
                <div class="form-group row">
                    <label for="tin"
                           class="col-2">@lang('technic.applicant.legal_tin')</label>
                    <div class="col-10">
                        <input type="number" name="tin" id="tin"
                               onblur="checkTin({{ $model::LEGAL}}, this.value)"
                               value="{{$applicant->tin}}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="legal_name"
                           class="col-2">@lang('technic.applicant.legal_name')</label>
                    <div class="col-10">
                        <input type="text" name="name" id="legal_name"
                               value="{{$applicant->name}}" class="form-control"
                               autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="director"
                           class="col-2">@lang('technic.applicant.director')</label>
                    <div class="col-10">
                        <input type="text" name="director" id="director"
                               value="{{$applicant->director}}" class="form-control"
                               autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="director_pin_fl"
                           class="col-2">@lang('technic.applicant.director_pin_fl')</label>
                    <div class="col-10">
                        <input type="number" name="director_pin_fl" id="director_pin_fl"
                               onblur="checkTin(0, this.value)"
                               value="{{$applicant->director_pin_fl}}" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-2">@lang('technic.applicant.email')</label>
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
            <label for="phone" class="col-2">@lang('technic.applicant.phone')</label>
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
            <label for="pdf" class="col-2">@lang('technic.proposition.pdf')</label>
            <div class="col-10">
                <div class="custom-file">
                    <input type="file" name="pdf" id="pdf" class="custom-file-input"
                           @if($model->id) required @endif>
                    <label class="custom-file-label" for="pdf">
                        <span id="file_hint">@lang('technic.proposition.file_hint')</span>
                        <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                    </label>
                </div>
            </div>
        </div>
        <input type="hidden" name="type" id="type" value="{{ $model::PHYSICAL }}">
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
@push('js')
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script src="{{'/js/default.js'}}"></script>
    <script>
        function fileUpload(reset, file, file_hint, text) {
            $(`#${file}`).change(function(input) {
                try {
                    $(`#${file_hint}`).text(input.target.files[0].name);
                } catch (e) {}
            })

            $(`#${reset}`).on('click', function() {
                $(`#${file_hint}`).text(text);
            });
        }

        fileUpload('reset', 'file', 'file_hint', "@lang('technic.proposition.file_hint')")

        function changeType(type) {
            $('#type').val(type);
        }

        $(document).ready(function() {
            if ({{$model->type ?? $model::PHYSICAL}} === {{$model::LEGAL}}) {
                $('#legal').tab('show');
                $('#individual').removeClass('active');
                $('#type').val({{$model::LEGAL}});
            }
        });

        showNavbar();
    </script>

    <script>
        function checkTin(type, tin) {
            $.get(`{{route('propositions.check-for-tin')}}/${type}/${tin}`, function(model) {
                $("#passport").val(model.passport)
                $("#phone").val(model.phone)
                $("#legal_name").val(model.name)
                $("#director").val(model.director)
                $("#director_pin_fl").val(model.director_pin_fl)
                $("#email").val(model.email)

                alertDialog(model, tin)
            });
        }

        function checkByPinFl(type, pinFl) {
            $.get(`{{route('propositions.check-for-pin')}}/${type}/${pinFl}`, function(model) {
                $("#passport").val(model.passport)
                $("#phone").val(model.phone)
                $("#name").val(model.name)
                $("#surname").val(model.surname)

                alertDialog(model, pinFl)
            });
        }

        function alertDialog(model, tinPin) {
            if (model.propositions?.length) {
                let text = `@lang('technic.applicant.has_application')(${model.propositions.length})`;
                let dText = `<a href="{{route('technic.propositions')}}/${type}/${tinPin}" target="_blank" class="text-danger">${text}</a>`
                toast(dText, 'warning', 2000)
            }
        }
    </script>
@endpush
