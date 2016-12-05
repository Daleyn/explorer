@extends('mobile.layout')

@section('body')

<section class="section">
    {{--<div class="well well-default">--}}
        {{--{!! trans('global.page.index.block-ver-warning', ['block' => $block_ver_4, 'percent' => 100 * number_format($block_ver_4 / 1000, 4)]) !!}--}}
    {{--</div>--}}
    <div class="section-header">
        <h2>{{ trans('global.page.index.latestblocks') }}</h2>
    </div>
    <div class="section-body">
        <table class="table section-body-table">
            <tr>
                <th style="width: 80px;" class="text-muted">{{ trans('global.block-table-header.height') }}</th>
                <th class="text-muted">{{ trans('global.block-table-header.relayed-by') }}</th>
                <th class="text-right text-muted" style="width: 100px;">{{ trans('global.block-table-header.block-time') }}</th>
            </tr>
            @foreach ($blocks as $blk)
            <tr>
                <td><a href="{{ route('search.general', ['q' => $blk['hash']]) }}">{{ $blk['height'] }}</a></td>
                    <td>
                        <div class="table-pool-name">
                            {!! pool_name_format($blk)['html'] !!}
                        </div>
                    </td>
                    <td class="text-right text-muted">{!! mobile_relative_time_format($blk['timestamp']) !!}</td>
            </tr>
            @endforeach
        </table>
    </div>
</section>

<section class="section">
    <div class="section-header">
        <a href="{{ route('stats.pool') }}"><i class="icon icon-section-more"></i></a>
        <h2>{{ trans('global.page.index.Pools-Distribution') }}</h2>
    </div>
    <div class="section-body">
        <table class="table section-body-table">
            <tr>
                <th class="text-muted">{{ trans('global.page.index.pools') }}</th>
                <th class="text-right text-muted" style="width: 70px;">%</th>
                <th class="text-right text-muted" style="width: 70px;">Phs</th>
            </tr>
            @foreach(array_slice($pools, 0, 10) as $pool)
                <tr>
                    <td>
                         <div class="table-pool-name"><a href="{{ route('pool', ['pool_name' => $pool['name']]) }}">{{ $pool['name'] }}</a></div>
                    </td>
                    <td class="text-right text-muted">{{ number_format($pool['p'] * 100, 2) }} %</td>
                    <td class="text-right text-muted">{{ number_format($pool['hash_share'] / pow(10, 15), 2) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</section>

<section class="section netstatus">
    <div class="section-header">
        <a href="{{ route('stats.diff') }}"><i class="icon icon-section-more"></i></a>
        <h2>{{ trans('global.page.index.net-status') }}</h2>
    </div>
    <div class="section-body">
        <table class="netstatus-table">
            <tr>
                <th>{{ trans('global.page.stats-diff.hash-rate') }}</th>
                <td class="text-right">{!! number_unit_format($net_status['hash_rate'])['size'] !!} {!! number_unit_format($net_status['hash_rate'])['unit'] !!}Hs</td>
            </tr>
            <tr>
                <th>{{ trans('global.page.stats-diff.difficulty') }}</th>
                <td class="text-right">
                    <span class="text-muted">{{ number_format($net_status['difficulty']) }} - </span>{!! number_unit_format($net_status['difficulty'])['size'] !!} {!! number_unit_format($net_status['difficulty'])['unit'] !!}
                </td>
            </tr>
        </table>
        <table class="netstatus-table">
            <tr>
                <th>{{ trans('global.page.mobile-stats-diff.estimated-next-difficulty') }}</th>
                <td class="text-right">
                    @if($net_status['next_difficulty'] - $net_status['difficulty'] > 0)
                        (+{{ number_format(($net_status['next_difficulty'] - $net_status['difficulty']) / $net_status['difficulty'] * 100, 2) }}%)
                    @else
                        ({{ number_format(($net_status['next_difficulty'] - $net_status['difficulty']) / $net_status['difficulty'] * 100, 2) }}%)
                    @endif
                    {!! number_unit_format($net_status['next_difficulty'])['size'] !!} {!! number_unit_format($net_status['next_difficulty'])['unit'] !!}
                </td>
            </tr>
            <tr>
                <th>{{ trans('global.page.stats-diff.next-difficulty') }}</th>
                <td class="text-right">
                    {{ floor(($net_status['adjust_time'] - time()) / 86400) }} {{ trans('global.common.day') }}
                    {{floor(((($net_status['adjust_time'] - time()) / 86400) - floor(($net_status['adjust_time'] - time()) / 86400)) * 24) }} {{ trans('global.common.hour') }}
                </td>
            </tr>
        </table>
        <table class="netstatus-table">
            <tr>
                <th style="vertical-align: top; padding-right: 5px;">{{ trans('global.page.index.estimated-reward-drop') }}</th>
                <td style="width: 52%">
                    <table class="netstatus-table">
                        <tr>
                            <th class="text-muted" style="width: 40%;">{{ trans('global.page.index.reward-drop-time') }}</th>
                            <td class="text-right">
                                {{-- 24 * 3600 * 14 = 1209600 --}}
                                @if($reward_drop_time - time() > 1209600)
                                    <span>{{ date('Y-m-d', $reward_drop_time) }}</span>
                                @else
                                    <span>{{ date('Y-m-d H:i', $reward_drop_time) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted" style="width: 40%;">{{ trans('global.page.index.reward-drop-block-left') }}</th>
                            <td class="text-right">{{ $reward_drop_block_left }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="netstatus-table">
            <tr>
                <th style="vertical-align: top;">{{ trans('global.page.index.unconfirmed-tx') }}</th>
                <td class="text-right" style="width: 52%">
                    <table class="netstatus-table">
                        <tr>
                            <th class="text-muted">{{ trans('global.page.index.count') }}</th>
                            <td class="text-right">{{ number_format($tx['cnt']) }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ trans('global.page.index.size') }}</th>
                            <td class="text-right">{!! number_unit_format($tx['size'])['size'] !!} {!! number_unit_format($tx['size'])['unit'] !!}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="netstatus-table">
            <tr>
                <th>{{ trans('global.page.index.24h-tx-rate') }}</th>
                <td class="text-right">{{ number_format($net_status['tx_24h_rate'], 2) }} {{ trans('global.page.index.tx-s') }}</td>
            </tr>
        </table>
    </div>
</section>

@endsection