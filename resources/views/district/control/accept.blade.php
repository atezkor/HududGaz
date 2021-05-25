<div class="row">
    <div class="col-6 pr-3">
        <div class="form-group">
            <label for="address">@lang('district.recommendation.address')<span class="required">*</span></label>
            <input type="text" name="address" id="address" value="{{$model->address}}"
                   class="form-control" placeholder="@lang('district.recommendation.address_hint')" required>
        </div>

        <div class="form-group">
            <label for="access_point">@lang('district.recommendation.access_point')<span class="required">*</span></label>
            <input type="text" name="access_point" id="access_point" value="{{$model->access_point}}"
                   class="form-control" placeholder="@lang('district.recommendation.point_hint')" required>
        </div>

        <div class="form-group">
            <label for="above_len">@lang('district.recommendation.above_len')<span class="required">*</span></label>
            <input type="number" name="above_len" id="above_len" value="{{$model->above_len}}"
                   class="form-control" placeholder="@lang('district.recommendation.above_hint')" required>
        </div>

        <div class="form-group">
            <label for="under_len">@lang('district.recommendation.under_len')<span class="required">*</span></label>
            <input type="number" name="under_len" id="under_len" value="{{$model->under_len}}"
                   class="form-control" placeholder="@lang('district.recommendation.under_hint')" required>
        </div>
        <div class="form-group">
            <label for="diameter">@lang('district.recommendation.diameter')<span class="required">*</span></label>
            <input type="number" name="diameter" id="diameter" step="0.01" value="{{$model->diameter}}"
                   class="form-control" placeholder="@lang('district.recommendation.diameter_hint')" required>
        </div>

        <div class="form-group">
            <label for="depth">@lang('district.recommendation.depth')<span class="required">*</span></label>
            <input type="number" name="depth" id="depth" value="{{$model->depth}}"
                   class="form-control" placeholder="@lang('district.recommendation.depth_hint')" required>
        </div>
    </div>
    <div class="col-6 pl-3">
        <div class="form-group">
            <label for="capability">@lang('district.recommendation.capability')<span class="required">*</span></label>
            <input type="number" name="capability" id="capability" step="0.1" value="{{$model->capability}}"
                   class="form-control" placeholder="@lang('district.recommendation.capacity_hint')" required>
        </div>

        <div class="form-group">
            <label for="real_capacity">@lang('district.recommendation.real_capacity')<span class="required">*</span></label>
            <input type="number" name="real_capacity" id="real_capacity" step="0.1" value="{{$model->real_capacity}}"
                   class="form-control" placeholder="@lang('district.recommendation.real_hint')" required>
        </div>

        <div class="form-group">
            <label for="pressure_win">@lang('district.recommendation.pressure_win')<span class="required">*</span></label>
            <input type="number" name="pressure_win" id="pressure_win" step="0.1" value="{{$model->pressure_win}}"
                   class="form-control" placeholder="@lang('district.recommendation.winter_hint')" required>
        </div>

        <div class="form-group">
            <label for="pressure_sum">@lang('district.recommendation.pressure_sum')<span class="required">*</span></label>
            <input type="number" name="pressure_sum" id="pressure_sum" step="0.1" value="{{$model->pressure_sum}}"
                   class="form-control" placeholder="@lang('district.recommendation.summer_hint')" required>
        </div>

        <div class="form-group">
            <label for="grc">@lang('district.recommendation.grc')<span class="required">*</span></label>
            <input type="text" name="grc" id="grc" value="{{$model->grc}}" class="form-control"
                   placeholder="@lang('district.recommendation.grc_hint')" required>
        </div>

        <div class="form-group">
            <label for="consumption">@lang('district.recommendation.consumption')<span class="required">*</span></label>
            <input type="number" name="consumption" id="consumption" step="0.01" value="{{$model->consumption}}"
                   class="form-control" placeholder="@lang('district.recommendation.consume_hint')" required>
        </div>
    </div>

    <div class="card-body col-12 px-0">
        <label for="additional">@lang('district.recommendation.additional')</label>
        <textarea id="additional" name="additional"></textarea>
    </div>

    <div class="col-12 px-0">
        <button type="button" class="btn btn-block btn-outline-info">
            @lang('district.recommendation.add_equipment')
        </button>
    </div>
</div>
