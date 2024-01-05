@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/datatable/datatables.bootstrap4.min.css'}}">
    <link rel="stylesheet" href="{{'/css/datatable/responsive.bootstrap4.min.css'}}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-center">
                        <thead>
                            <tr>
                                <th>@lang('global.index')</th>
                                <th>@lang('global.consumer')</th>
                                <th>@lang('engineer.tech_condition')</th>
                                <th>@lang('engineer.project.name')</th>
                                <th>@lang('engineer.designer')</th>
                                <th>@lang('engineer.organ')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $model)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$model->applicant->name}} ({{$model->applicant->tin_pin}})</td>
                                    <td>
                                        <a href="{{route('engineer.tech-condition.view', $model->tech_condition_id)}}"
                                           target="_blank">
                                            @lang('engineer.show')
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('engineer.project.view', $model->id)}}"
                                           target="_blank">
                                            @lang('engineer.show')
                                        </a>
                                    </td>
                                    <td>{{$designers[$model->designer_id]}}</td>
                                    <td>{{$organs[$model->organ_id]}}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div
                                                class="{{$model->progressColor($model->percent($model->limit($limit)))}}"
                                                style="width: {{$model->percent($model->limit($limit))}}%">
                                            </div>
                                        </div>
                                        <div class="text-center">{{$model->limit($limit)}} @lang('global.hour')</div>
                                    </td>
                                    <td>
                                        <form action="{{route('engineer.project.confirm', $model)}}"
                                              method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="pdf" id="pdf-{{$model->id}}"
                                                   onchange="this.parentNode.submit()" hidden>
                                            <label for="pdf-{{$model->id}}" class="btn btn-outline-info my-0"
                                                   title="@lang('global.btn_cfm')">
                                                <i class="fas fa-check"></i>
                                            </label>
                                            <button type="button"
                                                    onclick="cancel('{{route('engineer.project.cancel', $model)}}')"
                                                    class="btn btn-outline-danger" title="@lang('global.btn_cancel')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        datatable({
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
        }, 'table');

        function cancel(url) {
            Swal.fire({
                title: "@lang('engineer.project.alert_title')",
                text: "@lang('engineer.project.alert_text')",
                input: 'text',
                inputPlaceholder: "@lang('engineer.note')",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "@lang('global.btn_send')",
                cancelButtonText: "@lang('global.btn_cancel')",
                preConfirm: (value) => {
                    return fetch(url, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            comment: value
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response;
                    })
                        .catch(() => {
                            Swal.showValidationMessage("@lang('engineer.error')");
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "@lang('engineer.process')",
                        html: "@lang('engineer.wait')",
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    location.reload();
                }
            });
        }
    </script>
@endsection
