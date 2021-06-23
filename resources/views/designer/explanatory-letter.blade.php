<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xat</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            text-align: justify;
        }

        @page {
            size: A4;
        }

        body {
            margin: 20mm 15mm 20mm 30mm;
        }

        table {
            width: 90%;
            margin-left: 5%;
            margin-right: 5%;
        }

        td:last-child {
            text-align: right;
        }

        ul {
            list-style: none;
        }

        .text-center {
            text-align: center;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="mb-10">
        <h3 class="text-center">Tushuntirish xati</h3>
    </div>
    <p>
        &emsp;{{$recommendation->address}}da joylashgan, {{$applicant->person_name}}ga qarashli {{$build_type}} binosini gazlashtirish uchun ishchi loyihani bajarishda quyidagi hujjat asosida bajariladi:
    </p>
    <div>
        <span>Buyurtmachi tomonidan berilgan arizaga asosan ishlab chiqildi.</span>
        <ul>
            <li>
                &emsp;&#8212; &#8220;{{$organization}}&#8221; ma&#8217;suliyati cheklangan jamiyati shahar va tuman gaz filiallari faoliyatini muofiqlashtirish boshqarmasi tomonidan {{formatDate($condition->created_at)}} kuni berilgan № {{$condition->id}}/{{$proposition->number}} sonli, gaz manbaiga ulash haqidagi texnik shart.
            </li>
            <li>
                &emsp;&#8212; shuningdek loyihalayotgan inshoat joyida ko&#8216;rib olingan ma&#8217;lumotlar.
            </li>
            <li>
                &emsp;&#8212; O&#8216;zbekiston Respublikasi viloyatlaridagi shahar va qishloq joylaridagi kommunal - maishiy va isitish uchun ishlatiladigan gaz iste&#8217;moli sarfini hisoblash haqidagi PM-1-93 yo&#8216;riqnomasi.
            </li>
        </ul>
    </div>
    <div>
        <span>Ishchi loyiha quyidagi me&#8217;yor talablariga asosan bajarildi:</span>
        <ul>
            <li>
                &emsp;&#8212; SHNQ 2.04.08-13 &#8220;Gaz ta&#8217;minoti. Loyiha normalari.&#8221;
            </li>
            <li>
                &emsp;&#8212; QMQ 3.05.02-96 &#8220;Gaz ta&#8217;minoti. Ishlarni tashkil yetish, ishlab chiqarish va ishni qa&#8217;bul qilish.&#8221;
            </li>
        </ul>
    </div>
    <p>
        O&#8216;zbekiston Respublikasi gaz xo&#8216;jaligi texnik xavfsizligi qoidalalari.
        Ushbu loyihada: {{$recommendation->address}}da joylashgan, {{$applicant->person_name}}ga qarashli {{$build_type}} binosini gazlashtirish nazarda tutilgan.
    </p>
    <p>
        <span>&emsp;Gazlashtirish manbai qilib D-{{$recommendation->pipe1}} mm bo&#8216;lgan past bosimli gaz quvuri qa&#8217;bul qilingan</span><br>
        <span>Gaz sarfini o&#8216;lchash uchun: 1 dona D12 elektron gaz hisoblash asbobi o&#8216;rnatildi.</span>
        <span>Gazlashtirish uchun: 1 dona isitish qazoni KSOB-16,5 va 1 dona kamparakli gaz plita PG-4 o&#8216;rnatilishi mo&#8216;ljallandi.</span>
    </p>
    <div>
        <span>Gaz asboblarining maksimal 1 yillik gaz sarfi quyidagicha:</span>
        <table>
            <tr>
                <td>KSOB-16.5</td>
                <td>1,7 nm<sup>3</sup>/soat</td>
            </tr>
            <tr>
                <td>PG-4</td>
                <td>1,2 nm<sup>3</sup>/soat</td>
            </tr>
        </table>
        <span>Shundan kelib chiqib umumiy mo&#8216;tadil bir soatlik gaz sarfi:</span>
        <table>
            <tr>
                <td>Q soat</td>
                <td>1,7 nm<sup>3</sup>/soat</td>
            </tr>
            <tr>
                <td>Q yil</td>
                <td>1,2 nm<sup>3</sup>/soat</td>
            </tr>
        </table>
    </div>
    <p>
        Gaz quvurining gidravlik hisobi SHNQ 2.04.08-13 da ko&#8216;rsatilgan formula va gaz quvurlari uchun tuzilgan jadvallar asosida bajariladi.
    </p>
    <p>Gaz quvurlarini qurulishi uchun quvurlar SHNK 2.04.08-13 ga asosan qa&#8217;bul qilindi.</p>
    <p>
        <span>Qurilishda qa&#8217;bul qilingan gaz quvurlarining qism detallari 5.905 - 15 namuna loyihasida me&#8217;yor bo&#8216;yicha tayyorlanishi kerak.</span>
        <span>Yer osti gaz quvurlari tuproqdan himoya qilish uchun loyihada quvur ustiga "eng kuchaytirilgan" maromdagi himoya qoplamasi yo&#8216;li bilan himoya vositasini bajarish nazarda tutilgan.</span>
        <span>Yer ustki gaz quvurlarini tashqi muhitni (atmosfera) ta&#8217;siridan zanglashdan, xomaki va 2 marta moyli bo&#8216;yoq bilan bo&#8216;yash orqali himoya qilindi.</span>
    </p>
    <p>Tashqi muhitni himoya qilishga yerni, suvni, atmosfera havosini, o&#8216;simliklar va boshqalarni muhofaza qilish kiradi.</p>
    <p>
        Gaz quvurini ishlatishda yer ustki qoplami atmosfera ifloslanishi, gaz quvurlarining nosoz ishlashi va buzilishdan, quvurni gaz bilan damlashdan,
        gaz quvurlarini ba&#8217;zi armaturalari bilan ulashini joyidagi zichligini ta&#8217;minlamaslikdan quvurlarni me&#8217;yoriy kapital ta&#8217;mirlashdan keyin,
        uzoq muddatga ishlatilishi natijasida chiqadigan chiqindilar sodir bo&#8216;ladi.
    </p>
    <p>Gaz asboblari bilan ishlovchi xodim, ma&#8217;sul kamandada tayinlanishi va unda maxsus o&#8216;qishda qatnashib imtihondan o&#8216;tganligi haqida guvohnoma bo&#8216;lishi kerak.</p>
    <p>
        <strong>Gazlashtirayotgan xonalarni shamollatish va mahsulotlarini chiqarib tashlash xavfsizlik talablari asosida me&#8217;yoriga muofiq bajarilsin.</strong>
    </p>
    <p>Gaz asboblari o&#8216;rnatilgan xonalarda ulardan foydalanish haqida yo&#8216;riqnomalar osib qo&#8216;yilishi kerak.</p>
    <p>
        Gaz quvurlarini qurish va gaz asboblarini o&#8216;rnatish gazga ulash hamda gaz berish ishi mutaxislashtirilgan qurilish tashkilotlari va
        xo&#8216;jaligi idoralari orqali bajarilishi kerak.
    </p>
    <div class="mt-20">
        <table>
            <tr>
                <td>Tuzuvchi</td>
                <td>Men</td>
            </tr>
        </table>
    </div>
</body>
</html>
