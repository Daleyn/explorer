
<div>
    <div class="tx-item">
        <table class="table">
            <tr class="tx-item-summary">
                <td></td>
                <td>
                    {{ trans('global.page.address-tx-stats.date-range') }} <input type="text" name="daterange" class="stats-range" value="" />
                </td>
            </tr>

            <tr class="txio">
                <td>
                    <div class="row">
                        <div class="col-md-5">
                            <div id="tx_dist" style="min-width: 250px; height: 250px; margin: 0 auto;"></div>
                        </div>
                        <div class="col-md-7">
                            <table align="center">
                                <tr>
                                    <td> {{ trans('global.page.address-tx-stats.received') }} </td>
                                    <td><div class="addressArrow leftArrow"></div></td>
                                    <td class="text-right" id="received_tx_count"> 0 </td>
                                </tr>
                                <tr>
                                    <td> {{ trans('global.page.address-tx-stats.sent') }} </td>
                                    <td><div class="addressArrow rightArrow"></div></td>
                                    <td class="text-right" id="sent_tx_count"> 0 </td>
                                </tr>

                                <tr>
                                    <td colspan="3"><hr></td>
                                </tr>

                                <tr>
                                    <td> {{ trans('global.page.address-tx-stats.total-tx') }} </td>
                                    <td></td>
                                    <td class="text-right" id="total_tx_count"> 0 </td>
                                </tr>

                                <tr>
                                    <td> {{ trans('global.page.address-tx-stats.average-tx') }} </td>
                                    <td></td>
                                    <td class="text-right" id="average_tx"> 0 </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-6">

                            <span>{{ trans('global.page.address-tx-stats.net-change') }}</span> <br> <span id="net_change"></span> BTC
                            <div id="balance_change" style="min-width: 250px; height: 90px; margin: 0 auto; margin-left: -10px;"></div>

                        </div>
                        <div class="col-md-6">
                            <span>{{ trans('global.page.address-tx-stats.largest') }}</span> <br> <span id="largest_tx"></span> BTC
                            <div>
                                <a class="addressArrow doubleArrow" id="largest_tx_link" href=""></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <span>{{ trans('global.page.address-tx-stats.received') }}</span> <br> <span id="received_sum"></span> BTC
                            <div id="addr_received" style="min-width: 250px; height: 90px; margin: 0 auto;margin-left: -10px; "></div>
                        </div>
                        <div class="col-md-6">
                            <span>{{ trans('global.page.address-tx-stats.sent') }}</span> <br> <span id="sent_sum"></span> BTC
                            <div id="addr_sent" style="min-width: 250px; height: 90px; margin: 0 auto; margin-left: -10px;"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

@inlinescript
<script>
    /**
     * format number by adding thousands separaters and significant digits while rounding
     */
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

    $(function() {
        // 默认 显示最近一个月的交易统计
        function initAddrStats() {
            getAddressStatsData(moment().subtract(1, 'year').format('YYYYMMDD'), moment().format('YYYYMMDD'));
            $('input[name="daterange"]').data('daterangepicker').setStartDate(moment().subtract(1, 'year').format('YYYY-MM-DD'));
            $('input[name="daterange"]').data('daterangepicker').setEndDate(moment().format('YYYY-MM-DD'));
        }
        setTimeout(initAddrStats, 1000);

        $('input[name="daterange"]').daterangepicker({
            "opens": "left",
            "alwaysShowCalendars": true,

            "ranges": {
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.Today") }}': [moment(), moment()],
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.Yesterday") }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.Last-7-Days") }}': [moment().subtract(6, 'days'), moment()],
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.Last-30-Days") }}': [moment().subtract(29, 'days'), moment()],
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.This-Month") }}': [moment().startOf('month'), moment().endOf('month')],
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.Last-Month") }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                '{{ trans("global.page.address-tx-stats.date-range-trans.ranges.Last-Year") }}': [moment().subtract(1, 'year'), moment()]
            },

            "locale": {
                "format": "YYYY-MM-DD",
                "separator": "  ",
                "applyLabel": '{{ trans("global.page.address-tx-stats.date-range-trans.locale.applyLabel") }}',
                "cancelLabel": '{{ trans("global.page.address-tx-stats.date-range-trans.locale.cancelLabel") }}',
                "fromLabel": '{{ trans("global.page.address-tx-stats.date-range-trans.locale.fromLabel") }}',
                "toLabel": '{{ trans("global.page.address-tx-stats.date-range-trans.locale.toLabel") }}',
                "customRangeLabel": '{{ trans("global.page.address-tx-stats.date-range-trans.locale.customRangeLabel") }}',
                "daysOfWeek": [
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.Su") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.Mo") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.Tu") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.We") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.Th") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.Fr") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.daysOfWeek.Sa") }}'
                ],
                "monthNames": [
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.January") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.February") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.March") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.April") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.May") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.June") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.July") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.August") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.September") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.October") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.November") }}',
                    '{{ trans("global.page.address-tx-stats.date-range-trans.monthNames.December") }}'
                ],
                "firstDay": 1
            }
        });

        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            getAddressStatsData(picker.startDate.format('YYYYMMDD'), picker.endDate.format('YYYYMMDD'));
        });


        function getAddressStatsData(start, end) {
            $.get('/service/addressTxStats?address=' + globals.address +
                '&start=' + start + '&end=' + end)
                    .then(function(addrData) {
                        if (addrData.error_no == 0) {
                            paddingAddressStatsData(addrData.data);
                        }
                    });
        }

        function paddingAddressStatsData(addrStats) {
            var tx_dist_data = JSON.parse(addrStats.tx_dist);
            var tx_dist_chart = $('#tx_dist').highcharts();
            var balance_change_data = JSON.parse(addrStats.balance_change);
            var addr_sent_data = JSON.parse(addrStats.addr_sent);
            var addr_received_data = JSON.parse(addrStats.addr_received);
            var total_tx_count = addrStats.addr_received_count + addrStats.addr_sent_count;

            $('#received_tx_count').html(addrStats.addr_received_count);
            $('#received_sum').html(numberFormat(addrStats.addr_received_sum / 1e8, 8));
            $('#sent_tx_count').html(addrStats.addr_sent_count);
            $('#sent_sum').html(numberFormat(addrStats.addr_sent_sum / 1e8, 8));
            $('#total_tx_count').html(total_tx_count);
            $('#average_tx').html(numberFormat((addrStats.addr_received_sum + addrStats.addr_sent_sum) / 1e8 / total_tx_count, 8) + ' BTC');

            $('#net_change').html(numberFormat(addrStats.net_change / 1e8, 8));
            $('#largest_tx').html(numberFormat(addrStats.largest_tx / 1e8, 8));
            $('#largest_tx_link').html(addrStats.largest_tx_hash);
            $('#largest_tx_link').attr('href', addrStats.largest_tx_hash);


            tx_dist_chart.series[0].setData(tx_dist_data);

            $('#balance_change').highcharts().series[0].setData(balance_change_data.map(function(el) {
                return [el[0] * 1000, el[1] / Math.pow(10,8) ];
            }));

            $('#addr_sent').highcharts().series[0].setData(addr_sent_data.map(function(el) {
                return [el[0] * 1000, el[1] / Math.pow(10,8) ];
            }));

            $('#addr_received').highcharts().series[0].setData(addr_received_data.map(function(el) {
                return [el[0] * 1000, el[1] / Math.pow(10,8) ];
            }));
        }


        $('#tx_dist').highcharts({

            credits: {
                enabled: false // 去除 highcharts 水印
            },
            colors: ['#66bb44', '#d75c33'],
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    innerSize: '70%', // 饼图内部空心占比
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "{{ trans('global.page.address-tx-stats.percent') }}",
                colorByPoint: true,
                data: [{
                    name: "{{ trans('global.page.address-tx-stats.received') }}",
                    y: 0
                }, {
                    name: "{{ trans('global.page.address-tx-stats.sent') }}",
                    y: 0
                }]
            }]
        });



        var opts = {
            credits: {
                enabled: false
            },
            chart: {
                zoomType: 'x'
            },
            title: { text: null },
            xAxis: {
                type: 'datetime',
                labels: {
                    enabled: false
                },
                gridLineWidth: 0,
//                lineColor:'#fff',
                tickLength: 0,
                formatter: function() {
                    return moment.utc(this.value).format('YYYY');
                }
            },
            yAxis: {
                title: { text: '' },
                labels: {
                    enabled: false
                },
                gridLineColor:'#fff'
            },
            legend: {
                enabled: false
            },
            tooltip: {
                formatter: function() {
                    return moment.utc(this.x).format('YYYY-MM-DD') + ': ' + this.y + ' BTC';
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


        var data = [];

        $('#balance_change').highcharts($.extend({}, opts, {
            series: [{
                type: 'area',
                softThreshold: true,  // 设置 y轴最小值从0开始
                data: data.map(function(el) {
                    return [el[0] * 1000, el[1] / Math.pow(10,8) ];
                })
            }]
        }));

        $('#addr_received').highcharts($.extend({}, opts, {
            series: [{
                type: 'area',
                softThreshold: true,  // 设置 y轴最小值从0开始
                data: data.map(function(el) {
                    return [el[0] * 1000, el[1] / Math.pow(10,8) ];
                })
            }]
        }));

        $('#addr_sent').highcharts($.extend({}, opts, {
            series: [{
                type: 'area',
                softThreshold: true,  // 设置 y轴最小值从0开始
                data: data.map(function(el) {
                    return [el[0] * 1000, el[1] / Math.pow(10,8) ];
                })
            }]
        }));

    });
</script>
@endinlinescript