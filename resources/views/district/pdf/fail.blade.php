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

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        hr {
            border: 0;
            border-top: 1px solid #000000;
        }

        li {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .clear {
            clear: both;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
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
    </style>
</head>
<body>
    <div>
        <span class="f-l"># {{$model->id}}</span>
        <span class="f-r">{{formatDate($proposition->created_at)}}</span>
    </div>
    <div class="clear">
        <br><br>
    </div>
    <div class="text-right">
        <h4>
            <span>Davlat xizmlatlari agentligi</span><br>
            <span>Xorazm viloyati boshqarmasi</span><br>
            <span>{{$district}} markaziga</span>
        </h4>
    </div>

    <div class="mt-20">
        <div>
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&#8220;{{$organization->shareholder_name}}&#8221; AJ &#8220;{{$organization->branch_name}}&#8221;
                GTF &#8220;{{$organ->org_name}}&#8221; gaz ta&#8217;minot bo&#8216;limi,
                sizning <span class="lowercase">{{extendedDate($proposition->created_at, true)}}dagi</span> {{$proposition->number}}-sonli xatingizga javoban quyidagilarni ma&#8217;lum qiladi.</span>
        </div>
    </div>

    <p style="margin-top: 5px;">
        {!! $model->additional !!}
    </p>

    <table class="text-bold mt-20">
        <tr>
            <td>
                <span>&#8220;{{$organ->org_name}}&#8221; gaz ta&#8217;minoti</span><br>
                <span>bo&#8216;limi bosh muhandisi</span>
            </td>
            <td>
                <span class="f-r">{{$organ->lead_engineer}}</span>
            </td>
        </tr>
    </table>

    <table class="mt-20 text-bold" style="font-size: 12px">
        <tr>
            <td>
                <span>{{$organ->org_number}}, {{$organ->address}}.</span><br>
                <span>Telefonlar: {{$organ->phone}}, Faks: {{$organ->fax}}</span><br>
                <span>Elektron pochta: {{$organ->email}}</span>
            </td>
            <td>
                <div class="f-r">
                    <span>{{$organ->org_number}}, {{$organ->address_krill}}.</span><br>
                    <span>Telefonlar: {{$organ->phone}}, Faks: {{$organ->fax}}</span><br>
                    <span>Elektron pochta: {{$organ->email}}</span>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
