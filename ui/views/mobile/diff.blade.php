@extends('mobile.layout')

@section('body')
    <section class="section">
        <div class="section-header">
            <h2>{{ trans('global.common.summary') }}</h2>
        </div>
        <div class="section-body">
            <div class="section-body-inner">
                <table class="table section-body-table-horizontal table-no-border">
                    <tr>
                        <th>{{ trans('global.page.stats-diff.hash-rate') }}</th>
                        <td class="text-right" style="width: 55%">{!! number_unit_format($net_status['hash_rate'])['size'] !!} {!! number_unit_format($net_status['hash_rate'])['unit'] !!}Hs</td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.page.stats-diff.difficulty') }}</th>
                        <td class="text-right"><a href>{!! number_unit_format($net_status['difficulty'])['size'] !!} {!! number_unit_format($net_status['difficulty'])['unit'] !!}</a></td>
                    </tr>
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
                        <td style="padding: 0">
                            <table class="table table-no-border" style="margin-bottom: 0;">
                                <tr>
                                    <th class="text-muted" style="font-weight: 400; padding: 5px;">{{ trans('global.block-table-header.block-time') }}</th>
                                    <td class="text-right" style="padding: 5px;">
                                        {{ floor(($net_status['adjust_time'] - time()) / 86400) }} {{ trans('global.mobile-common.day') }}
                                        {{floor(((($net_status['adjust_time'] - time()) / 86400) - floor(($net_status['adjust_time'] - time()) / 86400)) * 24) }} {{ trans('global.mobile-common.hour') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted" style="font-weight: 400; padding: 5px;">{{ trans('global.block-table-header.block') }}</th>
                                    <td class="text-right" style="padding: 5px;">{{ 2016 - $latest_block['height'] % 2016 }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>{{ trans('global.block-table-header.history') }}</h2>
        </div>
        <div class="section-body">
            <table class="table section-body-table">
                <tr>
                    <th style="width: 20%" class="text-muted">{{ trans('global.page.stats-diff.height') }}</th>
                    <th class="text-muted text-right" style="width: 25%">{{ trans('global.page.stats-diff.Difficulty') }}</th>
                    <th class="text-right text-muted" style="width: 20%;">{{ trans('global.page.stats-diff.change') }}</th>
                    <th class="text-right text-muted">{{ trans('global.page.stats-diff.block-time') }}</th>
                </tr>
                @foreach($net_hash as $nh)
                    <tr>
                        <td><a href="{{ route('block.height', ['height' => $nh['height']]) }}">{{ $nh['height'] }}</a></td>
                        <td class="text-right">{!! number_unit_format($nh['difficulty'])['size'] !!} {!! number_unit_format($nh['difficulty'])['unit'] !!}</td>
                        @if($nh['change'] == 0)
                            <td class="text-right">{{ $nh['change'] }} %</td>
                        @elseif($nh['change'] > 0)
                            <td class="text-right" style="color: green">{{ $nh['change'] }} %</td>
                        @else
                            <td class="text-right" style="color: red">{{ $nh['change'] }} %</td>
                        @endif
                        <td class="text-muted text-right">{{ date('Y-m-d', $nh['time']) }}</td>  {{-- 显示块 ymd 就可以 --}}
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@endsection