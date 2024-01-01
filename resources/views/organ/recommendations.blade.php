@extends('secondary')
@section('title', getName())
@section('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
@endsection
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
                                <th>@lang('global.proposition.number')</th>
                                <th>@lang('global.consumer')</th>
                                <th>@lang('organ.recommendation.name')</th>
                                <th>@lang('global.proposition.date')</th>
                                <th>@lang('global.proposition.limit')</th>
                                <th>@lang('global.proposition.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propositions as $key => $model)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$model->number}}</td>
                                    <td>{{$model->applicant->name}}</td>
                                    <td>
                                        <a href="{{route('organ.recommendation.show', $model->recommendation->id)}}"
                                           target="_blank">
                                            @lang('organ.show')
                                        </a>
                                    </td>
                                    <td>{{$model->recommendation->created_at->format('d.m.Y H:i')}}</td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div
                                                class="{{$model->recommendation->progressColor($model->recommendation->percent($limit))}}"
                                                style="width: {{$model->recommendation->percent($limit)}}%">
                                            </div>
                                        </div>
                                        <div class="text-center">{{$limit}} @lang('global.hour')</div>
                                    </td>
                                    <td>
                                        <form action="{{route('organ.recommendation.upload', $model->recommendation)}}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="pdf" id="file-{{$key}}" onchange="upload(this)"
                                                   hidden>
                                            <label for="file-{{$key}}" class="btn btn-outline-info text-bold my-0"
                                                   title="@lang('global.btn_upload')">
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
        datatable(lang, 'table');

        function upload(el) {
            let url = el.parentNode.action;
            el.parentNode.submit();

            return;
            let form = new FormData();
            form.append('file', el.files[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                processData: false, // important for send file
                contentType: false, // important for send as file
                cache: false,
                dataType: 'html',
                data: form,
                success: function() {
                    location.reload();
                }
            });
        }
    </script>
@endsection
