@extends('secondary')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/extra/summernote.min.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    @if ($model->status == 3)
                        <h3>@lang('district.recommendation.heading_edit')</h3>
                    @else
                        <h3>@lang('district.recommendation.heading_create')</h3>
                    @endif
                    </div>
                    <form id="form" action="{{$action}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('components.errors')
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('district.recommendation.heading')</h3>
                                </div>
                                <div class="card-body">
                                    @include("district.control.$type")
                                    <input type="hidden" name="proposition_id" value="{{$proposition}}">
                                    <input type="hidden" name="type" value="{{$type}}">

                                    @if ($model->status == 3)
                                    <div class="col-12 mt-5">
                                        <div class="form-group">
                                            <label for="file">@lang('district.file')</label>
                                            <div class="custom-file">
                                                <input type="file" name="file" id="file" class="custom-file-input" required>
                                                <label class="custom-file-label" for="file">
                                                    <span id="file_hint">@lang('district.file_hint')</span>
                                                    <span class="btn btn-info"><i class="far fa-file-pdf"></i></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        @if ($model->status == 3)
                            <button type="submit" class="btn btn-primary mr-2">@lang('global.btn_upd')</button>
                        @else
                            <button type="submit" class="btn btn-primary mr-2">@lang('global.btn_save')</button>
                        @endif
                            <a href="{{$back}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                            <button type="reset" id="reset" class="btn btn-default float-right">@lang('global.btn_reset')</button>
                        </div>
                    </form>
                </div>
            </div>
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
        $('#additional').summernote();

        $('input').each(function(){
            this.oninvalid = () => {
                this.setCustomValidity("@lang('district.recommendation.required')");
            }
            this.oninput = () => {
                this.setCustomValidity('');
            }
        })
    });

    $('#file').change(function(input) {
        try {
            $('#file_hint').text(input.target.files[0].name);
        } catch (e) {}
    })

    $('#reset').on('click', function() {
        $('#file_hint').text("@lang('district.file_hint')");
    });
</script>
@endsection
