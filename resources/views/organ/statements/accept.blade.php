<div class="row">
    <div class="col-6 pr-3">
        <div class="form-group">
            <label for="address">@lang('organ.recommendation.address')<span class="required">*</span></label>
            <input type="text" name="address" id="address" value="{{$model->address}}"
                   class="form-control" placeholder="@lang('organ.recommendation.address_hint')" autocomplete="off" required>
        </div>

        <div class="form-group">
            <label for="access_point">@lang('organ.recommendation.access_point')<span class="required">*</span></label>
            <input type="text" name="access_point" id="access_point" value="{{$model->access_point}}"
                   class="form-control" placeholder="@lang('organ.recommendation.point_hint')" required>
        </div>

        <div class="form-group">
            <label for="gas_network">@lang('organ.recommendation.gas_network')<span class="required">*</span></label>
            <input type="text" name="gas_network" id="gas_network" value="{{$model->gas_network}}"
                   class="form-control" placeholder="@lang('organ.recommendation.gas_network')@lang('organ.recommendation.input')" required>
        </div>

        <div class="form-group">
            <label for="pipeline">@lang('organ.recommendation.pipeline')<span class="required">*</span></label>
            <select name="pipeline" id="pipeline" class="custom-select">
                <option value="under_len">@lang('organ.recommendation.under_len')</option>
                <option value="above_len" @if($model->pipeline == 'above_len') selected @endif>
                    @lang('organ.recommendation.above_len')
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="pipe_type">@lang('organ.recommendation.pipe_type')<span class="required">*</span></label>
            <select name="pipe_type" id="pipe_type" class="custom-select">
                <option value="low_pressure">@lang('organ.recommendation.low_pressure')</option>
                <option value="high_pressure" @if($model->pipe_type == 'high_pressure') selected @endif>
                    @lang('organ.recommendation.high_pressure')
                </option>
            </select>
        </div>

        <div class="form-group">
            <label for="length">@lang('organ.recommendation.length')<span class="required">*</span></label>
            <input type="number" name="length" id="length" value="{{$model->length}}"
                   class="form-control" placeholder="@lang('organ.recommendation.len_hint')" required>
        </div>
        <div class="form-group">
            <label for="pipe1">@lang('organ.recommendation.diameter')<span class="required">*</span></label>
            <input type="number" name="pipe1" id="pipe1" step="0.01" value="{{$model->pipe1}}"
                   class="form-control" placeholder="@lang('organ.recommendation.diameter_hint')" required>
        </div>
    </div>
    <div class="col-6 pl-3">
        <div class="form-group">
            <label for="depth">@lang('organ.recommendation.depth')<span class="required">*</span></label>
            <input type="number" name="depth" id="depth" value="{{$model->depth}}"
                   class="form-control" placeholder="@lang('organ.recommendation.depth_hint')" required>
        </div>

        <div class="form-group">
            <label for="capability">@lang('organ.recommendation.capability')<span class="required">*</span></label>
            <input type="number" name="capability" id="capability" step="0.1" value="{{$model->capability}}"
                   class="form-control" placeholder="@lang('organ.recommendation.capacity_hint')" required>
        </div>

        <div class="form-group">
            <label for="pressure_win">@lang('organ.recommendation.pressure_win')<span class="required">*</span></label>
            <input type="number" name="pressure_win" id="pressure_win" step="0.1" value="{{$model->pressure_win}}"
                   class="form-control" placeholder="@lang('organ.recommendation.winter_hint')" required>
        </div>

        <div class="form-group">
            <label for="pressure_sum">@lang('organ.recommendation.pressure_sum')<span class="required">*</span></label>
            <input type="number" name="pressure_sum" id="pressure_sum" step="0.1" value="{{$model->pressure_sum}}"
                   class="form-control" placeholder="@lang('organ.recommendation.summer_hint')" required>
        </div>

        <div class="form-group">
            <label for="grc">@lang('organ.recommendation.grc')<span class="required">*</span></label>
            <input type="text" name="grc" id="grc" value="{{$model->grc}}" class="form-control"
                   placeholder="@lang('organ.recommendation.grc_hint')" required>
        </div>

        <div class="form-group">
            <label for="consumption">@lang('organ.recommendation.consumption')<span class="required">*</span></label>
            <input type="number" name="consumption" id="consumption" step="0.01" value="{{$model->consumption}}"
                   class="form-control" placeholder="@lang('organ.recommendation.consume_hint')" required>
        </div>
    </div>

    <div class="card-body col-12 px-2">
        <label for="additional">@lang('organ.recommendation.additional')</label>
        <textarea name="additional" id="additional">
        @if ($model->status == 3)
            {{$model->additional}}
        @else
            <ol start="9">
                <li>
                    <span class="text-bold">@lang('organ.pdf.purpose_for_use'):</span>
                    <span>&nbsp;</span>
                </li>
                <li>
                    <span class="text-bold">Buyurtmachi uchun alohida shartlar:</span>
                    <span>&nbsp;</span>
                </li>
                <li>
                    <span class="text-bold">Buyurtmachi manzili:</span>
                    <span>&nbsp;</span>
                </li>
            </ol>
        @endif
        </textarea>
    </div>

    <div id="equipment-part" class="col-12"></div>
    <input type="hidden" name="equipments" id="equipments" value="{{$model->equipments ?? "[]"}}">

    <div class="col-12 px-2">
        <button type="button" onclick="addEquipment()" class="btn btn-block btn-outline-info text-bold">
            <i class="fas fa-plus"></i>
            <span>@lang('organ.recommendation.add_equipment')</span>
        </button>
    </div>
</div>
