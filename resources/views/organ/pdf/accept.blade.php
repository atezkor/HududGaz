<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Tavsiyanoma</title>
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
    </style>
</head>
<body>
    <div class="text-right">
        <h4>
            <span class="uppercase">&#8220;@lang('organ.pdf.confirmation')&#8221;</span><br>
            <span>&#8220;{{$organization->branch_name}}&#8221; @lang('organ.pdf.gft')</span><br>
            <span>&#8220;{{$organ->org_name}}&#8221; @lang('organ.pdf.section')</span><br>
            <span>@lang('organ.pdf.leader') ____ {{$organ->lead_engineer}}</span>
        </h4>
    </div>
    <div class="text-center section">
        <div class="uppercase">@lang('organ.pdf.recommendation')</div>
        <b># {{$model->id}}</b>
    </div>

    <div class="body mt-20">
        <div>
            <span class="f-l lowercase">{{extendedDate($model->created_at)}}</span>
            <strong class="f-r">{{$district}}</strong>
            <div class="clear"></div>
        </div>

        <div class="mt-20">
            <ol>
                <li>
                    <strong>@lang('organ.pdf.object_name')</strong>: {{$model->address}}@lang('organ.pdf.in_the') @lang('organ.pdf.civil')
                    <span>{{$applicant->full_name}}@lang('organ.pdf.to') @lang('organ.pdf.belong_to')</span>
                    @if($proposition->type == $proposition::LEGAL)
                        <span>&#8220;{{$activity->activity}}&#8221;</span>
                    @endif
                    <span class="lowercase">{{$build_type}} @lang('organ.pdf.build') @lang('organ.pdf.gas_connect')</span>
                </li>
                <li>
                    <strong>@lang('organ.pdf.near_address')</strong>: {{$model->access_point}}
                    <br><br>
                    <hr>
                    <div class="text-center">(@lang('organ.pdf.full_address'))</div>
                    <br>
                    <div class="text-center">
                        <span>@lang("organ.pdf.$model->pipeline"): {{$model->length}} @lang('organ.pdf.meter')</span>
                    </div>
                    <hr>
                    <div class="text-center">(@lang('organ.pdf.full_len'))</div>
                </li>
                <li>
                    <strong>@lang('organ.pdf.diameter_and_depth'):</strong>
                    {{$model->pipe1}} @lang('organ.pdf.millimeter'), {{$model->depth}} @lang('organ.pdf.meter')
                </li>
                <li>
                    <strong>@lang('organ.pdf.gas_pressure'):</strong>
                    <table>
                        <tr>
                            <td>@lang('organ.recommendation.pressure_win')
                                : {{$model->pressure_win}} @lang('organ.pdf.atm')</td>
                            <td>@lang('organ.recommendation.pressure_sum')
                                : {{$model->pressure_sum}} @lang('organ.pdf.atm')</td>
                        </tr>
                    </table>
                </li>
                <li class="text-left">
                    <strong>@lang('organ.pdf.pipe_capability'):</strong>
                    <span class="f-r">
                        <u>{{$model->capability}} </u>
                        <span>@lang('organ.pdf.meter')<sup>3</sup>/@lang('organ.pdf.second') @lang('organ.pdf.year')</span>
                    </span>
                    <div class="clear"></div>
                    <table class="text-right">
                        <tr>
                            <td class="text-center"><strong>@lang('organ.pdf.pipe_real_capacity'):</strong></td>
                            <td><u>{{$model->capability}}</u> @lang('organ.pdf.meter')
                                <sup>3</sup>/@lang('organ.pdf.second') @lang('organ.pdf.year')</td>
                        </tr>
                    </table>
                </li>
                <li class="text-left">
                    <strong>@lang('organ.pdf.grc'):</strong> <span class="f-r">{{$model->grc}}-GRS</span>
                    <div class="clear"></div>
                    <table class="text-right">
                        <tr>
                            <td class="text-center"><strong>@lang('organ.pdf.pipe_real_capacity'):</strong></td>
                            <td>{{$model->grc}}-GRS</td>
                        </tr>
                    </table>
                </li>
                <li>
                    <strong>@lang('organ.pdf.gas_network') </strong>
                    <span>{{$model->gas_network}}</span>
                    <span class="lowercase">@lang("organ.recommendation.$model->pipe_type")</span>
                    <span>@lang('organ.pdf.noname')</span>
                </li>
                <li>
                    <strong>@lang('organ.pdf.gas_consume'):</strong>
                    {{$model->consumption}} @lang('organ.pdf.meter')<sup>3</sup>.
                </li>
            </ol>
            {!! $model->additional !!}
            <ol start="12">
                <li>
                    <span><b>@lang('organ.pdf.installed_equipments')</b>:</span>
                    @foreach ($equipments as $equipment)
                        <span>{{$equipment->number}} ta</span>
                        <span>{{$equipment->type}}</span>
                        <span class="lowercase">{{$equipment->equipment}}</span>
                        <span>@if($equipment->note){{' ' . $equipment->note}}@endif</span>@if($loop->last){{'.'}}@else{{','}}@endif
                    @endforeach
                    <div class="text-center">
                        @lang('organ.pdf.type')
                    </div>
                </li>
            </ol>
        </div>

        <div class="text-center uppercase my-15">
            <strong style="font-size: 14px;">@lang('organ.pdf.note')</strong>
        </div>

        <div class="text-bold">
            <div>
                <span>&#8220;{{$organization->branch_name}}&#8221; @lang('organ.pdf.gft')</span><br>
            </div>
            <div>
                <span
                    class="f-l">&#8220;{{$organ->org_name}}&#8221; @lang('organ.pdf.sec') @lang('organ.pdf.engineer'):</span>
                <span class="f-r">{{$organ->section_leader}}</span>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>
