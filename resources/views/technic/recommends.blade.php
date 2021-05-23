@extends('layout')
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
                    <div class="tab-content">
                        <div id="individual" class="tab-pane active">
                            <table id="table1" class="table table-bordered table-striped table-center">
                                <thead>
                                <tr>
                                    <th>@lang('global.index')</th>
                                    <th>@lang('global.proposition.number')</th>
                                    <th>@lang('global.consumer')</th>
                                    <th>@lang('district.recommendation.name')</th>
                                    <th>@lang('global.proposition.date')</th>
                                    <th>@lang('global.proposition.limit')</th>
                                    <th>@lang('global.proposition.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($limit = term(4))
                                @php($l = 0)
                                @php($p = 0)
                                @foreach($propositions as $key => $model)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$model->number}}</td>
                                        <td>{{$applicant($physicals, $legals, $p, $l, $model->type)}}</td>
                                        <td>
                                            <a href="{{route('technic.recommendation.show', ['recommendation' => $model])}}" target="_blank">
                                                @lang('district.show')
                                            </a>
                                        </td>
                                        <td>{{$models[$key]->created_at}}</td>
                                        <td>
                                            <div class="progress progress-xs">
                                                <div class="{{progressColor($model->percent($limit[$model->status - 1]->term))}}"
                                                     style="width: {{$model->percent($limit[$model->status - 1]->term)}}%"></div>
                                            </div>
                                            <div class="text-center">{{$limit[$model->status - 1]->term}} @lang('global.hour')</div>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <a href="{{"tech-condition"}}" class="btn btn-outline-info">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-secondary">
                                                    <i class="fas fa-undo"></i>
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

            $("#table1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                searching: true,
                language: lang
            });
        });

        function upload(el, url) {
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
