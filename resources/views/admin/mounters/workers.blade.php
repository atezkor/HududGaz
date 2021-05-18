@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.fitters.create', ['firm' => $firm_id]) }}" class="btn btn-info">{{__('table.mounters.btn_add')}}</a>
                        <div class="card-tools mt-2">
                            <div class="input-group w-75 ml-auto">
                                <input type="search" id="search" class="form-control"
                                       placeholder="{{__('global.search')}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>{{__('table.mounters.col_org')}}</th>
                                    <th>{{__('table.mounters.col_name')}}</th>
                                    <th>{{__('table.mounters.col_function')}}</th>
                                    <th>{{__('table.mounters.col_experience')}}</th>
                                    <th>{{__('table.mounters.col_period_activity')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $model)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$model->firm->short_name}}</td>
                                    <td>{{$model->first_name[0]}}. {{$model->last_name}}</td>
                                    <td>{{$model->specialization}}</td>
                                    <td>{{$model->experience}}</td>
                                    <td>{{formatDate($model->date_created)}} - {{formatDate($model->date_expired)}}</td>
                                    <td>
                                        <form action="{{route('admin.fitters.delete', ['fitter' => $model])}}"
                                              method="post" id="form-{{$model->id}}" class="form">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{route('admin.fitters.edit', ['fitter' => $model])}}" class="btn btn-warning"
                                               title="{{__('global.btn_edit')}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" onclick="remove('form-{{$model->id}}')" class="btn btn-danger"
                                                    title="{{__('global.btn_del')}}" role="button">
                                                <i class="far fa-trash-alt"></i>
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
<script>
$('#search').keyup(function() {
    let value = this.value.toLowerCase();
    $('tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

function remove(form) {
    Swal.fire({
        title: '{{__('table.mounters.alert_message')}}',
        text: "{{__('table.general.alert_text')}}",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dd3333',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{__('global.btn_yes')}}',
        cancelButtonText: '{{__('global.btn_no')}}'
    }).then((result) => {
        if (result.isConfirmed) {
            $(`#${form}`).submit()
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
