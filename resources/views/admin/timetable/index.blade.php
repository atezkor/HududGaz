@extends('layout')
@section('title', getName())

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-11">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a href="#holiday" class="nav-link active" data-toggle="tab">
                                                @lang('admin.timetable.holiday_days')
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#extra-work" class="nav-link" data-toggle="tab">
                                                @lang('admin.timetable.extra_work_days')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('admin.timetables.create')}}" class="btn btn-info">
                                        @lang('admin.timetable.create')
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <div class="tab-content">
                                <div id="holiday" class="tab-pane active">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.timetable.name')</th>
                                                <th>@lang('admin.timetable.start')</th>
                                                <th>@lang('admin.timetable.end')</th>
                                                <th style="width: 1px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($holidays as $model)
                                                <tr>
                                                    <td>{{$model->name}}</td>
                                                    <td>{{$model->start}}</td>
                                                    <td>{{$model->end}}</td>
                                                    <td>
                                                        <form
                                                            action="{{route('admin.timetables.destroy', $model->id)}}"
                                                            method="post">
                                                            {{ csrf_field() }}
                                                            @method('DELETE')
                                                            <a href="{{route('admin.timetables.edit', $model->id)}}"
                                                               class="btn btn-info"
                                                               title="@lang('global.btn_edit')">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                    onclick="remove(this)"
                                                                    class="btn btn-danger"
                                                                    title="@lang('global.btn_del')">
                                                                <i class="fas fa-calendar-times"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div id="extra-work" class="tab-pane fade">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>@lang('admin.timetable.name')</th>
                                                <th>@lang('admin.timetable.start')</th>
                                                <th>@lang('admin.timetable.end')</th>
                                                <th style="width: 1px"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($extraDays as $model)
                                                <tr>
                                                    <td>{{$model->name}}</td>
                                                    <td>{{$model->start}}</td>
                                                    <td>{{$model->end}}</td>
                                                    <td>
                                                        <form
                                                            action="{{route('admin.timetables.destroy', $model->id)}}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="{{route('admin.timetables.edit', $model->id)}}"
                                                               class="btn btn-info"
                                                               title="@lang('global.btn_edit')">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" onclick="remove(this)"
                                                                    class="btn btn-danger"
                                                                    title="@lang('global.btn_del')">
                                                                <i class="fas fa-calendar-times"></i>
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
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
    <script>
        function remove(btn) {
            Swal.fire({
                title: '{{__('admin.timetable.alert_title')}}',
                text: "{{__('admin.alert_text')}}",
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
    </script>
@endsection
