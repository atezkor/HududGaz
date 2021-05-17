@extends('secondary')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/extra/summernote.min.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>@lang('district.proposition.heading_create')</h3>
            </div>
            <form action="" method="post">
                @csrf
                @include('components.errors')
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('district.proposition.heading')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 pr-3">
                                    <div class="form-group">
                                        <label for="address">@lang('district.proposition.address')<span class="required">*</span></label>
                                        <input type="text" name="address" id="address" value="{{$model->address}}"
                                               class="form-control" placeholder="@lang('district.proposition.address_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="access_point">@lang('district.proposition.access_point')<span class="required">*</span></label>
                                        <input type="text" name="access_point" id="access_point" value="{{$model->access_point}}"
                                               class="form-control" placeholder="@lang('district.proposition.point_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="above_len">@lang('district.proposition.above_len')<span class="required">*</span></label>
                                        <input type="number" name="above_len" id="above_len" value="{{$model->above_len}}"
                                               class="form-control" placeholder="@lang('district.proposition.above_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="under_len">@lang('district.proposition.under_len')<span class="required">*</span></label>
                                        <input type="number" name="under_len" id="under_len" value="{{$model->under_len}}"
                                               class="form-control" placeholder="@lang('district.proposition.under_hint')">
                                    </div>
                                    <div class="form-group">
                                        <label for="diameter">@lang('district.proposition.diameter')<span class="required">*</span></label>
                                        <input type="number" name="diameter" id="diameter" value="{{$model->diameter}}"
                                               class="form-control" placeholder="@lang('district.proposition.diameter_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="depth">@lang('district.proposition.depth')<span class="required">*</span></label>
                                        <input type="number" name="depth" id="depth" value="{{$model->depth}}"
                                               class="form-control" placeholder="@lang('district.proposition.depth_hint')">
                                    </div>
                                </div>
                                <div class="col-6 pl-3">
                                    <div class="form-group">
                                        <label for="capability">@lang('district.proposition.capability')<span class="required">*</span></label>
                                        <input type="number" name="capability" id="capability" value="{{$model->capability}}"
                                               class="form-control" placeholder="@lang('district.proposition.capacity_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="real_capability">@lang('district.proposition.real_capability')<span class="required">*</span></label>
                                        <input type="number" name="real_capability" id="real_capability" value="{{$model->real_capability}}"
                                               class="form-control" placeholder="@lang('district.proposition.real_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="pressure_win">@lang('district.proposition.pressure_win')<span class="required">*</span></label>
                                        <input type="number" name="pressure_win" id="pressure_win" value="{{$model->pressure_win}}"
                                               class="form-control" placeholder="@lang('district.proposition.winter_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="pressure_sum">@lang('district.proposition.pressure_sum')<span class="required">*</span></label>
                                        <input type="number" name="pressure_sum" id="pressure_sum" value="{{$model->pressure_sum}}"
                                               class="form-control" placeholder="@lang('district.proposition.summer_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="grc">@lang('district.proposition.grc')<span class="required">*</span></label>
                                        <input type="text" name="grc" id="grc" value="{{$model->grc}}" class="form-control"
                                               placeholder="@lang('district.proposition.grc_hint')">
                                    </div>

                                    <div class="form-group">
                                        <label for="consumption">@lang('district.proposition.consumption')<span class="required">*</span></label>
                                        <input type="number" name="consumption" id="consumption" value="{{$model->consumption}}"
                                               class="form-control" placeholder="@lang('district.proposition.consume_hint')">
                                    </div>
                                </div>

                                <div class="card-body col-12 px-0">
                                    <div id="description"></div>
                                </div>

                                <div class="col-12 px-0">
                                    <button type="button" class="btn btn-block btn-outline-info">
                                        @lang('district.proposition.add_equipment')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">@lang('global.btn_save')</button>
                    <a href="{{route('district.propositions')}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                    <button type="reset" id="reset" class="btn btn-default float-right">@lang('global.btn_reset')</button>
                </div>
            </form>
        </div>
    </div>
</section>
@stop

@section('javascript')
<!-- For text editor -->
<script src="{{'/js/jquery.min.js'}}"></script>
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/extra/summernote.min.js'}}"></script>
<script>
    $(document).ready(function() {
        $('#description').summernote();
    });
</script>
@endsection
