<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Texnik shart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4;
        }

        body {
            text-align: justify;
            padding: 20mm 15mm 20mm 30mm;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
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

        .mt-20 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div>
        <span class="f-l"># {{$proposition->id}}</span>
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

    <div class="text-center mt-20">
        <strong class="uppercase">Ma&#8217;lumotnoma</strong>
    </div>

    <div class="mt-20">
        <span>&nbsp;&nbsp;&nbsp;&nbsp;&#8220;{{$organization->branch_name}}&#8221; gaz ta&#8217;minoti filiali,
            sizning <span class="lowercase">{{extendedDate($proposition->created_at, true)}}dagi</span>
            <b>{{$proposition->number}}</b>-sonli arizangizga javoban quyidagilarni ma&#8217;lum qiladi.
        </span>
    </div>

    <div class="mt-20">
        {!! $reference !!}
    </div>

    <table class="mt-20 text-bold">
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
                <span>{{$organization->reg_num}}, {{$organization->address}}.</span><br>
                <span>Telefonlar: {{$organization->phone}}, Faks: {{$organization->fax}}</span><br>
                <span>E-pochta: {{$organization->email}}</span>
            </td>
            <td class="text-left">
                <div class="f-r">
                    <span>{{$organization->reg_num}}, {{$organization->address}}.</span><br>
                    <span>Telefonlar: {{$organization->phone}}, Faks: {{$organization->fax}}</span><br>
                    <span>E-pochta: {{$organization->email}}</span>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
