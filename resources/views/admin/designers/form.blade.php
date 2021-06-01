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
                                {{__('admin.designer.heading_create')}}
                            @else
                                {{__('admin.designer.heading_edit')}}
                            @endif
                        </h3>
                    </div>
                    <form action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method($method)
                        @include('components.errors')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="org_name">{{__('admin.org_name')}}</label>
                                <input type="text" name="org_name" id="org_name" value="{{$model->org_name}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="leader">{{__('admin.org_leader')}}</label>
                                <input type="text" name="leader" id="leader" value="{{$model->leader}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="address">{{__('admin.designer.address')}}</label>
                                <input type="text" name="address" id="address" value="{{$model->address}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="address_krill">{{__('admin.designer.address_krill')}}</label>
                                <input type="text" name="address_krill" id="address_krill" value="{{$model->address_krill}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="phone">{{__('admin.designer.phone_number')}}</label>
                                <textarea name="phone" id="phone" class="form-control">{{$model->phone}}</textarea>
                            </div>

                            <div class="form-group data-form">
                                <div>
                                    <label for="date_reg">{{__('admin.date_created')}}</label>
                                    <input type="date" name="date_reg" id="date_reg" value="{{$model->date_reg}}" class="form-control">
                                </div>
                                <div>
                                    <label for="date_end">{{__('admin.date_expired')}}</label>
                                    <input type="date" name="date_end" id="date_end" value="{{$model->date_end}}" class="form-control">
                                </div>
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
                            <a href="{{route('admin.designers.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
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
    });

    $('#reset').on('click', function() {
        $('#file_hint').text('{{__('admin.doc_upload')}}');
    });
</script>
@endsection
