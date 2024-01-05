@extends('secondary')
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
                    <button onclick="create()" class="btn btn-info">@lang('mounter.project.read')</button>
                </div>
                <div class="card-body">
                    <table id="table" class="table table-bordered table-striped table-center">
                        <thead>
                            <tr>
                                <th>@lang('global.index')</th>
                                <th>@lang('global.consumer')</th>
                                <th>@lang('mounter.tech_condition')</th>
                                <th>@lang('mounter.project.name')</th>
                                <th>@lang('mounter.organ')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
                                <th>@lang('global.proposition.date')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$model->applicant->name}} ({{$model->applicant->tin_pin}})</td>
                                    <td>
                                        <a href="{{route('mounter.tech-condition.view', $model->tech_condition_id)}}"
                                           target="_blank">
                                            @lang('global.btn_show')
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('mounter.project.view', $model->project_id)}}"
                                           target="_blank">
                                            @lang('global.btn_show')
                                        </a>
                                    </td>
                                    <td>{{$organs[$model->organ_id]}}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div
                                                class="{{$model->progressColor($model->percent($limit($model->status)))}}"
                                                style="width: {{$model->percent($limit($model->status))}}%">
                                            </div>
                                        </div>
                                        <div class="text-center">{{$limit($model->status)}} @lang('global.hour')</div>
                                    </td>
                                    <td>
                                        <form action="{{route('mounter.montage.finish', $model)}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="pdf" id="pdf_{{$model->id}}" hidden>
                                            <button type="button" onclick="finish(pdf_{{$model->id}})"
                                                    class="btn btn-outline-info text-bold my-0"
                                                    title="@lang('global.btn_upload')">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                            <button type="button" onclick="remove({{$model->id}})"
                                                    class="btn btn-outline-danger" title="@lang('global.btn_del')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <span>{{$model->created_at->format('d.m.Y H:i')}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row w-100">
                                <div class="col-10">
                                    <h4 id="header" class="modal-title">@lang('mounter.project.read')</h4>
                                </div>
                                <div class="col-2">
                                    <img src="data:image/svg+xml;base64, {{base64_encode($qrcode)}}" alt="QR"
                                         class="img-md">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('mounter.project.open')}}" method="POST"
                                  id="form" onsubmit="submit.disabled = true">
                                @csrf
                                <div class="form-group">
                                    <label for="code">@lang('mounter.project.code')</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                           placeholder="@lang('mounter.project.code_read')" autocomplete="off" required>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" id="submit"
                                            class="btn btn-primary">@lang('global.btn_read')</button>
                                    <button type="button" class="btn btn-default"
                                            data-dismiss="modal">@lang('global.btn_cancel')</button>
                                </div>
                            </form>
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

        function create() {
            $('#modal').modal();
            $('#number').val(null);
        }

        function finish(input) {
            Swal.fire({
                title: "@lang('mounter.alert_title')",
                text: "@lang('mounter.alert_text')",
                input: 'number',
                inputPlaceholder: "@lang('mounter.diameter')",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: "@lang('global.btn_send')",
                cancelButtonText: "@lang('global.btn_cancel')",
                preConfirm: (value) => {
                    return fetch(input.parentElement.action, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        credentials: "same-origin",
                        body: JSON.stringify({
                            diameter: value
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response;
                    }).catch(() => {
                        Swal.showValidationMessage("@lang('mounter.error')");
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    input.click();
                    input.onchange = function() {
                        input.parentElement.submit();
                    }
                }
            });
        }

        function remove(id) {
            Swal.fire({
                title: "@lang('mounter.delete_title')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dd3333',
                cancelButtonColor: '#3085d6',
                confirmButtonText: "@lang('global.btn_yes')",
                cancelButtonText: "@lang('global.btn_no')"
            }).then((result) => {
                if (result.isConfirmed) {
                    ajax("{{route('mounter.montage.delete')}}/" + id, {}, function() {
                        Swal.fire({
                            title: "@lang('global.del_process')",
                            icon: 'success',
                            showConfirmButton: false
                        });
                        location.reload();
                    });
                }
            });
        }
    </script>
@endsection

