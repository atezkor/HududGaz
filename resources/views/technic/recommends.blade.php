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
                            <th>@lang('global.proposition.number')</th>
                            <th>@lang('global.consumer')</th>
                            <th>@lang('technic.recommendation.name')</th>
                            <th>@lang('technic.organ')</th>
                            <th>@lang('global.proposition.date')</th>
                            <th>@lang('global.proposition.limit')</th>
                            <th>@lang('global.proposition.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php($limit = limit(5, 3))
                    @php($l = 0)
                    @php($p = 0)
                    @foreach($propositions as $key => $model)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$model->number}}</td>
                            <td>{{$applicant($physicals, $legals, $p, $l, $model->type)}}</td>
                            <td>
                                <a href="{{route('technic.recommendation.show', ['recommendation' => $recommendations[$key]])}}" target="_blank">
                                    @lang('technic.recommendation.show')
                                </a>
                            </td>
                            <td>{{$organs[$model->organ]}}</td>
                            <td>{{$model->created_at}}</td>
                            <td>
                                <div class="progress progress-xs">
                                    <div class="{{progressColor($model->percent($model->limit($limit)))}}"
                                         style="width: {{$model->percent($model->limit($limit))}}%">
                                    </div>
                                </div>
                                <div class="text-center">{{$model->limit($limit)}} @lang('global.hour')</div>
                            </td>
                            <td>
                                <a href="{{"tech-condition"}}" class="btn btn-outline-info">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <button type="button" onclick="back('{{route('technic.recommendation.back', ['recommendation' => $recommendations[$key]])}}')"
                                        class="btn btn-outline-secondary">
                                    <i class="fas fa-undo"></i>
                                </button>
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
@section('javascript')
<script src="{{'/js/jquery.min.js'}}"></script>
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.jquery.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.bootstrap4.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.responsive.min.js'}}"></script>
<script>
    $(function () {
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

        $("#table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            searching: true,
            language: lang
        });
    });

    function back(url) {
        Swal.fire({
            title: "@lang('technic.recommendation.alert_title')",
            text: "@lang('technic.recommendation.alert_text')",
            input: 'text',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#007bff',
            confirmButtonText: "@lang('technic.recommendation.btn_back')",
            cancelButtonText: "@lang('global.btn_cancel')",
            preConfirm: (value) => {
                console.log(value)
                return fetch(url, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                            // "Accept": "application/json",
                            // "X-Requested-With": "XMLHttpRequest",
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
                        Swal.showValidationMessage("@lang('technic.recommendation.error')");
                    })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "@lang('technic.recommendation.process')",
                    html: "@lang('technic.recommendation.wait')",
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
