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
                        <h3>@lang('district.recommendation.heading_create')</h3>
                    </div>
                    <form id="form" action="{{route('district.recommendation.store', ['type' => $type])}}" method="post">
                        @csrf
                        @include('components.errors')
                        <div class="card-body">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('district.recommendation.heading')</h3>
                                </div>
                                <div class="card-body">
                                    @include("district.$type")
                                    <input type="hidden" name="proposition_id" value="{{$model->id}}">
                                    <input type="hidden" name="type" value="{{$type}}">
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
    console.log($('#additional').summernote('code'));
</script>
@endsection
