<div class="row">
    <div class="col-6 pr-3">
        <div class="form-group row">
            <label for="number" class="col-4 col-form-label">@lang('global.proposition.number')</label>
            <div class="col-8">
                <input type="text" id="number" class="form-control" value="{{$model->id}}" disabled>
            </div>
        </div>
    </div>

    <div class="col-6 pl-3">
        <div class="form-group row">
            <label for="date" class="col-4 col-form-label">@lang('global.proposition.date')</label>
            <div class="col-8">
                <input type="date" name="date" class="form-control" value="{{now()->format('Y-m-d')}}" disabled>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <label for="description">@lang('district.recommendation.description')</label>
        <input type="text" name="description" id="description" value="{{$model->description}}" class="form-control"
               placeholder="@lang('district.recommendation.desc_hint')" required>
    </div>

    <div class="col-12 mt-5">
        <label for="additional">@lang('district.recommendation.additional')</label>
        <textarea id="additional" name="additional">{{$model->additional}}</textarea>
    </div>
</div>
