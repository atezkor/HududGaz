@extends('layout')
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#individual" class="nav-link active" onclick="changeType(1)"
                                       data-toggle="tab">
                                        @lang('global.proposition.individual')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#legal_entity" class="nav-link" onclick="changeType(2)"
                                       data-toggle="tab">
                                        @lang('global.proposition.legal_entity')
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @include('technic.propositions.form', ['action' => route('propositions.store')])
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
            if ({{$model->type ?? 1}} === 2) {
                $('#legal_entity').tab('show');
                $('#individual').removeClass('active');
                $('#type').val(2);
            }
        });

        function checkTin(type, stir) {
            $.get(`{{route('technic.check_stir')}}/${type}/${stir}`, function(data) {
                if (data.length === 0)
                    return;

                toast(`<a href="{{route('technic.propositions')}}/${type}/${stir}" target="_blank" class="text-danger">Bunday stirli ariza mavjud (${Object.keys(data).length})</a>`,
                    'warning', 5000)
            });
        }

        showNavbar();
    </script>
@endsection
