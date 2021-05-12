@extends('layout')
@section('title', getName())

@section('content')
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
{{--                    @include('components.alerts')--}}
                <div class="card">
                    <div class="card-header">
                        @can('add_users')
                            <a class="btn btn-success" href="{{route('admin.employees.create')}}" role="button">{{__('table.add')}}</a>
                        @endcan
                        <div class="card-tools mt-2">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" id="search" class="form-control float-right"
                                       placeholder="{{__('table.search')}}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{__('table.users.col_num')}}</th>
                                    <th>{{__('table.users.col_name')}}</th>
                                    <th>{{__('table.users.col_position')}}</th>
                                    <th>{{__('table.users.col_email')}}</th>
                                    <th>{{__('table.users.col_role')}}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $user)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->lastname}}</td>
                                    <td>{{$user->position}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <form method="post" id="form-{{$user->id}}" action="">
                                            @can('edit_users')
                                                <a class="btn btn-warning" title="{{__('table.montage.button_edit')}}"
                                                   href="#" role="button"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('delete_users')
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirm()" title="{{__('table.montage.button_delete')}}" class="btn btn-danger"
                                                        role="button"><i class="far fa-trash-alt"></i></button>
                                            @endcan
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
            let value = $(this).val();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            })
        })
     </script>
@endsection
