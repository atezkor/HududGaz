<div class="card-body">
    <div class="row">
        <div class="form-group col-6 pr-4">
            <label for="name">{{__('admin.org_name')}}</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{old('name', $model->name)}}" autocomplete="off">
        </div>

        <div class="form-group col-6 pl-4">
            <label for="director">{{__('admin.org_director')}}</label>
            <input type="text" name="director" id="director" class="form-control"
                   value="{{old('director', $model->director)}}" autocomplete="off">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-6 pr-4">
            <label for="address">@lang('admin.designer.address')</label>
            <input type="text" name="address" id="address" class="form-control"
                   value="{{old('address', $model->address)}}"
                   autocomplete="off">
        </div>

        <div class="form-group col-6 pl-4">
            <label for="address_cyrill">@lang('admin.designer.address_cyrillic')</label>
            <input type="text" name="address_cyrill" id="address_cyrill" class="form-control"
                   value="{{old('address_cyrill', $model->address_cyrill)}}" autocomplete="off">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-6 pr-4">
            <label for="registry_date">{{__('admin.date_registry')}}</label>
            <input type="date" name="registry_date" id="registry_date" class="form-control date"
                   value="{{old('registry_date', $model->registry_date)}}">
        </div>
        <div class="form-group col-6 pl-4">
            <label for="expiry_date">{{__('admin.date_expiry')}}</label>
            <input type="date" name="expiry_date" id="expiry_date" class="form-control date"
                   value="{{old('expiry_date', $model->expiry_date)}}">
        </div>
    </div>

    <div class="form-group">
        <label for="phone">{{__('admin.designer.phone_number')}}</label>
        <input name="phone" id="phone" class="form-control"
               value="{{old('phone', $model->phone)}}" autocomplete="off">
    </div>

    <div class="form-group">
        <label for="license">@lang('admin.license')</label>
        <div class="custom-file">
            <input type="file" name="license" id="license" class="custom-file-input"
                   @if($model->id) required @endif>
            <label class="custom-file-label" for="file">
                <span id="file_hint">@lang('admin.doc_upload')</span>
                <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
            </label>
        </div>
    </div>
</div>
@section('js')
    <script src="{{'/js/default.js'}}"></script>
    <script>
        fileUpload('reset', 'license', 'file_hint', "{{__('admin.doc_upload')}}");
    </script>
@endsection
