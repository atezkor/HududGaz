@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @lang('admin.organ.heading_create')
                        </h3>
                    </div>
                    @include('admin.organs.form', ['action' => route('admin.organs.store'), 'method' => 'POST'])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
