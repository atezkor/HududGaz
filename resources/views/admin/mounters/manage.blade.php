@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @if($method == 'POST')
                                {{__('admin.mounter.add_worker')}}
                            @else
                                {{__('admin.mounter.edit_worker')}}
                            @endif
                        </h3>
                    </div>
                    <form action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        @include('components.errors')
                        <div class="card-body">
                            <input type="hidden" name="firm_id" value="{{$firm_id ?? $model->firm_id}}">
                            <div class="form-group row">
                                <label for="statement_number" class="col-2">{{__('admin.mounter.stat_number')}}</label>
                                <div class="col-10">
                                    <input type="number" name="statement_number" id="statement_number" value="{{$model->statement_number}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="first_name" class="col-2">{{__('admin.mounter.first_name')}}</label>
                                <div class="col-10">
                                    <input type="text" name="first_name" id="first_name" value="{{$model->first_name}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="second_name" class="col-2">{{__('admin.mounter.second_name')}}</label>
                                <div class="col-10">
                                    <input type="text" name="second_name" id="second_name" value="{{$model->second_name}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-2">{{__('admin.mounter.last_name')}}</label>
                                <div class="col-10">
                                    <input type="text" name="last_name" id="last_name" value="{{$model->last_name}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diploma_number" class="col-2">{{__('admin.mounter.diploma_number')}}</label>
                                <div class="col-10">
                                    <input type="number" name="diploma_number" id="diploma_number" value="{{$model->diploma_number}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="passport_series" class="col-2">{{__('admin.mounter.passport_series')}}</label>
                                <div class="col-10">
                                    <input type="text" name="passport_series" id="passport_series" value="{{$model->passport_series}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="specialization" class="col-2">{{__('admin.mounter.specialized')}}</label>
                                <div class="col-10">
                                    <input type="text" name="specialization" id="specialization" value="{{$model->specialization}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="experience" class="col-2">{{__('admin.mounter.experience')}}</label>
                                <div class="col-10">
                                    <input type="text" name="experience" id="experience" value="{{$model->experience}}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="date_contract">{{__('admin.mounter.date_contract')}}</label>
                                    <input type="date" name="date_contract" id="date_contract" value="{{$model->date_contract}}" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="date_contract_end">{{__('admin.mounter.date_contract_end')}}</label>
                                    <input type="date" name="date_contract_end" id="date_contract_end" value="{{$model->date_contract_end}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="file">{{__('admin.mounter.document')}}</label>
                                <div class="custom-file">
                                    <input type="file" name="document" id="file" class="custom-file-input"
                                           @if($method == "POST") required @endif>
                                    <label class="custom-file-label" for="file">
                                        <span id="file_hint">{{__('admin.doc_upload')}}</span>
                                        <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">{{__('global.btn_save')}}</button>
                            <a href="{{route('admin.fitters.index', ['firm' => $firm_id ?? $model->firm_id])}}"
                               class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">{{__('global.btn_reset')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
<script>
    $('#file').change(function(input) {
        try {
            $('#file_hint').text(input.target.files[0].name);
        } catch (e) {}
    })

    $('#reset').on('click', function() {
        $('#file_hint').text('{{__('admin.doc_upload')}}');
    });
</script>
@endsection
