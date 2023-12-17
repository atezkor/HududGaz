<table id="table1" class="table table-bordered table-striped table-center">
    <thead>
        <tr>
            <th>@lang('global.index')</th>
            <th>@lang('global.proposition.number')</th>
            <th>@lang('global.proposition.stir')</th>
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
                <td>{{$model->individual->stir}}</td>
                <td>
                    <a href="{{route('district.proposition.show', ['proposition' => $model])}}" target="_blank">
                        @lang('global.proposition.show')
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
                    <a href="{{route('district.recommendation.create', ['proposition' => $model, 'type' => 'accept'])}}"
                       class="btn btn-outline-info" title="@lang('district.accept')">
                        <i class="fas fa-check"></i>
                    </a>
                    <a href="{{route('district.recommendation.create', ['proposition' => $model, 'type' => 'fail'])}}"
                       class="btn btn-outline-danger" title="@lang('district.cancel')">
                        <i class="fas fa-minus"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
