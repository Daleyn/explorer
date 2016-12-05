@extends('layout')

@section('script_resource_prepend')@parent
<script>
var globals = {
    chart1: {!! $diff_trend_line !!},
    chart2: {!! $diff_trend_log !!},
    trans: {!! json_encode($trans) !!}
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
                    <li>{{ trans('global.page.stats-diff.title') }}</li>
                </ol>
            </div>

            <div class="row diff">
                <div class="diff-summary">
                    <ul>
                        <li>
                            <dl>
                                <dt>{{ trans('global.page.stats-diff.hash-rate') }}</dt>
                                <dd>{!! number_unit_format($net_status['hash_rate'])['size'] !!} {!! number_unit_format($net_status['hash_rate'])['unit'] !!}H/s</dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.page.stats-diff.difficulty') }}</dt>
                                <dd><span class="text-muted">{{ number_format($net_status['difficulty']) }}</span> - {!! number_unit_format($net_status['difficulty'])['size'] !!} {!! number_unit_format($net_status['difficulty'])['unit'] !!}</dd>
                            </dl>
                        </li>
                    </ul>

                    <ul>
                        <li>
                            <dl>
                                <dt>{{ trans('global.page.stats-diff.estimated-next-difficulty') }}</dt>
                                <dd><span class="text-muted">{{ number_format($net_status['next_difficulty']) }}</span> -
                                @if($net_status['next_difficulty'] - $net_status['difficulty'] > 0)
                                    (+{{ number_format(($net_status['next_difficulty'] - $net_status['difficulty']) / $net_status['difficulty'] * 100, 2) }}%)
                                @else
                                    ({{ number_format(($net_status['next_difficulty'] - $net_status['difficulty']) / $net_status['difficulty'] * 100, 2) }}%)
                                @endif
                                    {!! number_unit_format($net_status['next_difficulty'])['size'] !!} {!! number_unit_format($net_status['next_difficulty'])['unit'] !!}</dd>
                            </dl>
                            <dl>
                                <dt>{{ trans('global.page.stats-diff.next-difficulty') }}</dt>
                                <dd> {{ floor(($net_status['adjust_time'] - time()) / 86400) }} {{ trans('global.common.day') }}
                                     {{floor(((($net_status['adjust_time'] - time()) / 86400) - floor(($net_status['adjust_time'] - time()) / 86400)) * 24) }} {{ trans('global.common.hour') }} </dd>
                            </dl>
                        </li>
                    </ul>
                </div>

                <div class="row diff-chart">
                    <div class="col-xs-6 diff-chart-1">
                        <div class="chart-container"></div>
                        <div class="diff-chart-title">{{ trans('global.page.stats-diff.chart-diff') }}</div>
                    </div>
                    <div class="col-xs-6 diff-chart-2">
                        <div class="chart-container"></div>
                        <div class="diff-chart-title">{{ trans('global.page.stats-diff.chart-diff-log') }}</div>
                    </div>
                </div>
                @inlinescript
                <script>
                    $(function () {
                        var opts = {
                            chart: {
                                height: 300,
                                zoomType: 'x'
                            },
                            credits: {
                                enabled: false
                            },
                            title: { text: null },
                            xAxis: {
                                type: 'datetime',
                                formatter: function() {
                                    return moment.utc(this.value).format('YYYY');
                                }
                            },
                            legend: {
                                enabled: false
                            },
                            tooltip: {
                                formatter: function() {
                                    return moment.utc(this.x).format('YYYY-MM-DD') + ': ' + this.y;
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

                        $('.diff-chart-1 .chart-container').highcharts($.extend({}, opts, {
                            yAxis: {
                                title: {
                                    text: globals.trans['chart-diff']
                                },
                                min: 0
                            },
                            series: [{
                                type: 'area',
                                data: globals.chart1.map(function(el) {
                                    return [el[0] * 1000, el[1]];
                                })
                            }]
                        }));

                        $('.diff-chart-2 .chart-container').highcharts($.extend({}, opts, {
                            yAxis: {
                                title: {
                                    text: globals.trans['chart-diff-log']
                                },
                                min: 0
                            },
                            series: [{
                                type: 'area',
                                data: globals.chart2.map(function(el) {
                                    return [el[0] * 1000, el[1]];
                                })
                            }]
                        }));
                    });
                </script>
                @endinlinescript

                <div class="diff-history">
                    <table class="table">
                        <tr>
                            <th>{{ trans('global.page.stats-diff.height') }}</th>
                            <th>{{ trans('global.page.stats-diff.block-time') }}</th>
                            <th>{{ trans('global.page.stats-diff.Difficulty') }}</th>
                            <th>{{ trans('global.page.stats-diff.change') }}</th>
                            <th>Bits</th>
                            <th>{{ trans('global.page.stats-diff.average-block') }}</th>
                            <th>{{ trans('global.page.stats-diff.average-hashrate') }}</th>
                        </tr>
                        @foreach($net_hash as $nh)
                        <tr>
                            <td><a href="{{ route('block.height', ['height' => $nh['height'] ]) }}">{{ number_format($nh['height'], 0) }}</a></td>
                            <td><span class="text-muted">{{ date('Y-m-d H:i:s', $nh['time']) }}</span></td>
                            <td>{{ number_format($nh['difficulty'], 0) }} - {!! number_unit_format($nh['difficulty'])['size'] !!} {!! number_unit_format($nh['difficulty'])['unit'] !!}</td>
                            @if($nh['change'] == 0)
                                <td>{{ $nh['change'] }} %</td>
                            @elseif($nh['change'] > 0)
                                <td style="color: green">+ {{ number_format($nh['change'], 2) }} %</td>
                            @else
                                <td style="color: red">- {{ number_format($nh['change'] * -1, 2) }} %</td>
                            @endif
                            <td class="diff-history-bits">{{ $nh['bits'] }}</td>
                            <td><span class="text-muted">{{ date('i', $nh['avgIntervalSinceLast']) }} {{ trans('global.common.minutes') }} {{ date('s', $nh['avgIntervalSinceLast']) }} {{ trans('global.common.seconds') }}</span></td>
                            <td>{!! number_unit_format($nh['netHashPerSecond'])['size'] !!} {!! number_unit_format($nh['netHashPerSecond'])['unit'] !!}H/s</td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="text-center">
                        <a download class="btn btn-primary btn-bm" href="{{ route('stats.diff.export') }}">{{ trans('global.page.stats-diff.export') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection