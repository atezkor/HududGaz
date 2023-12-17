<form action="{{$action}}" method="post" enctype="multipart/form-data">
    @csrf
    @include('components.errors')
    @if($model->id)
        @method('PUT')
    @endif

    <div class="card-body">
        <div class="row">
            <div class="form-group col-6 pr-5">
                <label for="full_name">{{__('admin.mounter.full_name')}}</label>
                <input type="text" name="full_name" id="full_name" class="form-control"
                       value="{{old('full_name', $model->full_name)}}">
            </div>
            <div class="form-group col-6 pl-5">
                <label for="short_name">{{__('admin.mounter.short_name')}}</label>
                <input type="text" name="short_name" id="short_name" class="form-control"
                       value="{{old('short_name', $model->short_name)}}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-5">
                <label for="director">{{__('admin.mounter.director')}}</label>
                <input type="text" name="director" id="director" class="form-control"
                       value="{{old('director', $model->director)}}">
            </div>

            <div class="form-group col-6 pl-5">
                <label for="tin">{{__('admin.mounter.tin')}}</label>
                <input type="number" name="tin" id="tin"
                       value="{{old('tin', $model->tin)}}" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-5">
                <label for="rec_num">{{__('admin.mounter.rec_num')}}</label>
                <input type="number" name="rec_num" id="rec_num" value="{{$model->rec_num}}"
                       class="form-control">
            </div>
            <div class="form-group col-6 pl-5">
                <label for="reg_num">{{__('admin.mounter.reg_num')}}</label>
                <input type="number" name="reg_num" id="reg_num" value="{{$model->reg_num}}"
                       class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-5">
                <label for="district_id">{{__('admin.mounter.district')}}</label>
                <select name="district_id" id="district_id" class="custom-select" required>
                    <option value="">{{__('admin.select')}}</option>
                    @foreach($districts as $district)
                        <option value="{{$district->id}}"
                                @if ($model->district_id == $district->id  || old('district_id') == $district->id) selected @endif>
                            <span>{{$district->name}}</span>
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6 pl-5">
                <label for="address">{{__('admin.mounter.address')}}</label>
                <input type="text" name="address" id="address" class="form-control"
                       value="{{$model->address}}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-5">
                <label for="date_registry">{{__('admin.date_registry')}}</label>
                <input type="date" name="date_registry" id="date_registry"
                       value="{{$model->date_registry}}" class="form-control date">
            </div>
            <div class="form-group col-6 pl-5">
                <label for="date_expiry">{{__('admin.date_expiry')}}</label>
                <input type="date" name="date_expiry" id="date_expiry"
                       value="{{$model->date_expiry}}" class="form-control date">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-5">
                <label for="permissions">{{__('admin.mounter.permissions')}}</label>
                <textarea name="permissions" id="permissions" class="form-control"
                          style="resize: none" rows="4">{{$model->permissions}}</textarea>
            </div>

            <div class="form-group col-6 pl-5">
                <label for="implementations">{{__('admin.mounter.implementations')}}</label>
                <textarea name="implementations" id="implementations" class="form-control"
                          style="resize: none" rows="4">{{$model->implementations}}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="given_by">{{__('admin.mounter.given_by')}}</label>
            <input type="text" name="given_by" id="given_by" value="{{$model->given_by}}"
                   class="form-control">
        </div>

        <div class="form-group">
            <label for="license">{{__('admin.license')}}</label>
            <div class="custom-file">
                <input type="file" name="license" id="license" class="custom-file-input"
                       @if(!$model->id) required @endif>
                <label class="custom-file-label" for="license">
                    <span id="file_hint">{{__('admin.doc_upload')}}</span>
                    <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                </label>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{__('global.btn_save')}}</button>
        <div class="float-right">
            <a href="{{route('admin.mounters.index')}}"
               class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
            <button type="reset" id="reset"
                    class="btn btn-default">{{__('global.btn_reset')}}</button>
        </div>
    </div>
</form>
@section('js')
    <script src="{{'/js/default.js'}}"></script>
    <script>
        fileUpload('reset', 'file', 'file_hint', "{{__('admin.doc_upload')}}");
    </script>
@endsection
