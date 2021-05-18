@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools mt-2">
                            <div class="input-group w-75 ml-auto">
                                <input type="search" id="search" class="form-control" placeholder="{{__('global.search')}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width: 1px;">@lang('global.index')</th>
                                    <th>@lang('table.statuses.col_description')</th>
                                    <th>@lang('table.statuses.col_transition')</th>
                                    <th>@lang('table.statuses.col_expired')</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$model->description}}</td>
                                    <td>{{$model->transitions}}</td>
                                    <td>{{$model->term}}</td>
                                    <td>
                                        <a href="{{route('admin.statuses.edit', ['status' => $model])}}"
                                           class="btn btn-info" title="@lang('global.btn_edit')">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
<script>
    $('#search').keyup(function() {
        let value = this.value.toLowerCase();
        $('tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>
@endsection
