<table id="individual-table" class="table table-bordered table-striped table-center">
    <thead>
        <tr>
            <th>@lang('global.index')</th>
            <th>@lang('global.proposition.number')</th>
            <th>@lang('global.proposition.tin')</th>
            <th>@lang('technic.organ')</th>
            <th>@lang('global.proposition.name')</th>
            <th>@lang('global.proposition.date')</th>
            <th>@lang('global.proposition.limit')</th>
            <th>@lang('global.proposition.action')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($applications as $model)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$model->number}}</td>
                <td>{{$model->applicant->tin_pin}}</td>
                <td>{{$model->organ->name}}</td>
                <td>
                    <a href="{{route('propositions.show', $model->id)}}" target="_blank">
                        <span>@lang('global.proposition.show')</span>
                    </a>
                </td>
                <td>{{$model->created_at->format('d.m.Y H:i')}}</td>
                <td>
                    <div class="progress progress-xs">
                        <div
                            class="{{$model->progressColor($model->percent($limit($model->status)))}}"
                            style="width: {{$model->percent($limit($model->status))}}%">
                        </div>
                    </div>
                    <div class="text-center">{{$limit($model->status)}} @lang('global.hour')</div>
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
