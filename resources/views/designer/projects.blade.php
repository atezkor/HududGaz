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
                <button onclick="create()" class="btn btn-info">@lang('designer.btn_add')</button>
            </div>
            <div class="card-body">
                <table id="table" class="table table-bordered table-striped table-center">
                    <thead>
                        <tr>
                            <th>@lang('global.index')</th>
                            <th>@lang('global.consumer')</th>
                            <th>@lang('designer.tech_condition')</th>
                            <th>@lang('designer.organ')</th>
                            <th>@lang('global.proposition.limit')</th>
                            <th>@lang('global.proposition.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $key => $model)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$model->applicant}}</td>
                            <td>
                                <a href="{{route('technic.tech_condition.show', ['condition' => $model->condition])}}"
                                   target="_blank">
                                    @lang('designer.show')
                                </a>
                            </td>
                            <td>{{$organs[$model->organ]}}</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="{{progressColor($model->percent($limit))}}"
                                         style="width: {{$model->percent($limit)}}%">
                                    </div>
                                </div>
                                <div class="text-center">{{$limit}} @lang('global.hour')</div>
                            </td>
                            <td>
                                <form action="{{route('designer.project.upload', ['project' => $model])}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" id="file-{{$key}}" class="d-none" onchange="upload(this)">
                                    <label for="file-{{$key}}" class="btn btn-outline-info text-bold" title="@lang('global.btn_upload')">
                                        <i class="fas fa-upload"></i>
                                    </label>
                                </form>
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
                                <h4 id="header" class="modal-title">@lang('designer.project.add_project')</h4>
                            </div>
                            <div class="col-2">
                                <img src="data:image/svg+xml;base64, {{base64_encode($qrcode)}}" alt="QR" class="img-md">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('designer.project.create')}}" method="POST"
                              id="form" onsubmit="submit.disabled = true">
                            @csrf
                            <div class="form-group">
                                <label for="code">@lang('designer.project.code')</label>
                                <input type="text" name="code" id="code" class="form-control"
                                       placeholder="@lang('designer.project.code_read')" autocomplete="off" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" id="submit" class="btn btn-primary">@lang('global.btn_add')</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('global.btn_cancel')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('javascript')
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

        function upload(input) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: input.parentElement.action,
                method: 'POST',
                dataType: 'html',
                data: {
                    'download': true
                },
                success: function(data) {
                    let win = open('', '');
                    let doc = win.document;
                    doc.write(data);

                    input.parentElement.submit();
                }
            });
        }
    </script>
@endsection
