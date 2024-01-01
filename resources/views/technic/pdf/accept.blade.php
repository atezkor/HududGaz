<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>PDF</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        @page {
            size: A4;
        }

        body {
            padding: 15mm 15mm 10mm 30mm;
            text-align: justify;
            line-height: 1.3;
            font-size: 12px;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: top;
        }

        td:first-child {
            width: 50%;
            text-align: justify;
        }

        td:last-child {
            text-align: right;
            width: 30%;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .f-l {
            float: left;
        }

       .uppercase {
           text-transform: uppercase;
       }

       .lowercase {
           text-transform: lowercase;
       }

       .clear {
           clear: both;
       }

       .mt-10 {
           margin-top: 10px;
       }
    </style>
</head>
<body>
    <div class="f-l">
        <img src="data:image/svg+xml;base64, {{base64_encode($qrcode)}}" width="60px" alt="QR">
    </div>
    <div class="text-right text-bold">
        <div>Davlat xizmatlari markazi</div>
        <div>Xorazm viloyati boshqarmasi</div>
        <div>Yangiariq tuman markazi</div>
    </div>
    <div class="clear"></div>
    <div class="text-center mt-10">
        <div>Sizning <span class="lowercase">{{extendedDate($proposition->created_at, true)}}</span>dagi <span class="text-bold">{{$proposition->id}}</span>-sonli talabnomangizga javoban:</div>
        <div>Tabiiy gaz bilan gazlashtirish loyihasini ishlab chiqish va gazlashtirishga</div>
        <div style="margin: 5px 0">
            <strong class="uppercase">Texnik shart</strong> <u>No {{$id}}</u> {{formatDate(now())}}
        </div>
    </div>
    <div class="conditions">
        <div>
            @include('technic.tech-conditions.above')
        </div>
        <div>
            {!! $data !!}
        </div>
    </div>
    <p><br></p>
    <table class="text-bold">
        <tr>
            <td>
                <span>&#8220;{{$organization->branch_name}}&#8221; gaz ta&#8217;minoti filiali</span><br>
                <span>bosh muhandisi</span>
            </td>
            <td>_____</td>
            <td>{{$organization->engineer}}</td>
        </tr>
        <tr>
            <td>
                <span>Tabiiy gaz tarmoqlarini kompleks ekspluatatsiya</span><br>
                <span>qilinishini nazorat qilish bot&#8216;limi boshlig&#8216;i</span>
            </td>
            <td>_____</td>
            <td>{{$organization->exploitation_section}}</td>
        </tr>
    </table>
    <table class="text-bold">
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
