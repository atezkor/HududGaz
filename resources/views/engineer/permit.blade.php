<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Ruxsatnoma</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 20mm 15mm 20mm 30mm;
            text-align: justify;
        }

        h2 {
            letter-spacing: 5px;
            margin-bottom: 30px;
            font-size: 18px;
        }

        p {
            letter-spacing: 20px;
            margin-bottom: 30px;
        }

        li {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            text-align: justify;
            vertical-align: top;
        }

        td {
            width: 50%
        }

        tr td:first-child {
            padding-right: 80px;
        }

        tr td:last-child {
            padding-left: 80px;
        }

        .text-center {
            text-align: center;
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

        .mb-30 {
            margin-bottom: 30px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2 class="text-center uppercase">Tabiiy gaz tarmog&#8216;iga ulash</h2>
    <p class="text-center uppercase">Ruxsatnomasi</p>
    <div class="text-center mb-30">
        <span>No {{$permit->id}}</span>
    </div>
    <div class="mb-30">
        <div class="f-l">{{extendedDate($permit->created_at)}}</div>
        <div class="f-r">{{$district}}</div>
        <div class="clear"></div>
    </div>
    <ol class="mb-30">
        <li class="mb-30">
            <span>Iste&#8217;molchi nomi:</span>
            <strong>{{$recommendation->address}} hududida joylashgan, {{$proposition->applicant->person_name}} qarashli bino va inshoatlarni gazlashtirish</strong>.<br>
            <div class="text-center">\ishoat manzili\</div>
        </li>
        <li class="mb-20">
            <span>Gaz tarmog&#8216;iga ulanuvchi asboblar turlari:</span>
            <span>ASD (i/q) - 1 dona</span><br>
            <div class="text-center">/turi, soni/</div>
        </li>
        <li>
            <span>Gaz o&#8216;lchagich asbobi:</span>
            <span>PRINT-G10 - 1 dona</span><br>
            <div class="text-center">/turi, soni/</div>
        </li>
        <li>
            <span>Tabiiy gazdan foydalanish uchun berilgan ruxsatnoma:</span>
            <span>&#8220;{{$organization->branch_name}}&#8221; GFTning <b class="lowercase">{{extendedDate(now(), true)}}dagi {{$recommendation->id}}/{{$proposition->id}}-sonli</b> xatiga asosan, 4256 m<sup>3</sup> yiliga.</span>
            <div class="text-center">/qaysi tashkilot va qancha hajmda/</div>
        </li>
        <li>
            <span>Zaxira yoqilg&#8216;ining turi va hajmi:</span>
            <span>o&#8216;tin va ko&#8216;mir ____ - ____</span>
        </li>
        <li>
            <span>Loyiha-peshhisob ishlagan tashkilot nomi:</span>
            <span><b>&#8220;{{$designer}}&#8221; MCHJ</b>.</span><br>
            <span>Pudratchi tashkilot nomi:</span>
            <span><b>&#8220;{{$installer}}&#8221; MCHJ</b>.</span>
        </li>
        <li>
            <span>Topshirilgan texnik hujjatni topshirilganligi haqida ma&#8217;lumot:</span>
            <span>_____</span><br>
            <span>2 nusxada ishlab chiqarish bo&#8216;limiga</span>
        </li>
        <li>
            <span>a/keltiruvchi gaz quvuri:</span> <strong>D-{{$recommendation->pipe1}} mm past bosimli</strong><br>
            <span>b/xovli gaz quvuri:</span> <strong>D-{{$recommendation->pipe2}} mm past bosimli</strong>.
        </li>
        <li>
            <span>Iste&#8217;molchi tabiiy gazdan foydalanish bo&#8216;yicha harakatdagi qonun va qoidalarga rioya qilishni o&#8216;z zimmasiga oladi: <b><i>Rahbar</i></b></span>.
            <br>
            <span>davlat yoki xususiy korxona rahbarining familiyasi, imzosi, muhri.</span>
        </li>
        <li>
            <span>O&#8216;zbekiston Respublikas Vazirlar Mahkamasining 22-sonli qaroriga asosan 100% to&#8216;lov amalga oshirilgandan keyin gaz tarmog&#8216;iga ulashga ruxsat qilinadi.</span>
        </li>
        <li>
            <span>Ruxsatnomada ko&#8216;rsatilgan gaz asboblarining sertifikati mavjudligi va texnik shartdan tashqari qo&#8216;shimcha o&#8216;rnatilgan gaz asboblari nazorati shahar/tuman filiali zimmasiga yuklatiladi.</span>
        </li>
    </ol>
    <table class="mb-30">
        <tr>
            <td>
                <span>&#8220;{{$organization->branch_name}}&#8221; gaz ta&#8217;minoti filiali bosh muhandisi</span>
            </td>
            <td>
                <span class="f-r">&#8220;{{$organization->branch_name}}&#8221; gaz ta&#8217;minoti filiali, texnik ishlab chiqarish bo&#8216;limi yetakchi muhandisi</span>
                <div class="clear"></div>
            </td>
        </tr>
        <tr>
            <td>
                ________ {{$organization->engineer}}
            </td>
            <td>
                ________ {{$organization->tech_section}}
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <span>&#8220;{{$organization->branch_name}}&#8221; gaz ta&#8217;minoti filiali yuridik shaxslarga tabiiy gaz yetkazib berishni nozara qilish bo&#8216;limi boshlig&#8216;i</span>
            </td>
            <td>
                <span class="f-r">&#8220;Xududgaz Metrologiya&#8221; filiali, Xorazm bo&#8216;limi boshlig&#8216;i</span>
                <div class="clear"></div>
            </td>
        </tr>
        <tr>
            <td>
                ________ {{$organization->legal_section}}
            </td>
            <td>
                ________ {{$organization->met_section}}
            </td>
        </tr>
    </table>
</body>
</html>
