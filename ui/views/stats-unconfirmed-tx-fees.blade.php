@extends('layout')

@section('style_resource_inline')@parent
<style>

    .col-md-1 {
        width: 10%;
        padding-left: 10px;
        padding-right: 10px;
    }

    .col-md-2 {
        width: 20%;
        padding-left: 10px;
        padding-right: 10px;
    }

    .col-md-8 {
        width: 60%;
        padding-left: 10px;
        padding-right: 10px;
    }

    .row_right_padding {
        padding-right: 20px;
    }

    .title_style {
        font-family:MicrosoftYaHei;
        font-size:14px;
        color:#262626;
    }

    .unit_style {
        color: #aaa;
    }

    .range_style {
        font-size:14px;
        color:#262626;
        line-height:31px;
        text-align:right;
        font-weight: 500;
    }

    .time_level_block {
        width:16px; height: 16px; display:block; float:left;
    }

    .time_value_level_block {
        margin-left: 5px; margin-right: 30px; display: block; float: left; font-size: 12px; color: #888888;
    }

    .time_level_1 {background-color: #7ec1de; border: solid; border-width: 0 1px 0 0;}
    .time_level_2 {background-color: #73e37a; border: solid; border-width: 0 1px 0 0;}
    .time_level_3 {background-color: #fc8c8c; border: solid; border-width: 0 1px 0 0;}
    .time_level_4 {background-color: #6666ff; border: solid; border-width: 0 1px 0 0;}
    .time_level_5 {background-color: #ffcc66; border: solid; border-width: 0 1px 0 0;}
    .time_level_6 {background-color: #bad2db; border: solid; border-width: 0 1px 0 0;}

    .progress_modify {
        overflow: hidden;
        height: 30px;
        margin-bottom: 1px;
    }

    .row {
        line-height: 30px;
    }

    .row_select {
        margin-left: 0;
        margin-right: 0;
    }

    .row_select:hover {
        background-color: #f3f4f7;
    }

</style>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('stats') }}">{{ trans('global.menu.stats') }}</a></li>
                    <li> {{ trans('global.page.stats-unconfirmed-tx.title') }} </li>
                </ol>
            </div>

            <div class="row">
                <div class="panel panel-bm">

                    <div class="panel-body">
                        <div class="row" style="margin: 30px 0 30px 0;">
                            <div class="col-md-12 text-center" style="margin-bottom: 14px;">
                                <img src="/images/stats-unconfirmed-tx-fees@2x.png" style="width: 16px; height: 29px; margin-right: 10px;">

                                <span style="color: #262626; font-size: 16px; font-family:MicrosoftYaHei;">
                                    {{ trans('global.page.stats-unconfirmed-tx.best-transaction-fees') }}
                                </span>
                            </div>
                            <div class="col-md-12 text-center" style="font-size: 30px; color: #262626">
                                <b id="fees_recommended_sb"> {{ $fees_recommended['one_block_fee'] }} </b>
                                <span class="unit_style" style="font-size: 16px;">Satoshis/byte</span>
                                <span style="color: #aaa;">|</span>
                                <b id="fees_recommended_bk"> {{ number_format($fees_recommended['one_block_fee'] / pow(10, 5), 5) }} </b>
                                <span class="unit_style" style="font-size: 16px;">BTC/KB</span>
                            </div>
                        </div>

                        <hr style="margin-bottom: 5px;">

                        <div class="row text-center title_style" style="white-space: nowrap; margin-left: 0; margin-right: 0">
                            <div class="col-md-2">{{ trans('global.page.stats-unconfirmed-tx.fees') }}</div>
                            <div class="col-md-8">{{ trans('global.page.stats-unconfirmed-tx.distribution-of-tx-fees') }}</div>
                            <div class="col-md-1 text-right">{{ trans('global.page.stats-unconfirmed-tx.size') }}</div>
                            <div class="col-md-1 text-right row_right_padding">{{ trans('global.page.stats-unconfirmed-tx.size-count') }}</div>
                        </div>

                        <hr style="margin-top: 5px; margin-bottom: 0">

                        <div class="row text-right unit_style" style="margin-bottom: 10px; margin-left: 0; margin-right: 0">
                            <div class="col-md-1">BTC/KB</div>
                            <div class="col-md-1">Satoshis/Byte</div>
                            <div class="col-md-8"> </div>
                            <div class="col-md-1">Bytes</div>
                            <div class="col-md-1 row_right_padding">Bytes</div>
                        </div>


                            <div class="row row_select">
                                <div class="col-md-1 text-right range_style">
                                    >= 0.00090
                                </div>
                                <div class="col-md-1 text-right range_style">
                                    >= 90
                                </div>

                                <div class="col-md-8">
                                    <div class="progress_modify">
                                        <div class="progress-bar progress-bar-info time_level_1" style="width:
                                        {{ 80 * $tx_size_divide_max_size[0] * $tx_duration_time_rate[0][0] }}%">
                                        </div>
                                        <div class="progress-bar progress-bar-info time_level_2" style="width:
                                        {{ 80 * $tx_size_divide_max_size[0] * $tx_duration_time_rate[0][1] }}%">
                                        </div>
                                        <div class="progress-bar progress-bar-info time_level_3" style="width:
                                        {{ 80 * $tx_size_divide_max_size[0] * $tx_duration_time_rate[0][2] }}%">
                                        </div>
                                        <div class="progress-bar progress-bar-info time_level_4" style="width:
                                        {{ 80 * $tx_size_divide_max_size[0] * $tx_duration_time_rate[0][3] }}%">
                                        </div>
                                        <div class="progress-bar progress-bar-info time_level_5" style="width:
                                        {{ 80 * $tx_size_divide_max_size[0] * $tx_duration_time_rate[0][4] }}%">
                                        </div>
                                        <div class="progress-bar progress-bar-info time_level_6" style="width:
                                        {{ 80 * $tx_size_divide_max_size[0] * $tx_duration_time_rate[0][5] }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right range_style" id="tx_size_0">
                                    {{ number_format($tx_size[0]) }}
                                </div>
                                <div class="col-md-1 text-right range_style row_right_padding" id="tx_size_count_0">
                                    {{ number_format($tx_size_count[0]) }}
                                </div>
                            </div>

                        @foreach([90, 80, 70, 60, 50, 40, 30, 20, 10, 5] as $k => $v)
                        <div class="row row_select">
                            <div class="col-md-1 text-right range_style">
                               < {{ number_format($v / pow(10 , 5), 5) }}
                            </div>
                            <div class="col-md-1 text-right range_style">
                               < {{ $v }}
                            </div>
                            <div class="col-md-8">
                                <div class="progress_modify">
                                    <div class="progress-bar progress-bar-info time_level_1" style="width:
                                    {{ 80 * $tx_size_divide_max_size[$k + 1] * $tx_duration_time_rate[$k + 1][0] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_2" style="width:
                                    {{ 80 * $tx_size_divide_max_size[$k + 1] * $tx_duration_time_rate[$k + 1][1] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_3" style="width:
                                    {{ 80 * $tx_size_divide_max_size[$k + 1] * $tx_duration_time_rate[$k + 1][2] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_4" style="width:
                                    {{ 80 * $tx_size_divide_max_size[$k + 1] * $tx_duration_time_rate[$k + 1][3] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_5" style="width:
                                    {{ 80 * $tx_size_divide_max_size[$k + 1] * $tx_duration_time_rate[$k + 1][4] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_6" style="width:
                                    {{ 80 * $tx_size_divide_max_size[$k + 1] * $tx_duration_time_rate[$k + 1][5] }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 text-right range_style" id="tx_size_{{ $k + 1 }}">
                                {{ number_format($tx_size[$k + 1]) }}
                            </div>
                            <div class="col-md-1 text-right range_style row_right_padding" id="tx_size_count_{{ $k + 1 }}">
                                {{ number_format($tx_size_count[$k + 1]) }}
                            </div>
                        </div>
                        @endforeach

                        <div class="row row_select">
                            <div class="col-md-1 text-right range_style">
                                0
                            </div>
                            <div class="col-md-1 text-right range_style">
                                0
                            </div>
                            <div class="col-md-8">
                                <div class="progress_modify">
                                    <div class="progress-bar progress-bar-info time_level_1" style="width:
                                    {{ 80 * $tx_size_divide_max_size[11] * $tx_duration_time_rate[11][0] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_2" style="width:
                                    {{ 80 * $tx_size_divide_max_size[11] * $tx_duration_time_rate[11][1] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_3" style="width:
                                    {{ 80 * $tx_size_divide_max_size[11] * $tx_duration_time_rate[11][2] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_4" style="width:
                                    {{ 80 * $tx_size_divide_max_size[11] * $tx_duration_time_rate[11][3] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_5" style="width:
                                    {{ 80 * $tx_size_divide_max_size[11] * $tx_duration_time_rate[11][4] }}%">
                                    </div>
                                    <div class="progress-bar progress-bar-info time_level_6" style="width:
                                    {{ 80 * $tx_size_divide_max_size[11] * $tx_duration_time_rate[11][5] }}%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 text-right range_style" id="tx_size_11">
                                {{ number_format($tx_size[11]) }}
                            </div>
                            <div class="col-md-1 text-right range_style row_right_padding" id="tx_size_count_11">
                                {{ number_format($tx_size_count[11]) }}
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px; margin-bottom: 47px; line-height: 16px;">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <span class="time_level_block" style="background-color: #7ec1de; margin-left: 10px;"></span>
                                <span class="time_value_level_block"> < 10 min</span>

                                <span class="time_level_block" style="background-color: #73e37a"></span>
                                <span class="time_value_level_block"> < 30 min</span>

                                <span class="time_level_block" style="background-color: #fc8c8c"></span>
                                <span class="time_value_level_block"> < 1 hour</span>

                                <span class="time_level_block" style="background-color: #6666ff"></span>
                                <span class="time_value_level_block"> < 3 hour</span>

                                <span class="time_level_block" style="background-color: #ffcc66"></span>
                                <span class="time_value_level_block"> < 12 hour</span>

                                <span class="time_level_block" style="background-color: #bad2db"></span>
                                <span class="time_value_level_block"> >= 12 hour</span>
                            </div>
                            <div class="col-md-2" style="border:solid 0px red;"></div>
                        </div>
                        {{--<div class="btc-credit credit-fee" style="">BTC.COM</div>--}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-bm">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 text-center">{{ trans('global.page.stats-unconfirmed-tx.mempool-size-trend') }}</div>
                        </div>

                        <div>
                            <div id="mempool_size_trend" style="min-width: 300px; height: 400px; margin: 0 auto;"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @inlinescript
    <script>
        function numberFormat(number, decimals, decPoint, thousandsSep) {
            decimals = isNaN(decimals) ? 2 : Math.abs(decimals);
            decPoint = (decPoint === undefined) ? '.' : decPoint;
            thousandsSep = (thousandsSep === undefined) ? ',' : thousandsSep;

            var sign = number < 0 ? '-' : '';
            number = Math.abs(+number || 0);

            var intPart = parseInt(number.toFixed(decimals), 10) + '';
            var j = intPart.length > 3 ? intPart.length % 3 : 0;

            return sign + (j ? intPart.substr(0, j) + thousandsSep : '') + intPart.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + thousandsSep) + (decimals ? decPoint + Math.abs(number - intPart).toFixed(decimals).slice(2) : '');
        }

        function updateData() {
            $.get('/service/fees/distribution')
                .then(function(data) {
                    updateFeesRecommended(data.fees_recommended.one_block_fee);
                    updateSize(data.tx_size);
                    updateSizeCount(data.tx_size_count);
                    updateFeeDistribution(data.tx_size_divide_max_size, data.tx_duration_time_rate);
                    setTimeout('updateData()', 5000);
                });
        }

        function updateFeeDistribution(tx_size_divide_max_size, tx_duration_time_rate) {
            for (var loop = 1; loop < 7; loop++) {
                $('div.time_level_' + [loop]).each(function(index) {
                    var percent = tx_size_divide_max_size[index] * 80;
                    if (percent * tx_duration_time_rate[index][loop - 1] <= 0.16) {
                        $(this).css('display', 'none');
                    } else {
                        $(this).css('display', '');
                        $(this).css('width', percent * tx_duration_time_rate[index][loop - 1] + '%');
                    }
                });
            }
        }

        function updateSize(tx_size) {
            for (var i = 0; i < tx_size.length; i++) {
                $("#tx_size_" + i).html(numberFormat(tx_size[i], 0));
            }
        }

        function updateSizeCount(tx_size_count) {
            for (var i = 0; i < tx_size_count.length; i++) {
                $("#tx_size_count_" + i).html(numberFormat(tx_size_count[i], 0));
            }
        }

        function updateFeesRecommended(fee) {
            $("#fees_recommended_sb").html(fee);
            $("#fees_recommended_bk").html(fee / Math.pow(10, 5));
        }

        function getMempoolSize() {
            $.get('/service/stats/mempool')
                    .then(function(data) {
                        updateMempoolSize(data.data);
                        setTimeout('getMempoolSize()', 30000);
                    });
        }

        function updateMempoolSize(size) {
            $('#mempool_size_trend').highcharts().series[0].setData(size.map(function(el) {
                return [el[0] * 1000, el[1]];
            }));
        }

        $(function () {
            var opts = {
                credits: {
                    enabled: true,
                    text: 'BTC.COM',
                    href:'',
                    position: {
                        align: 'center',
                        verticalAlign: 'middle',
                    },
                    style:{
                        fontSize:'50px',
                        color:'#3c78c2',
                        opacity:'0.1',
                        fontWeight:'500',
                        letterSpacing:'-3px'
                    }
                },
                chart: {
                    height: 400,
                    zoomType: 'x'
                },
                title: { text: null },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        hour: '%H : %M',
                        day: '%Y-%m-%d',
                        month: '%Y-%m-%d',
                        year: '%Y-%m-%d'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function() {
                        return moment.utc(this.x).format('YYYY-MM-DD HH:mm') + ' -- ' + numberFormat(this.y, 0) + ' Bytes';
                    }
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },

                series: null
            };


            $('#mempool_size_trend').highcharts($.extend({}, opts, {
                yAxis: {
                    title: {
                        text: ''
                    },
                    min: 0
                },
                series: [{
                    type: 'area',
                    data: [],
                }]
            }));

        });


        updateData();
        getMempoolSize();

    </script>
    @endinlinescript

@endsection
