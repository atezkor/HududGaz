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
                                    <a href="#individual" id="individual-applicant" class="nav-link active"
                                       onclick="changeType({{ $model::PHYSICAL }})"
                                       data-toggle="tab">
                                        @lang('global.proposition.individual')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#legal" id="legal-applicant" class="nav-link" onclick="changeType({{ $model::LEGAL }})"
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
@section("extra")
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script>
        $(document).ready(function() {
            let applicationType = {{old('type', $model->type) ?? $model::PHYSICAL}};
            if (applicationType !== {{$model::PHYSICAL}}) {
                $('#legal-applicant').tab('show'); // $('#individual').removeClass('active');
            }

            changeType(applicationType)
        });
        showNavbar();
    </script>
@endsection
