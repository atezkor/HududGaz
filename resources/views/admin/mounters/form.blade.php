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
                                {{__('admin.mounter.heading_create')}}
                            @else
                                {{__('admin.mounter.heading_edit')}}
                            @endif
                        </h3>
                    </div>
                    <form action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        @include('components.errors')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="leader">{{__('admin.mounter.leader')}}</label>
                                <input type="text" name="leader" id="leader" value="{{$model->leader}}" class="form-control">
                            </div>

                            <div class="data-form">
                                <div class="form-group">
                                    <label for="rec_num">{{__('admin.mounter.rec_num')}}</label>
                                    <input type="number" name="rec_num" id="rec_num" value="{{$model->rec_num}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="reg_num">{{__('admin.mounter.reg_num')}}</label>
                                    <input type="number" name="reg_num" id="reg_num" value="{{$model->reg_num}}" class="form-control">
                                </div>
                            </div>

                            <div class="data-form">
                                <div class="form-group">
                                    <label for="full_name">{{__('admin.mounter.full_name')}}</label>
                                    <input type="text" name="full_name" id="full_name" value="{{$model->full_name}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="short_name">{{__('admin.mounter.short_name')}}</label>
                                    <input type="text" name="short_name" id="short_name" value="{{$model->short_name}}" class="form-control">
                                </div>
                            </div>

                            <div class="data-form">
                                <div class="form-group">
                                    <label for="district">{{__('admin.mounter.district')}}</label>
                                    <select name="district" id="district" class="custom-select" required>
                                        <option value="">{{__('admin.select')}}</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{$key}}"
                                                    @if ($key == $model->district) selected @endif
                                            >
                                                {{$district}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="address">{{__('admin.mounter.address')}}</label>
                                    <input type="text" name="address" id="address" value="{{$model->address}}" class="form-control">
                                </div>
                            </div>

                            <div class="data-form">
                                <div class="form-group">
                                    <label for="legal_form">{{__('admin.mounter.legal_form')}}</label>
                                    <input type="text" name="legal_form" id="legal_form" value="{{$model->legal_form}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="given_by">{{__('admin.mounter.given_by')}}</label>
                                    <input type="text" name="given_by" id="given_by" value="{{$model->given_by}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group data-form">
                                <div>
                                    <label for="date_created">{{__('admin.date_created')}}</label>
                                    <input type="date" name="date_created" id="date_created" value="{{$model->date_created}}" class="form-control">
                                </div>
                                <div>
                                    <label for="date_expired">{{__('admin.date_expired')}}</label>
                                    <input type="date" name="date_expired" id="date_expired" value="{{$model->date_expired}}" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="taxpayer_stir">{{__('admin.mounter.taxpayer_stir')}}</label>
                                <input type="number" name="taxpayer_stir" id="taxpayer_stir" value="{{$model->taxpayer_stir}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="permission_to">{{__('admin.mounter.permissions_to')}}</label>
                                <textarea name="permission_to" id="permission_to" class="form-control">{{$model->permission_to}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="implement_for">{{__('admin.mounter.implements_for')}}</label>
                                <textarea name="implement_for" id="implement_for" class="form-control">{{$model->implement_for}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="file">{{__('admin.document')}}</label>
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
                            <a href="{{route('admin.mounters.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
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
