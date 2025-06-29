<div class="row">
    <div class="col-6 pr-3">
        <div class="form-group row">
            <label for="number" class="col-4 col-form-label">@lang('global.proposition.number')</label>
            <div class="col-8">
                <input type="text" id="number" class="form-control" value="{{$proposition->number}}" disabled>
            </div>
        </div>
    </div>

    <div class="col-6 pl-3">
        <div class="form-group row">
            <label for="date" class="col-4 col-form-label">@lang('global.proposition.date')</label>
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" name="date" class="form-control" value="{{formatDate($proposition->data_created, 'Y-m-d')}}" disabled>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <label for="description">@lang('organ.recommendation.description')</label>
        <input type="text" name="description" id="description" value="{{$model->description}}" class="form-control"
               placeholder="@lang('organ.recommendation.desc_hint')" autocomplete="off" required>
    </div>

    <div class="col-12 mt-4">
        <label for="additional">@lang('organ.recommendation.notification') <span class="required">*</span></label>
        <textarea id="additional" name="additional" rows="15">&nbsp;&nbsp;&nbsp;&nbsp;{{$model->additional}}</textarea>
    </div>
</div>
