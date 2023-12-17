@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/datatable/datatables.bootstrap4.min.css'}}">
    <link rel="stylesheet" href="{{'/css/datatable/responsive.bootstrap4.min.css'}}">
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a href="#individual" class="nav-link active" data-toggle="tab">
                                            @lang('global.proposition.individual')
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#legal" class="nav-link" data-toggle="tab">
                                            @lang('global.proposition.legal_entity')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @can('crud_prop')
                                <div class="col">
                                    <a href="{{route('propositions.create')}}" class="btn btn-info float-md-right">
                                        @lang('technic.btn_new')
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="individual" class="tab-pane active">
                                @include('technic.applications.physical')
                            </div>
                            <div id="legal" class="tap-pane">
                                @include('technic.applications.legal')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script src="{{'/js/jquery.min.js'}}"></script>
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script src="{{'/js/datatable/datatables.jquery.min.js'}}"></script>
    <script src="{{'/js/datatable/datatables.bootstrap4.min.js'}}"></script>
    <script src="{{'/js/datatable/datatables.responsive.min.js'}}"></script>
    <script src="{{'/js/default.js'}}"></script>
    <script>
        let lang = {
            emptyTable: "@lang('global.datatables.emptyTable')",
            infoEmpty: "@lang('global.datatables.infoEmpty')",
            sSearch: "@lang('global.datatables.search')",
            oPaginate: {
                sPrevious: "@lang('global.datatables.previous')",
                sNext: "@lang('global.datatables.next')",
            },
            sInfo: "@lang('global.datatables.info')",
            sZeroRecords: "@lang('global.datatables.zeroRecords')",
            sInfoFiltered: "@lang('global.datatables.infoFiltered')"
        }
        datatable(lang, 'table1', 'table2');

        function remove(btn) {
            Swal.fire({
                title: '{{__('technic.proposition.alert_message')}}',
                text: "{{__('technic.proposition.alert_text')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dd3333',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{__('global.btn_yes')}}',
                cancelButtonText: '{{__('global.btn_no')}}'
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.parentNode.submit();
                    Swal.fire({
                        title: '{{__('global.del_process')}}',
                        icon: 'success',
                        showConfirmButton: false,
                    });
                }
            });
        }

        showNavbar();
    </script>
@endsection
