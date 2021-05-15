@extends('layout')
@section('title', getName())
@section('link')
<link rel="stylesheet" href="{{'/css/datatable/datatables.bootstrap4.min.css'}}">
<link rel="stylesheet" href="{{'/css/datatable/responsive.bootstrap4.min.css'}}">
<link rel="stylesheet" href="{{'/css/datatable/buttons.bootstrap4.min.css'}}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#individual"
                                           data-toggle="tab">{{__('technic.propositions.individual')}}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#legal_entity"
                                           data-toggle="tab">{{__('technic.propositions.legal')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col">
                                <a href="{{route('propositions.create')}}" class="btn btn-info float-md-right">
                                    {{__('technic.propositions.btn_add')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="individual" class="tab-pane active">
                                <table id="table1" class="table table-bordered table-striped">
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

                            <div id="legal_entity" class="tap-pane">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
@section('javascript')
<script src="{{'/js/jquery.min.js'}}"></script>
<script src="{{'/js/bootstrap.bundle.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.jquery.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.bootstrap4.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.responsive.min.js'}}"></script>
<script src="{{'/js/datatable/datatables.buttons.min.js'}}"></script>
<script>
    $(function () {
        $("#table1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": true,
            "searching": true
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection
