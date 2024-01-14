<table id="table-legal" class="table table-bordered table-striped table-center">
    <thead>
        <tr>
            <th>@lang('global.index')</th>
            <th>@lang('global.proposition.number')</th>
            <th>@lang('global.proposition.legal_tin')</th>
            <th>@lang('global.proposition.name')</th>
            <th>@lang('global.proposition.date')</th>
            <th>@lang('global.proposition.limit')</th>
            <th>@lang('global.proposition.action')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($propositions as $model)
            <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$model->number}}</td>
                <td>{{$model->applicant->tin_pin}}</td>
                <td>
                    <a href="{{route('organ.proposition.show', ['proposition' => $model])}}" target="_blank">
                        @lang('global.proposition.show')
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
                    <a href="{{route('organ.statement.create', ['proposition' => $model, 'type' => $model::ACCEPT])}}"
                       class="btn btn-outline-info" title="@lang('organ.accept')">
                        <i class="fas fa-check"></i>
                    </a>
                    <a href="{{route('organ.statement.create', ['proposition' => $model, 'type' => $model::REJECT])}}"
                       class="btn btn-outline-danger" title="@lang('organ.reject')">
                        <i class="fas fa-reply"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
