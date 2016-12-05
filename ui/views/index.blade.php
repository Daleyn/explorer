@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        chartWidth: 220,
        chartHeight: 220,
        socketEndpoint: {!! json_encode(env('REALTIME_ENDPOINT')) !!},
        pools: {!! json_encode($pools) !!},
        blocks: {!! json_encode($blocks) !!},
        tx: {!! json_encode($tx) !!},
        lang: {!! json_encode($lang) !!},
        poolclasses: {!! json_encode($pool_classes) !!},
        bipData: {!! json_encode($bip_data) !!}
    };
</script>
@endsection

@script('/components/index/realtime.js')

@section('body')
    <div class="main-body">
        <div class="container">

            {{--<div class="row">--}}
                {{--<div class="well well-default">--}}
                    {{--{!! trans('global.page.index.block-ver-warning', ['block' => $block_ver_4, 'percent' => 100 * number_format($block_ver_4 / 1000, 4)]) !!}--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="row">
                <div class="panel panel-bm indexBlockList">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.page.index.latestblocks') }}</div>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tr id="append">
                                <th class="text-right">{{ trans('global.block-table-header.height') }}</th>
                                <th class="text-center">{{ trans('global.block-table-header.relayed-by') }}</th>
                                <th class="text-right">{{ trans('global.block-table-header.size') }}(B)</th>
                                <th class="text-center">{{ trans('global.block-table-header.rewords') }}</th>
                                <th class="text-right">{{ trans('global.block-table-header.block-time') }}</th>
                                <th class="text-center">{{ trans('global.block-table-header.block-hash') }}</th>
                                <th class="text-right">
                                    <a href="{{ route('stats.block.ver') }}">
                                        {{ trans('global.block-table-header.block-version') }}
                                    </a>
                                </th>
                            </tr>
                            @foreach ($blocks as $blk)
                                <tr data-id="{{ $blk['height'] }}">
                                    <td class="text-right"><a href="{{ route('block.height', ['height' => $blk['height']]) }}">{{ number_format($blk['height'], 0) }}</a></td>
                                    <td class="text-left">
                                        {{-- 标签前后必须紧挨着 --}}
                                        <i class="icon-pool icon-pool-{{ pool2classname(pool_name_format($blk)['pool_name']) }}"></i><div class="cell-poolname">{!! pool_name_format($blk)['html'] !!}</div>
                                    </td>
                                    <td class="text-right">{{ number_format($blk['size']) }}</td>
                                    <td class="text-center indexBlockList-blockAward">{!! btc_format($blk['reward_block'] + $blk['reward_fees']) !!}</td>
                                    <td class="text-right indexBlockList-blockTimestamp" data-timestamp="{{ $blk['timestamp'] }}">{!! relative_time_format($blk['timestamp']) !!}</td>
                                    <td class="text-center indexBlockList-blockhash"><a href="{{ route('search.general', ['q' => $blk['hash']]) }}">{{ $blk['hash'] }}</a></td>
                                    <td class="text-right">{!! block_version_format($blk['version']) !!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6" style="padding-left: 0; padding-right: 10px;">
                    <div class="panel panel-bm indexPoolShare">
                        <div class="panel-heading">
                            <div class="panel-heading-corner">
                                <a href="{{ route('stats.pool') }}">{{ trans('global.page.index.more') }}<i class="icon-arrow-right"></i></a>
                            </div>
                            <div class="panel-heading-title">{{ trans('global.page.index.Pools-Distribution') }}</div>
                        </div>
                        <div class="panel-body">
                            <div class="pool-panel pool-panel-share">
                                <div class="pool-panel-share-chart">
                                    <div class="pool-panel-share-chart-inner">
                                        @script('/components/pool-chart/pie.js')
                                    </div>
                                </div>

                                <div class="pool-panel-rank">
                                    <table class="table">
                                        <tr>
                                            <th class="pool-panel-rank-num text-right">&nbsp;</th>
                                            <th class="pool-panel-rank-pool">{{ trans('global.page.index.pools') }}</th>
                                            <th class="pool-panel-rank-share text-right">{{ trans('global.page.index.distribution') }}</th>
                                            <th class="pool-panel-rank-phs text-right">{{ trans('global.page.index.hash-rate') }}</th>
                                        </tr>
                                        @foreach (array_slice($pools, 0, 10) as $j => $p)
                                            <tr data-pool-id="{{ $p['id'] or 0  }}">
                                                <td class="pool-panel-rank-num text-right">{{ $j + 1 }}</td>
                                                <td class="pool-panel-rank-pool"><div class="cell-poolname"><a href="{{ route('pool', ['pool_name' => $p['name'] ]) }}">{{ $p['name'] }}</a></div></td>
                                                <td class="pool-panel-rank-share text-right">{{ number_format($p['p'] * 100, 2) }} %</td>
                                                <td class="pool-panel-rank-phs text-right">{{ number_format($p['hash_share'] / pow(10, 15), 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6" style="padding-right: 0; padding-left: 10px;">
                    <div class="panel panel-bm indexNetworkStats">
                        <div class="panel-heading">
                            <div class="panel-heading-corner">
                                <a href="{{ route('stats.diff') }}">{{ trans('global.page.index.more') }}<i class="icon-arrow-right"></i></a>
                            </div>
                            <div class="panel-heading-title">{{ trans('global.page.index.net-status') }}</div>
                        </div>
                        <div class="panel-body">
                            <ul>
                                <li>
                                    <dl>
                                        <dt>{{ trans('global.page.stats-diff.hash-rate') }}</dt>
                                        <dd>{!! number_unit_format($net_status['hash_rate'])['size'] !!} {!! number_unit_format($net_status['hash_rate'])['unit'] !!}H/s</dd>
                                    </dl>
                                </li>
                                <li>
                                    <dl>
                                        <dt>
                                            <a href="{{ route('stats.diff') }}">
                                                {{ trans('global.page.stats-diff.difficulty') }}
                                            </a>
                                        </dt>
                                        <dd><span class="text-muted">{{ number_format($net_status['difficulty']) }} - </span>{!! number_unit_format($net_status['difficulty'])['size'] !!} {!! number_unit_format($net_status['difficulty'])['unit'] !!}</dd>
                                    </dl>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <dl>
                                        <dt>{{ trans('global.page.stats-diff.estimated-next-difficulty') }}</dt>
                                        <dd>@if($net_status['next_difficulty'] - $net_status['difficulty'] > 0)
                                                (+{{ number_format(($net_status['next_difficulty'] - $net_status['difficulty']) / $net_status['difficulty'] * 100, 2) }}%)
                                            @else
                                                ({{ number_format(($net_status['next_difficulty'] - $net_status['difficulty']) / $net_status['difficulty'] * 100, 2) }}%)
                                            @endif
                                            {!! number_unit_format($net_status['next_difficulty'])['size'] !!} {!! number_unit_format($net_status['next_difficulty'])['unit'] !!}</dd>
                                    </dl>
                                </li>
                                <li>
                                    <dl>
                                        <dt>{{ trans('global.page.stats-diff.next-difficulty') }}</dt>
                                        <dd>{{ floor(($net_status['adjust_time'] - time()) / 86400) }} {{ trans('global.common.day') }}
                                            {{floor(((($net_status['adjust_time'] - time()) / 86400) - floor(($net_status['adjust_time'] - time()) / 86400)) * 24) }} {{ trans('global.common.hour') }}</dd>
                                    </dl>
                                </li>
                            </ul>

                            <ul>
                                <li>
                                    <dl>
                                        <dt>{{ trans('global.page.index.estimated-reward-drop') }}</dt>
                                        <dd class="unconfirmed-tx">
                                            <div class="unconfirmed-tx-item">
                                                <span class="text-muted text-left unconfirmed-tx-item-key">{{ trans('global.page.index.reward-drop-time') }}</span>
                                                {{-- 24 * 3600 * 14 = 1209600 --}}
                                                @if($reward_drop_time - time() > 1209600)
                                                    <span>{{ date('Y-m-d', $reward_drop_time) }}</span>
                                                @else
                                                    <span> {{ date('Y-m-d H:i', $reward_drop_time) }} (UTC±0) </span>
                                                @endif
                                            </div>
                                            <div class="unconfirmed-tx-item">
                                                <span class="text-muted text-left unconfirmed-tx-item-key">{{ trans('global.page.index.reward-drop-block-left') }}</span>
                                                <span>{{ number_format($reward_drop_block_left, 0) }}</span>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>

                            <ul data-toggle="tooltip"  class="unconfirmed-txs-popover">
                                <li>
                                    <dl>
                                        <dt><a href="{{ route('stats.unconfirmedTxFees') }}"> {{ trans('global.page.index.unconfirmed-tx') }} </a></dt>
                                        <dd class="unconfirmed-tx">
                                            <div class="unconfirmed-tx-item">
                                                <span class="text-muted text-left unconfirmed-tx-item-key">{{ trans('global.page.index.count') }}</span>
                                                <span class="tx-count">{{ number_format($tx['cnt']) }}</span>
                                            </div>
                                            <div class="unconfirmed-tx-item">
                                                <span class="text-muted text-left unconfirmed-tx-item-key">{{ trans('global.page.index.size') }}</span>
                                                <span class="text-muted tx-size"></span> - <span class="tx-size-human"> Bytes</span>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                            @inlinescript
                            <script>
                                $(function() {
                                    $('.unconfirmed-txs-popover').popover({
                                        container: 'body',
                                        content: ' Max Mempool : 144 MB <br>' +
                                        'Mempool Expiry : 24 Hours <br>' +
                                        'Relayfee : 0.00001 BTC/KB',
                                        html: true,
                                        placement: 'bottom',
                                        trigger: 'hover',
                                        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
                                    });
                                });
                            </script>
                            @endinlinescript
                            <ul>
                                <li>
                                    <dl>
                                        <dt>{{ trans('global.page.index.24h-tx-rate') }}</dt>
                                        <dd>{{ number_format($net_status['tx_24h_rate'], 2) }} {{ trans('global.page.index.tx-s') }}</dd>
                                    </dl>
                                    <dl>
                                        <dt>
                                            <a href="{{ route('stats.block.size') }}">
                                                {{ trans('global.page.index.blocks-median-size') }}
                                            </a>
                                        </dt>
                                        <dd>{{ number_format($net_status['median_block_size'], 0) }} Bytes</dd>
                                    </dl>
                                </li>
                            </ul>

                            <ul>
                                <li>
                                    <dl>
                                        <dt>
                                            <a href="{{ route('stats.unconfirmedTxFees') }}">
                                                {{ trans('global.page.stats-unconfirmed-tx.best-transaction-fees') }}
                                            </a>
                                        </dt>
                                        <dd>
                                            <b id="fees_recommended_sb"></b>
                                            <span> BTC/KB </span>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@inlinescript
<script>
    if ($('.indexPoolShare').height() >= $('.indexNetworkStats').height()) {
        $('.indexNetworkStats').css('height', $('.indexPoolShare').height());
    } else {
        $('.indexPoolShare').css('height', $('.indexNetworkStats').height());
    }

    $(function () { $("[data-toggle='tooltip']").tooltip(); });

    // 轮询更新 推荐手续费
    function updateFeesRecommended(fee) {
        $("#fees_recommended_sb").html(fee);
    }

    function updateFeesData() {
        $.get('/service/fees/recommended')
                .then(function(data) {
                    updateFeesRecommended(data.data.one_block_fee / 1e5);
                    setTimeout('updateFeesData()', 10000);
                });
    }

    updateFeesData();

</script>
@endinlinescript
