<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>PDF</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        @page {
            size: A4;
        }

        body {
            padding: 20mm 15mm 20mm 30mm;
            text-align: justify;
            line-height: 1.3;
        }

        .section {
            margin-top: 50px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .my-15 {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .lowercase {
            text-transform: lowercase;
        }

        .f-l {
            float: left;
        }

        .f-r {
            float: right;
        }

        .clear {
            clear: both;
        }

        table {
            width: 100%;
        }

        hr {
            border: 0;
            border-top: 1px solid #000000;
        }

        li {
            margin-top: 8px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="text-right">
        <h4>
            <span class="uppercase">&#8220;@lang('district.pdf.confirmation')&#8221;</span><br>
            <span>&#8220;{{$organization->branch_name}}&#8221; @lang('district.pdf.gft')</span><br>
            <span>&#8220;{{$organ->org_name}}&#8221; @lang('district.pdf.section')</span><br>
            <span>@lang('district.pdf.leader') ____ {{$organ->lead_engineer}}</span>
        </h4>
    </div>
    <div class="text-center section">
        <div class="uppercase">@lang('district.pdf.recommendation')</div>
        <b># {{$model->id}}</b>
    </div>

    <div class="body mt-20">
        <div>
            <span class="f-l lowercase">{{dateFull($model->created_at)}}</span>
            <strong class="f-r">{{$district}}</strong>
            <div class="clear"></div>
        </div>

        <div class="mt-20">
            <ol>
                <li>
                    <strong>@lang('district.pdf.object_name')</strong>: {{$model->address}}@lang('district.pdf.in_the') @lang('district.pdf.civil')
                    {{$consumer->person_name}}@lang('district.pdf.to') @lang('district.pdf.belong_to') {{$build_type}}
                    @lang('district.pdf.gas_connect')
                </li>
                <li>
                    <strong>@lang('district.pdf.near_address')</strong>: {{$model->access_point}}
                    <br><br><hr>
                    <div class="text-center">(@lang('district.pdf.full_address'))</div>
                    <br>
                    <div class="text-center">
                        <span>@lang("district.pdf.$model->pipeline"): {{$model->length}} @lang('district.pdf.meter')</span>
                    </div>
                    <hr>
                    <div class="text-center">(@lang('district.pdf.full_len'))</div>
                </li>
                <li>
                    <strong>@lang('district.pdf.diameter_and_depth'):</strong>
                    {{$model->pipe1}} @lang('district.pdf.millimeter'), {{$model->depth}} @lang('district.pdf.meter')
                </li>
                <li>
                    <strong>@lang('district.pdf.gas_pressure'):</strong>
                    <table>
                        <tr>
                            <td>@lang('district.recommendation.pressure_win'): {{$model->pressure_win}} @lang('district.pdf.atm')</td>
                            <td>@lang('district.recommendation.pressure_sum'): {{$model->pressure_sum}} @lang('district.pdf.atm')</td>
                        </tr>
                    </table>
                </li>
                <li class="text-left">
                    <strong>@lang('district.pdf.pipe_capability'):</strong>
                    <span class="f-r">
                        <u>{{$model->capability}} </u>
                        <span>@lang('district.pdf.meter')<sup>3</sup>/@lang('district.pdf.second') @lang('district.pdf.year')</span>
                    </span>
                    <div class="clear"></div>
                    <table class="text-right">
                        <tr>
                            <td class="text-center"><strong>@lang('district.pdf.pipe_real_capacity'):</strong></td>
                            <td><u>{{$model->capability}}</u> @lang('district.pdf.meter')<sup>3</sup>/@lang('district.pdf.second') @lang('district.pdf.year')</td>
                        </tr>
                    </table>
                </li>
                <li class="text-left">
                    <strong>@lang('district.pdf.grc'):</strong> <span class="f-r">{{$model->grc}}</span>
                    <div class="clear"></div>
                    <table class="text-right">
                        <tr>
                            <td class="text-center"><strong>@lang('district.pdf.pipe_real_capacity'):</strong></td>
                            <td>{{$model->grc}}</td>
                        </tr>
                    </table>
                </li>
                <li>
                    <strong>@lang('district.pdf.gas_network') </strong>
                    <span>{{$model->gas_network}}</span>
                    <span>@lang('district.pdf.noname')</span>
                </li>
                <li>
                    <strong>@lang('district.pdf.gas_consume'):</strong>
                    {{$model->consumption}} @lang('district.pdf.meter')<sup>3</sup>.
                </li>
            </ol>
            {!! $model->additional !!}
            <ol start="12">
                <li>
                    <span><b>@lang('district.pdf.installed_equipments')</b>:</span>
                    @foreach ($equipments as $equipment)
                    <span>{{$equipment['number']}} ta</span>
                    <span>{{$equipment['type']}}</span>
                    <span class="lowercase">{{$equipment['equipment']}}</span>
                    <span>{{$equipment['note']}}</span>@if($loop->last){{'.'}}@else{{','}}@endif
                    @endforeach
                    <div class="text-center">
                        @lang('district.pdf.type')
                    </div>
                </li>
            </ol>
        </div>

        <div class="text-center uppercase my-15">
            <strong style="font-size: 14px;">@lang('district.pdf.note')</strong>
        </div>

        <div class="text-bold">
            <div>
                <span>&#8220;{{$organization->branch_name}}&#8221; @lang('district.pdf.gft')</span><br>
            </div>
            <div>
                <span class="f-l">&#8220;{{$organ->org_name}}&#8221; @lang('district.pdf.sec') @lang('district.pdf.engineer'):</span>
                <span class="f-r">{{$organ->section_leader}}</span>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>
