<table id="table1" class="table table-bordered table-striped table-center">
    <thead>
        <tr>
            <th>@lang('global.index')</th>
            <th>@lang('global.proposition.number')</th>
            <th>@lang('global.proposition.stir')</th>
            <th>@lang('technic.organ')</th>
            <th>@lang('global.proposition.name')</th>
            <th>@lang('global.proposition.date')</th>
            <th>@lang('global.proposition.limit')</th>
            <th>@lang('global.proposition.action')</th>
        </tr>
    </thead>
    <tbody>
        @php($limit = limit(3))
        @foreach($applications as $model)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$model->number}}</td>
                <td>{{$model->individual->stir}}</td>
                <td>{{$model->organ}}</td>
                <td>
                    <a href="{{route('propositions.show', $model->id)}}" target="_blank">
                        <span>@lang('global.proposition.show')</span>
                    </a>
                </td>
                <td>{{$model->created_at}}</td>
                <td>
                    <div class="progress progress-xs">
                        <div class="{{$model->progressColor($model->percent($model->limit($limit)))}}"
                             style="width: {{$model->percent($model->limit($limit))}}%">
                        </div>
                    </div>
                    <div class="text-center">{{$model->limit($limit)}} @lang('global.hour')</div>
                </td>
                <td>
                    <form action="{{route('propositions.destroy', $model->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="{{route('propositions.edit', $model->id)}}"
                           class="btn btn-outline-info"
                           title="@lang('global.btn_edit')">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" onclick="remove(this)" class="btn btn-outline-danger"
                                title="@lang('global.btn_del')">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
