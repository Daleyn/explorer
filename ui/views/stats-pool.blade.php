@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        chartWidth: 330,
        chartHeight: 240,
        pools: {!! json_encode($pools) !!},
        poolHistoryData: {
            poolPercentHistory: {!! json_encode($percent_history) !!},
            start: {!! json_encode($pool_history_start) !!},
            end: {!! json_encode($pool_history_end) !!}
        },
        bipData: {!! json_encode($bip_data) !!}
    };
</script>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('stats') }}">{{ trans('global.menu.stats') }}</a></li>
                    <li>{{ trans('global.page.stats-pool.PoolsDistribution') }}</li>
                </ol>
            </div>

            <div class="row">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.page.stats-pool.title') }}</div>
                    </div>
                    <div class="panel-body">
                        <div class="pool-panel pool-panel-share">

                        <div class="pool-panel-interval">
                            <ul class="clearfix">
                                <li {!! active_class($pool_mode, 'all') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'all']) }}">{{ trans('global.page.stats-pool.pool-mode.all') }}</a></li>
                                <li {!! active_class($pool_mode, 'year') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'year']) }}">{{ trans('global.page.stats-pool.pool-mode.1year') }}</a></li>
                                <li {!! active_class($pool_mode, 'month3') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'month3']) }}">{{ trans('global.page.stats-pool.pool-mode.3month') }}</a></li>
                                <li {!! active_class($pool_mode, 'month') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'month']) }}">{{ trans('global.page.stats-pool.pool-mode.1month') }}</a></li>
                                <li {!! active_class($pool_mode, 'week') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'week']) }}">{{ trans('global.page.stats-pool.pool-mode.1week') }}</a></li>
                                <li {!! active_class($pool_mode, 'day3') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'day3']) }}">{{ trans('global.page.stats-pool.pool-mode.3days') }}</a></li>
                                <li {!! active_class($pool_mode, 'day') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'day']) }}">{{ trans('global.page.stats-pool.pool-mode.24h') }}</a></li>
                            </ul>
                        </div>

                        <table class="table table-hover pool-panel-share-table">
                            <tr>
                                <th>&nbsp;</th>
                                <th class="pool-table-width" style="text-align: left;">{{ trans('global.page.stats-pool.pools') }}</th>
                                <th class="pool-table-width">{{ trans('global.page.stats-pool.percent-of-hashrate') }}</th>
                                @if(in_array($pool_mode, ['day', 'day3', 'week'] ))
                                    <th class="pool-table-width">{{ trans('global.page.stats-pool.HashRate') }}</th>
                                @endif
                                <th class="pool-table-width">{{ trans('global.page.stats-pool.blocks-solved') }}</th>
                                <th class="pool-table-width">{{ trans('global.page.stats-pool.percent-of-empty-blocks') }}</th>
                                <th class="pool-table-width">{{ trans('global.page.stats-pool.avg-block-size') }}  <br > (Bytes)</th>
{{--                                <th>{!! trans('global.page.stats-pool.avg-block-size-exclude-empty') !!} (Bytes)</th>--}}
                                <th class="pool-table-width">{{ trans('global.page.stats-pool.avg-tx-fees-per-block') }}  <br> (BTC)</th>
                                <th class="pool-table-width">{{ trans('global.page.stats-pool.fee_percentage_of_reward') }}</th>
                            </tr>
                            @foreach (array_slice($pool_info, 0, 100) as $k => $pool)
                                <tr>
                                    <td style="color: #aaa;">{{ $k }}</td>
                                    <td style="text-align: left;">
                                        @if ($pool['relayed_by'] == 'NETWORK')
                                            {{ $pool['relayed_by'] }}
                                        @else
                                            <a href="{{ route('pool', ['pool_name' => $pool['relayed_by']]) }}">{{ $pool['relayed_by'] }}</a>
                                        @endif
                                    </td>
                                    <td>{{ number_format($pool['hashrate'] * 100, 2) }} %</td>
                                    @if(in_array($pool_mode, ['day', 'day3', 'week'] ))
                                        <td>
                                            {!! number_unit_format($pool['hashrate'] * $hash_rate)['size'] !!}
                                            {!! number_unit_format($pool['hashrate'] * $hash_rate)['unit'] !!}H/s
                                        </td>
                                    @endif
                                    <td>{{ number_format($pool['block_count'], 0) }}</td>
                                    <td>{{ number_format($pool['empty_block_percent'] * 100, 2) }} %</td>
                                    <td>{{ number_format($pool['average_block_size'], 0) }}</td>
{{--                                    <td>{{ number_format($pool['average_block_size_exclude_empty'], 0) }}</td>--}}
                                    <td>{{ number_format($pool['average_fee'] / pow(10, 8), 8) }}</td>
                                    <td>{{ number_format($pool['fee_percentage_of_reward'] * 100, 2) }} %</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-left:0px;margin-right:0px;" id="pool-history">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.page.stats-pool.ShareTrend') }}</div>
                    </div>
                    <div class="panel-body">
                        <div class="pool-panel pool-panel-percentage">
                            <div class="pool-panel-percentage-chart">

                                <div class="pool-panel-interval">
                                    <ul class="clearfix">
                                        @foreach ($availableYears as $y)
                                        <li {!! active_class($percent_mode, $y) !!}><a href="{{ route('stats.pool', ['percent_mode' => $y]) }}#pool-history">{{ $y }}</a></li>
                                        @endforeach
                                        <li {!! active_class($percent_mode, 'latest') !!}><a href="{{ route('stats.pool', ['percent_mode' => 'latest']) }}#pool-history">{{ trans('global.page.stats-pool.percent-history.latest') }}</a></li>
                                    </ul>
                                </div>

                                <div class="pool-panel-percentage-chart-inner"></div>

                                @inlinescript
                                <script>
                                    $(function() {
                                        function formatX(v) {
                                            return moment.utc(globals.poolHistoryData.start, 'YYYYMMDD').add(v, 'months').format('YYYY/MM');
                                        }

                                        var opts = {
                                            chart: {
                                                type: 'area',
                                                height: 500
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            title: { text: null},
                                            xAxis: {
                                                type: 'category',
                                                labels: {
                                                    formatter: function() {
                                                        return formatX(this.value);
                                                    }
                                                }
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'Percent'
                                                },
                                                labels: {
                                                    formatter: function () {
                                                        return this.value + '%';
                                                    }
                                                },
                                            },
                                            tooltip: {
                                                useHTML: true,
                                                formatter: function() {
                                                    var ret = '<table><caption style="text-align: right">' + formatX(this.x) + '</caption>';
                                                    for (var i = 0, ii = this.points.length; i < ii; i++) {
                                                        ret += '<tr><td style="text-align: right; padding-right: 3px; font-weight: 700;">' + this.points[i].series.name + '</td><td style="text-align: right; padding-left: 3px;color: black">';
                                                        ret += this.points[i].y.toFixed(2) + '%</td></tr>';
                                                    }
                                                    ret += '</table>';
                                                    return ret;
                                                },
                                                crosshairs: [{
                                                    width: 1,
                                                    color: 'black',
                                                }],
                                                shared: true
                                            },
                                            plotOptions: {
                                                area: {
                                                    stacking: 'percent',
                                                    lineColor: '#ffffff',
                                                    lineWidth: 1,
                                                    marker: {
                                                        enabled: false,
                                                        states: {
                                                            hover: { enabled: false }
                                                        }
                                                    }
                                                }
                                            },
                                            legend: {
                                                align: 'right',
                                                verticalAlign: 'top',
                                                layout: 'vertical',
                                                itemMarginTop: 20
                                            },
                                            series: null
                                        };

                                        var series = [];
                                        Object.keys(globals.poolHistoryData.poolPercentHistory).forEach(function(k) {
                                            series.push({
                                                name: k,
                                                data: globals.poolHistoryData.poolPercentHistory[k].map(function(i) {
                                                    return i * 100;
                                                })
                                            });
                                        });

                                        $('.pool-panel-percentage-chart-inner').highcharts($.extend({}, opts, { series: series }));
                                    });
                                </script>
                                @endinlinescript
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
