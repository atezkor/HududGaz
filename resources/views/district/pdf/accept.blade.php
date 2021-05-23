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
            box-sizing: border-box;
        }

        body {
            padding: 20mm 15mm 20mm 30mm;
            text-align: justify;
        }

        .body {
            line-height: 1.3;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .section {
            margin-top: 50px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .uppercase {
            text-transform: uppercase;
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
            margin-bottom: 2px;
        }
    </style>
</head>
<body>
    <div class="text-right">
        <h4>
            <span class="uppercase">&#8220;@lang('district.pdf.confirmation')&#8221;</span><br>
            <span>&#8220;{{$organ->org_name}}&#8221; @lang('district.pdf.section')</span><br>
            <span>@lang('district.pdf.engineer') {{$organ->lead_engineer}}</span>
        </h4>
    </div>
    <div class="text-center section">
        <div class="uppercase">@lang('district.pdf.recommendation')</div>
        <strong>№ {{$proposition->number}}</strong>
    </div>

    <div class="body mt-20">
        <div>
            <span class="f-l">{{formatDate($model->created_at)}} - @lang('district.pdf.year')</span>
            <strong class="f-r">{{$district}}</strong>
            <div class="clear"></div>
        </div>

        <div class="mt-20">
            <ol>
                <li>
                    <strong>@lang('district.pdf.object_name')</strong>: {{$model->address}}@lang('district.pdf.in_the')
                    {{$consumer->full_name}}@lang('district.pdf.to') @lang('district.pdf.belong_to') {{buildType()[$proposition->build_type]}}
                    @lang('district.pdf.gas_connect')
                </li>
                <li>
                    <strong>@lang('district.pdf.near_address')</strong>: {{$model->access_point}}
                    <br><br><hr>
                    <div class="text-center">(@lang('district.pdf.full_address'))</div>
                    <br>
                    <div>
                        @lang('district.pdf.under_len'): {{$model->under_len}} @lang('district.pdf.meter'),
                        @lang('district.pdf.above_len'): {{$model->above_len}} @lang('district.pdf.meter')
                    </div>
                    <hr>
                    <div class="text-center">(@lang('district.pdf.full_len'))</div>
                </li>
                <li>
                    <strong>@lang('district.pdf.diameter_and_depth'):</strong>
                    {{$model->diameter}}, {{$model->depth}} @lang('district.pdf.meter')
                </li>
                <li>
                    <strong>@lang('district.pdf.gas_pressure'):</strong>
                    <table>
                        <tr>
                            <td>@lang('district.recommendation.pressure_win'): {{$model->pressure_win}}</td>
                            <td>@lang('district.recommendation.pressure_sum'): {{$model->pressure_sum}}</td>
                        </tr>
                    </table>
                </li>
                <li>
                    <strong>@lang('district.pdf.pipe_capability'):</strong>
                        <u>{{$model->capability}} </u>@lang('district.pdf.meter')<sup>3</sup>/@lang('district.pdf.santi')<sup>3</sup> @lang('district.pdf.year') <br>
                    <span>@lang('district.pdf.pipe_real_capacity'):</span>
                        <u>{{$model->real_capacity}}</u> @lang('district.pdf.meter')<sup>3</sup>/@lang('district.pdf.santi')<sup>3</sup> @lang('district.pdf.year')
                </li>
                <li>
                    <span>@lang('district.pdf.grc'):</span> {{$model->grc}}
                </li>
                <li>
                    <span>@lang('district.pdf.gas_network'):</span>
                </li>
                <li>
                    <span>@lang('district.pdf.gas_consume'):</span>
                    {{$model->consumption}} @lang('district.pdf.meter')<sup>3</sup>/@lang('district.pdf.santi')<sup>3</sup>
                </li>
                <li>
                    <span>@lang('district.pdf.purpose_for_use'):</span>
                </li>
                <li></li>
            </ol>
        </div>
    </div>
</body>
</html>
