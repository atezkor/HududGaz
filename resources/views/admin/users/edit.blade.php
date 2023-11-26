@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @lang('admin.user.heading_edit')
                        </h3>
                    </div>
                    <form action="{{ route('admin.users.update', $model->id) }}" method="post">
                        @csrf
                        @method("PUT")
                        @include('admin.users.form')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @lang('global.btn_renew')
                            </button>
                            <div class="float-right">
                                <a href="{{route('admin.users.index')}}"
                                   class="btn btn-outline-secondary">{{__('global.btn_back')}}</a>
                                <button type="reset" id="reset"
                                        class="btn btn-default">{{__('global.btn_reset')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
