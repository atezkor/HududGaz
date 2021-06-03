<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>PDF</title>
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

    </div>
</div>
</body>
</html>
