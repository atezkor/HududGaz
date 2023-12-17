@extends('layout')
@section('title', getName())
@php
    use App\Models\Application
    /* @var Application $model */;
@endphp

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#individual" class="nav-link active"
                                       onclick="changeType({{ $model::PHYSICAL }})"
                                       data-toggle="tab">
                                        @lang('global.proposition.individual')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#legal" class="nav-link" onclick="changeType({{ $model::LEGAL }})"
                                       data-toggle="tab">
                                        @lang('global.proposition.legal_entity')
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @include('technic.applications.form', ['action' => route('propositions.store')])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script src="{{'/js/default.js'}}"></script>
    <script>
        fileUpload('reset', 'file', 'file_hint', "@lang('technic.proposition.file_hint')")

        function changeType(type) {
            $('#type').val(type);
        }

        $(document).ready(function() {
            if ({{$model->type ?? $model::PHYSICAL}} === {{$model::LEGAL}}) {
                $('#legal').tab('show');
                $('#individual').removeClass('active');
                $('#type').val({{$model::LEGAL}});
            }
        });

        function checkTin(type, tin) {
            $.get(`{{route('propositions.check-for-tin')}}/${type}/${tin}`, function(data) {
                if (data.length === 0)
                    return;
                let text = `@lang('technic.proposition.applications_exist')(${Object.keys(data).length})`;
                let dText = `<a href="{{route('technic.propositions')}}/${type}/${tin}" target="_blank" class="text-danger">${text}</a>`
                toast(dText, 'warning', 2000)
            });
        }

        showNavbar();
    </script>
@endsection
