<form action="{{$action}}" method="post">
    @csrf
    @method($method)
    @include('components.errors')
    <div class="card-body">
        <div class="row">
            <div class="form-group col-6 pr-4">
                <label for="name">@lang('admin.org_name')</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{old('name', $model->name)}}" autocomplete="off">
            </div>

            <div class="form-group col-6 pl-4">
                <label for="district_id">@lang('admin.organ.select_hint')</label>
                <select name="district_id" id="district_id" class="custom-select" required>
                    <option value="">{{__('admin.select')}}</option>
                    @foreach($districts as $key => $district)
                        <option value="{{$key}}"
                                @if ($key == $model->district_id) selected @endif>
                            {{$district}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-4">
                <label for="lead_engineer">{{__('admin.organ.engineer')}}</label>
                <input type="text" name="lead_engineer" id="lead_engineer" class="form-control"
                       value="{{old('name', $model->lead_engineer)}}">
            </div>
            <div class="form-group col-6 pl-4">
                <label for="department_head">{{__('admin.organ.department_head')}}</label>
                <input type="text" name="department_head" id="department_head" class="form-control"
                       value="{{old('department_head', $model->department_head)}}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-4">
                <label for="tin">{{__('admin.organ.org_num')}}</label>
                <input type="number" name="tin" id="tin" class="form-control"
                       value="{{old('tin', $model->tin)}}" minlength="9" maxlength="9">
            </div>

            <div class="form-group col-6 pl-4">
                <label for="email">{{__('admin.organ.email')}}</label>
                <input type="email" name="email" id="email" value="{{$model->email}}" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6 pr-4">
                <label for="address">{{__('admin.organ.address')}}</label>
                <input type="text" name="address" id="address" class="form-control"
                       value="{{ $model->address }}" autocomplete="off">
            </div>

            <div class="form-group col-6 pl-4">
                <label for="address_krill">{{__('admin.organ.address_krill')}}</label>
                <input type="text" name="address_krill" id="address_krill" class="form-control"
                       value="{{ $model->address_krill }}" autocomplete="off">
            </div>
        </div>

        <div class="row">
            <div class="col-6 pr-4">
                <div class="form-group">
                    <label for="phone">{{__('admin.phone')}}</label>
                    <input type="tel" name="phone" id="phone" class="form-control"
                           value="{{ old('phone', $model->phone) }}" autocomplete="off">
                </div>
            </div>

            <div class="col-6 pl-4">
                <div class="form-group">
                    <label for="fax">{{__('admin.organ.fax')}}</label>
                    <input type="text" name="fax" id="fax" class="form-control"
                           value="{{ $model->fax }}" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">{{__('global.btn_save')}}</button>
        <div class="float-right">
            <a href="{{route('admin.organs.index')}}" class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
            <button type="reset" class="btn btn-default">{{__('global.btn_reset')}}</button>
        </div>
    </div>
</form>
