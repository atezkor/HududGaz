@extends('layout')
@section('title', getName())
@section('link')
    <link rel="stylesheet" href="{{'/css/director.css'}}">
@endsection

@section('content')
    <div class="container-fluid pt-5">
        <ul class="sphere-list">
            <li>
                <div>
                    <div class="left-part">
                        <img alt="*" src="{{'/img/propositions.svg'}}">
                        <span class="service-count" style="color: #dd924f">0</span>
                    </div>

                    <div class="right-part">
                        <span class="sphere-title">@lang('global.navbar.today')</span>
                        <span class="service-name">Bugun kelib tushgan arizalar</span>
                    </div>

                    <span class="clearfix"></span>
                </div>
            </li>

            <li>
                <div>
                    <div class="left-part">
                        <img alt="*" src="{{'/img/propositions.svg'}}">
                        <span class="service-count" style="color: #00c492">0</span>
                    </div>

                    <div class="right-part">
                        <span class="sphere-title">@lang('global.navbar.process')</span>
                        <span class="service-name">Tuman idoralariga yuborilgan arizalar</span>
                    </div>

                    <span class="clearfix"></span>
                </div>
            </li>

            <li>
                <div>
                    <div class="left-part">
                        <img alt="*" src="{{'/img/propositions.svg'}}">
                        <span class="service-count text-danger">0</span>
                    </div>

                    <div class="right-part">
                        <span class="sphere-title">@lang('global.navbar.late')</span>
                        <span class="service-name">O&#8216;z muddatidan kechikgan arizalar</span>
                    </div>

                    <span class="clearfix"></span>
                </div>
            </li>

            <li>
                <div>
                    <div class="left-part">
                        <img alt="*" src="{{'/img/propositions.svg'}}">
                        <span class="service-count" style="color: #8ec483">0</span>
                    </div>

                    <div class="right-part">
                        <span class="sphere-title">@lang('global.navbar.year')</span>
                        <span class="service-name">Yil mobaynida kelib tushgan arizalar</span>
                    </div>

                    <span class="clearfix"></span>
                </div>
            </li>
        </ul>
        <div class="clear"></div>
        <div class="row mt-5">
            <div class="col-12 pl-4">
                <div class="pie-block">
                    <div class="pie-title"><b>Kelib tushgan arizalar grafigi</b></div>
                    <div id="speedChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{'/js/chart/chart.min.js'}}"></script>
    <script src="{{'/js/chart/high-charts.js'}}"></script>
    <script>
        $(function() {
            let counts = $('.service-count');
            $('#navbar span').each((i, e) => {
                counts[i].innerText = e.innerText;
            });
        });

        Highcharts.chart('speedChart', {
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            yAxis: {
                gridLineColor: '#D3D3D3',
                plotLines: [{
                    color: '#D3D3D3'
                }],
                title: {
                    text: ''
                }
            },
            xAxis: {
                categories: {
                    "1":"yan",
                    "2":"fev",
                    "3":"mar",
                    "4":"apr",
                    "5":"may",
                    "6":"iyun",
                    "7":"iyul",
                    "8":"avg",
                    "9":"sen",
                    "10":"okt",
                    "11":"noy",
                    "12":"dek"
                },
                gridLineColor: '#D3D3D3',
                gridLineWidth: '1',
                plotLines: [{
                    color: '#D3D3D3'
                }],
                title: {
                    text: ''
                },
                lineWidth: 0,
                tickWidth: 0,
                tickInterval: 1
            },


            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 1
                }
            },


            tooltip: {
                shared: true,
                pointFormat: '<span style="color:{point.color}">●</span><b>{point.y}</b>'
            },

            series: [{
                name: 'Arizlar',
                data: [@foreach($models as $model)
                {{$model}},
                @endforeach],
                color: '#7ECE80',
                marker: {
                    lineColor: '#7ECE80',
                    lineWidth: 5
                }
            }]
        });
    </script>
@endsection
