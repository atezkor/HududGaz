@extends('layout')
@section('title', __('menu.districts'))

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('admin.regions.create')}}" class="btn btn-info">{{__('table.districts.btn_new')}}</a>
                            <div class="card-tools mt-2">
                                <div class="input-group input-group-sm" style="width: 150px; font-size: 14px;">
                                    <input type="text" id="search" class="form-control float-right"
                                           placeholder="{{__('table.search')}}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <small><i class="fas fa-search"></i></small>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>{{__('table.districts.col_num')}}</th>
                                        <th>{{__('table.districts.col_name')}}</th>
                                        <th>{{__('table.districts.col_engineer')}}</th>
                                        <th>{{__('table.general.col_email')}}</th>
                                        <th>{{__('table.districts.col_phone')}}</th>
                                        <th>{{__('table.districts.col_address')}}</th>
                                        <th>{{__('table.general.fax')}}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$model->org_number}}</td>
                                        <td>{{$model->org_name}}</td>
                                        <td>{{$model->lead_engineer}}</td>
                                        <td>{{$model->email}}</td>
                                        <td>{{$model->phone}}</td>
                                        <td>{{$model->address}}</td>
                                        <td>{{$model->fax}}</td>
                                        <td>
                                            <form action="{{route('admin.regions.delete', ['region' => $model])}}"
                                                  method="post" id="form-{{$model->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{route('admin.regions.edit', ['region' => $model])}}" class="btn btn-warning"
                                                   title="{{__('table.btn_edit')}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" onclick="remove('form-{{$model->id}}')" class="btn btn-danger"
                                                        title="{{__('table.btn_del')}}" role="button">
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
    $('#search').keyup(function () {
        let value = this.value.toLowerCase();
        $('tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        })
    });

    function remove(form) {
        Swal.fire({
            title: '{{__('table.districts.alert_message')}}',
            text: "{{__('table.general.alert_text')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{__('table.btn_yes')}}',
            cancelButtonText: '{{__('table.btn_no')}}'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#${form}`).submit()
                Swal.fire({
                    title: '{{__('table.del_process')}}',
                    icon: 'success',
                    showConfirmButton: false,
                })
            }
        })
    }
</script>
@endsection
