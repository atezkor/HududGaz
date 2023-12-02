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
                            @lang('admin.mounter.heading_edit')
                        </h3>
                    </div>
                    @include('admin.mounters.form', [
                        'action' => route('admin.mounters.update', $model->id),
                        'method' => 'PUT'
                    ])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
