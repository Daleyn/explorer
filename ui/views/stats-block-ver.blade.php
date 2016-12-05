@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        block_ver_history: {!! json_encode($block_ver_history) !!}
    };
</script>
@endsection

@section('style_resource_inline')@parent
<style>
    .main_ver {background-color: #99E5FF; }
    .next_ver {background-color: #02C0FF; }
    .other_ver {background-color: #00CD79; }

    @if ($bip_mode != 109)
    .tbpool tr td{
        height: 9px;
        width: 18px;
        border:solid 0px black;
    }
    .tbpool tr td p{
        margin:0;
        height: 9px;
        width: 18px;
        border:solid 1px #ffffff;
    }
    @endif
</style>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('stats') }}">{{ trans('global.menu.stats') }}</a></li>
                    <li> {{ trans('global.page.stats-block-ver.title') }} </li>
                </ol>
            </div>

            <div class="row">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title">
                            @if ($bip_mode == '109')
                                {{ trans('global.page.stats-block-ver.latest-1000-block') }}
                            @else
                                {{ trans('global.page.stats-block-ver.latest-2016-block') }}
                            @endif
                        </div>
                    </div>
                    <div class="panel-body">

                        <div class="pool-panel-interval">
                            <ul class="clearfix">
                                <li {!! active_class($bip_mode, 'all') !!}><a href="{{ route('stats.block.ver', ['bip_mode' => 'all']) }}">ALL</a></li>
                                <li {!! active_class($bip_mode, '109') !!}><a href="{{ route('stats.block.ver', ['bip_mode' => '109']) }}">BIP109(Classic)</a></li>
                                <li {!! active_class($bip_mode, 'SegWit') !!}><a href="{{ route('stats.block.ver', ['bip_mode' => 'SegWit']) }}">SegWit</a></li>
                            </ul>
                        </div>

                        <div class="pool-panel pool-panel-percentage">
                            <div class="pool-panel-percentage-chart">

                                <table align="center" class="tbpool" >
                                    <?php $loop_count = 0; ?>
                                    <?php if ($bip_mode == '109') {
                                        $y = 19;
                                    } else {
                                        $y = 40;
                                        $block_ver = $block_ver_2016;
                                    }?>
                                    @foreach(range(0, $y) as $tab_y)
                                        <tr>
                                            @foreach(range(0, 49) as $tab_x)
                                                @if ($loop_count >= 2016)

                                                @elseif ($block_ver[$loop_count]['ver'] == env('BLOCK_MAIN_VER'))
                                                    <td>
                                                        <a href="{{ route('block.height', ['height' => $block_ver[$loop_count]['height']]) }}" target="_blank">
                                                            <p class="main_ver" data-toggle="tooltip" title="{{ sprintf('%s: V%s', number_format($latest_block - $loop_count, 0), env('BLOCK_MAIN_VER')) }}"></p>
                                                        </a>
                                                    </td>
                                                @elseif($bip_mode == 'all' && stristr($block_ver[$loop_count]['ver'], 'bip') !== false)
                                                    <td>
                                                        <a href="{{ route('block.height', ['height' => $block_ver[$loop_count]['height']]) }}" target="_blank">
                                                            <p class="other_ver" data-toggle="tooltip" title="{{ sprintf('%s: %s, BIP %s', number_format($latest_block - $loop_count, 0), $block_ver[$loop_count]['relayed_by'], implode(',', $block_ver[$loop_count]['bip_ver'])) }}"></p>
                                                        </a>
                                                    </td>
                                                @elseif($bip_mode == '109' && in_array(109, $block_ver[$loop_count]['bip_ver']))
                                                    <td>
                                                        <a href="{{ route('block.height', ['height' => $block_ver[$loop_count]['height']]) }}" target="_blank">
                                                            <p class="other_ver" data-toggle="tooltip" title="{{ sprintf('%s: %s, BIP109', number_format($latest_block - $loop_count, 0), $block_ver[$loop_count]['relayed_by']) }}"></p>
                                                        </a>
                                                    </td>
                                                @elseif($bip_mode == 'SegWit' && in_array('SegWit', $block_ver[$loop_count]['bip_ver']))
                                                    <td>
                                                        <a href="{{ route('block.height', ['height' => $block_ver[$loop_count]['height']]) }}" target="_blank">
                                                            <p class="other_ver" data-toggle="tooltip" title="{{ sprintf('%s: %s, SegWit', number_format($latest_block - $loop_count, 0), $block_ver[$loop_count]['relayed_by']) }}"></p>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td>
                                                        <a href="{{ route('block.height', ['height' => $block_ver[$loop_count]['height']]) }}" target="_blank">
                                                            <p class="main_ver" data-toggle="tooltip" title="{{ sprintf('%s: %s, Other', number_format($latest_block - $loop_count, 0), $block_ver[$loop_count]['relayed_by']) }}"></p>
                                                        </a>
                                                    </td>
                                                @endif
                                                <?php $loop_count ++; ?>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="poolver">
                            @if ($bip_mode == 'all')
                            <span class="main_ver" style="width: 16px;height: 16px;"></span>
                                <span style="margin-left: 5px; margin-right: 10px;">
                                Version {{ env('BLOCK_MAIN_VER') }}: {{ $block_ver_count_2016['main'] }} / 2016 =
                                {{ number_format($block_ver_count_2016['main']  / 2016 * 100, 2) }}%
                            </span>
                            @endif


                            <div>
                            <span class="other_ver" style="width: 16px;height: 16px;"></span>
                                @if ($bip_mode == 'all')
                                    <span style="margin-left: 5px;">
                                    BIP 9 : {{ $block_bip_dist['bip9']['count_2016'] }} / 2016 =
                                        {{ number_format($block_bip_dist['bip9']['2016'] * 100, 2)  }}%
                                    </span>
                                @elseif ($bip_mode == 109)
                                    <span style="margin-left: 5px;">
                                    BIP 109 : {{ $block_bip_dist['bip109']['count_1000'] }} / 1000 =
                                        {{ number_format($block_bip_dist['bip109']['1000'] * 100, 2)  }}%
                                    </span>
                                @else
                                    <span style="margin-left: 5px; display: block; height: 16px; line-height: 16px;">
                                    SegWit : {{ $block_bip_dist['SegWit']['count_2016'] }} / 2016 =
                                        {{ number_format($block_bip_dist['SegWit']['2016'] * 100, 2)  }}%
                                    </span>
                                    <span class="label label-info" style=" display: block; padding:5px; color:#fff; height: 17px; line-height:7px; font-size: 14px;">
                                        {{ env('BIP_68_STATUS') }}
                                    </span>
                                @endif
                            </div>

                        </div>

                        @if ($bip_mode == 'all')
                        <div align="center">
                            <table class="table table-bordered" style="width: 700px;">
                                <tr>
                                    <td class="text-center">
                                        @if (\App::getLocale() == 'zh-cn')
                                            <a target="_blank" href="https://news.btc.com/m/228?v=2">
                                                {{ trans('global.page.stats-block-ver.bip9-feature') }}
                                            </a>
                                        @else
                                            <a target="_blank" href="https://github.com/bitcoin/bips/blob/master/bip-0009.mediawiki">
                                                {{ trans('global.page.stats-block-ver.bip9-feature') }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ trans('global.page.stats-block-ver.desc') }}</td>
                                    <td colspan="2" class="text-center">{{ trans('global.page.stats-block-ver.percent-2016-block') }}</td>
                                    <td colspan="2" class="text-center">{{ trans('global.page.stats-block-ver.percent-1000-block') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center sw-popover">
                                        0x 20 00 00 02
                                    </td>
                                    <td>
                                        <a target="_blank" href="https://github.com/bitcoin/bips/blob/master/bip-0144.mediawiki"> SegWit </a>
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($block_bip_dist['SegWit']['2016'] * 100, 2) }} %
                                    </td>
                                    <td class="text-right">
                                        ( {{ $block_bip_dist['SegWit']['count_2016'] }} / 2016 )
                                    </td>
                                    <td colspan="2" class="text-center">
                                        -
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center bip109-popover">
                                        0x 30 00 00 00
                                    </td>
                                    <td>
                                        @if (\App::getLocale() == 'zh-cn')
                                            <a target="_blank" href="https://news.btc.com/m/228?v=2"> BIP109(Classic) </a>
                                        @else
                                            <a target="_blank" href="https://github.com/bitcoin/bips/blob/master/bip-0109.mediawiki"> BIP109(Classic) </a>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($block_bip_dist['bip109']['2016'] * 100, 2) }} %
                                    </td>
                                    <td class="text-right">
                                        ( {{ $block_bip_dist['bip109']['count_2016']}} / 2016 )
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($block_bip_dist['bip109']['1000'] * 100, 2) }} %
                                    </td>
                                    <td class="text-right">
                                        ( {{ $block_bip_dist['bip109']['count_1000']}} / 1000 )
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @endif

                        @inlinescript
                        <script>
                            $(function() {
                                $('.bip9-popover').popover({
                                    container: 'body',
                                    content: '00<span style="color: red">1</span>0 0000 0000 0000 0000 0000 0000 0000',
                                    html: true,
                                    placement: 'bottom',
                                    trigger: 'hover',
                                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content" style="width: 170px;"></div></div>'
                                });
                                $('.sw-popover').popover({
                                    container: 'body',
                                    content: '00<span style="color: red">1</span>0 0000 0000 0000 0000 0000 0000 00' +
                                    '<span style="color: red">1</span>0',
                                    html: true,
                                    placement: 'bottom',
                                    trigger: 'hover',
                                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content" style="width: 170px;"></div></div>'
                                });
                                $('.bip109-popover').popover({
                                    container: 'body',
                                    content: '00<span style="color: red">11</span> 0000 0000 0000 0000 0000 0000 0000',
                                    html: true,
                                    placement: 'bottom',
                                    trigger: 'hover',
                                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content" style="width: 170px;"></div></div>'
                                });
                            });
                        </script>
                        @endinlinescript
                    </div>
                </div>
            </div>

            <div class="row" id="versionTrend">
                <div class="panel panel-bm">
                    <div class="panel-heading">
                        <div class="panel-heading-title"> {{ trans('global.page.stats-block-ver.version-distribution') }} </div>
                    </div>
                    <div class="panel-body">
                        <div class="pool-panel pool-panel-percentage">
                            <div class="pool-panel-percentage-chart">

                                <div class="pool-panel-interval">
                                    <ul class="clearfix">
                                        <li {!! active_class($history_mode, 'half_year') !!}>
                                            <a href="{{ route('stats.block.ver', ['history_mode' => 'half_year']) }}#versionTrend">
                                                {{ trans('global.page.stats-block-ver.history-mode.180days') }}
                                            </a>
                                        </li>
                                        <li {!! active_class($history_mode, 'year3') !!}>
                                            <a href="{{ route('stats.block.ver', ['history_mode' => 'year3']) }}#versionTrend">
                                                {{ trans('global.page.stats-block-ver.history-mode.3years') }}
                                            </a>
                                        </li>
                                        <li {!! active_class($history_mode, 'all') !!}>
                                            <a href="{{ route('stats.block.ver', ['history_mode' => 'all']) }}#versionTrend">
                                                {{ trans('global.page.stats-block-ver.history-mode.all') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div id="block_version_history" class="block_version_history"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @inlinescript
    <script>
        $(function () { $("[data-toggle='tooltip']").tooltip(); });
        $(function () {
            function formatX(v) {
                v = v.toString();
                return v.substring(0, 4) + '/' + v.substring(4, 6) + '/' + v.substring(6, 8);
            }
            $('#block_version_history').highcharts({
                chart: {
                    type: 'area'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                credits: {
                    enabled:false
                },
                xAxis: {
                    categories: globals.block_ver_history['date'],
                    tickmarkPlacement: 'on',
                    title: {
                        enabled: false
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
                            lineWidth: 1,
                            lineColor: '#ffffff'
                        },
                        enabled: false,
                        states: {
                            hover: { enabled: false }
                        }
                    }
                },
                series: [
                @foreach (range(1, env('BLOCK_MAIN_VER')) as $key)
                    {
                        name: '{{ 'v' . $key }}',
                        data: globals.block_ver_history['{{ 'v' . $key }}']
                    },
                @endforeach
                {
                    name: 'other',
                    data: globals.block_ver_history['other']
                }]
            });
        });
    </script>
    @endinlinescript

@endsection
