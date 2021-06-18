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
            padding: 20mm 15mm 20mm 30mm;
            text-align: justify;
            line-height: 1.3;
            font-size: 12px;
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

        table {
            width: 100%;
            vertical-align: text-top;
        }

        table td {
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
    <div class="text-center">
        <div>Sizning <span class="lowercase">{{dateFull($proposition->created_at, true)}}</span>dagi <span class="text-bold">{{$proposition->id}}</span>-sonli talabnomangizga javoban:</div>
        <div>Tabiiy gaz bilan gazlashtirish loyihasini ishlab chiqish va gazlashtirishga</div>
        <div style="margin: 5px 0">
            <strong class="uppercase">Texnik shart</strong> No 1 {{formatDate(now())}}
        </div>
    </div>
    <div class="conditions">
        <div>
            @include('technic.control.above')
        </div>
        <div>
            {!! $data !!}
        </div>
    </div>
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
    <table>
        <tr>
            <td></td>
        </tr>
    </table>
</body>
</html>
