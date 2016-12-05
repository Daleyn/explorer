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
                        <th>{{ trans('global.common.confirmations', ['n' => '']) }}</th>
                        <td class="text-right" style="width: 230px;">{{ $tx['confirmations'] }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.common.blockHeight') }}</th>
                        <td class="text-right">
                            @if ($tx['block_height'] == -1)
                                N/A
                            @else
                                <a href="{{ route('block.height', ['height' => $tx['block_height']]) }}">{{ $tx['block_height'] }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.common.confirmTimestamp') }}</th>
                        <td class="text-right">{{ $tx['block_height'] == -1 ? 'N/A' : date('Y-m-d H:i:s', $tx['block_time']) }}</td>
                    </tr>
                    <tr>
                        <th>{!! trans('global.common.fee') !!}</th>
                        <td class="text-right">{!! btc_format($tx['fee']) !!}</td>
                    </tr>
                    <tr>
                        <th>{!! trans('global.common.Hash') !!}</th>
                        <td class="text-right">
                        <span class="monospace" style="font-size: 12px; word-break: break-all; display: block;">
                            {{ $tx['hash'] }}
                        </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>{!! trans('global.common.input') !!}</h2>
        </div>
        <div class="section-body">
            <div class="section-body-inner">
                @if ($tx['is_coinbase'] != true)
                <ul class="txio">
                    @foreach ($tx['inputs'] as $in)
                    <li class="txio-item">
                        <div class="txio-address">
                            @foreach ($in['prev_addresses'] as $a)
                                <a href="{{ route('search.general', ['q' => $a]) }}">{{ count($in['prev_addresses']) > 1 ? (substr($a, 0, intval(30 / count($in['prev_addresses']))) . '..') : $a }}</a>
                            @endforeach
                        </div>
                        <div class="txio-amount"><a href="{{ route('search.general', ['q' => $in['prev_tx_hash']]) }}">{!! btc_format($in['prev_value'], false) !!}</a></div>
                    </li>
                    @endforeach
                </ul>
                @else
                    <span class="label label-primary label-coinbase">Coinbase</span>
                    <span style="font-size: 12px; word-break: break-all;"> {!! coinbaseTxDecodeV3($tx['inputs']['0']['script_hex'], $tx['block_height']) !!} </span>
                @endif
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>{!! trans('global.common.output') !!}</h2>
        </div>
        <div class="section-body">
            <div class="section-body-inner">
                @foreach ($tx['outputs'] as $o)
                    <ul class="txio">
                            <li class="txio-item">
                                <div class="txio-address">
                                    @if (empty($o['addresses']))
                                        {{ trans('global.common.tx_decode_fail') }}
                                    @else
                                        @foreach ($o['addresses'] as $a)
                                            <a href="{{ route('search.general', ['q' => $a]) }}" >{{ count($o['addresses']) > 1 ? (substr($a, 0, intval(30 / count($o['addresses']))) . '..') : $a }}</a>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="txio-amount monospace">
                                    @if($o['spent_by_tx_position'] >= 0)
                                        <a href="{{ route('search.general', ['q' => $o['spent_by_tx']]) }}" class="txio-amount">
                                            {!! btc_format($o['value'], false) !!}
                                        </a>
                                    @else
                                        <span class="txio-amount">
                                            {!! btc_format($o['value'], false) !!}
                                        </span>
                                    @endif
                                </div>
                            </li>
                    </ul>
                @endforeach
            </div>
        </div>
    </section>

    @if($tx_note)
    <section class="section">
        <div class="section-header">
            <h2>{{ trans('global.page.tx.note') }}</h2>
        </div>
        <div class="section-body">
            <div class="section-body-inner">
                <ul class="tx-comment clearfix">
                    @foreach($tx_note as $note)
                    <li class="tx-comment-item">
                        <div class="tx-comment-content">
                            {{ $note['note'] }}
                        </div>
                        <div class="tx-comment-address monospace text-right">
                            <a href="{{ route('search.general', ['q' => $note['address']]) }}">{{ $note['address'] }}</a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    @endif
@endsection