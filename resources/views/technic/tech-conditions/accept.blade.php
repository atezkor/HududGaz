@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/summernote/summernote.min.css'}}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                        @if(request()->route()->parameter('condition'))
                            <h3 class="card-title">@lang('technic.tech_condition.heading_edit')</h3>
                        @else
                            <h3 class="card-title">@lang('technic.tech_condition.heading_create')</h3>
                        @endif
                        </div>
                        <form action="{{$action}}" method="post">
                            @csrf
                            @include('components.errors')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="above">@lang('technic.tech_condition.cond_content')</label>
                                    <div id="above" class="list-group-item">
                                        @include('technic.tech-conditions.above')
                                    </div>
                                </div>

                                <div class="form-group mt-5">
                                    <label for="content">@lang('technic.tech_condition.cond_content')</label>
                                    <textarea name="content" id="content">
                                        @include('technic.tech-conditions.template')
                                    </textarea>
                                </div>
                                <input type="hidden" name="description" value="{{$recommendation->description}}">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">@lang('global.btn_save')</button>
                                <div class="float-right">
                                    <a href="{{route('technic.recommendations')}}" class="btn btn-outline-secondary">@lang('global.btn_back')</a>
                                    <button type="reset" class="btn btn-default">@lang('global.btn_reset')</button>
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
        $(document).ready(function() {
           $('#content').summernote();
        });

        showNavbar();
    </script>
@endsection
