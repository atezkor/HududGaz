@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/summernote/summernote.min.css'}}">
@endsection

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">@lang('technic.tech_condition.heading_create')</h3>
                        </div>
                        <form id="form" action="{{$action}}" method="post">
                            @csrf
                            @include('components.errors')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="description">@lang('technic.tech_condition.reason')</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                           value="{{$recommendation->description}}" placeholder="@lang('technic.tech_condition.reason_hind')"
                                           autocomplete="off" required>
                                </div>

                                <div class="form-group mt-5">
                                    <label for="reference">@lang('technic.tech_condition.reference')</label>
                                    <textarea name="content" id="reference"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" id="submit" class="btn btn-primary">@lang('global.btn_save')</button>
                                <div class="float-right">
                                    <a href="{{route('technic.recommendations')}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                                    <button type="reset" id="reset" class="btn btn-default">@lang('global.btn_reset')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script src="{{'/js/summernote/summernote.min.js'}}"></script>
    <script src="{{'/js/default.js'}}"></script>
    <script>
        $('#reference').summernote({
            height: 250
        });

        showNavbar();
    </script>
@endsection
