@extends('layout')

@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    @if ($tx['block_height'] != -1)
                    <li><a href="{{ route('search.general', [ 'q' => $tx['block_height'] ]) }}">{{ trans('global.page.tx.breadcrumbs.l2', ['height' => $tx['block_height'] ]) }}</a></li>
                    @endif
                    <li>{{ $title }}</li>
                </ol>
            </div>
            
            <div class="row">
                <div class="panel panel-bm txAbstract">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.common.summary') }}</div>
                    </div>
                    <div class="panel-body text-center">
                        <div class="abstract-inner txAbstract-inner">
                            <div class="abstract-section">
                                <dl>
                                    <dt>{{ trans('global.common.size') }}</dt>
                                    <dd> {{ $tx['size'] }} <span class="text-muted">Bytes</span> </dd>
                                </dl>
                                <dl>
                                    <dt>{{ trans('global.common.blockHeight') }}</dt>
                                    <dd>
                                        @if ($tx['is_double_spend'])
                                            <span style="color: red">{{ trans('global.common.removed-doubleSpending') }}</span>
                                        @elseif($tx['block_height'] == -1)
                                            N/A
                                        @else
                                            <a href="{{ route('block.height', ['height' => $tx['block_height']]) }}">{{ $tx['block_height'] }}</a>
                                        @endif
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>{{ trans('global.common.confirmations', ['n' => '']) }}</dt>
                                    <dd> {{ $tx['confirmations'] }} </dd>
                                </dl>
                                <dl>
                                    <dt>{{ trans('global.common.confirmTimestamp') }}</dt>
                                    <dd> {{ $tx['block_height'] == -1 ? 'N/A' : date('Y-m-d H:i:s', $tx['block_time']) }} </dd>
                                </dl>
                            </div>
                            <div class="abstract-section">
                                <dl>
                                    <dt>{{ trans('global.common.input') }}</dt>
                                    <dd> {!! btc_format($tx['inputs_value']) !!} </dd>
                                </dl>
                                <dl>
                                    <dt>{!! trans('global.common.output') !!}</dt>
                                    <dd> {!! btc_format($tx['outputs_value']) !!} </dd>
                                </dl>
                                <dl>
                                    <dt>{!! trans('global.common.fee') !!}</dt>
                                    <dd> {!! btc_format($tx['fee']) !!} </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-bm txDetail">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="panel-heading-title">
                                    {{ trans('global.common.input') }}
                                    <span class="txDetail-heading-amount">{!! btc_format($tx['inputs_value']) !!}</span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel-heading-title">
                                    {{ trans('global.common.output') }}
                                    <span class="txDetail-heading-amount">{!! btc_format($tx['outputs_value']) !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tx-item">
                            <table class="table">
                                <tr class="txio">
                                    <td>
                                        @if ($tx['is_coinbase'] != true)
                                            <ul>
                                                <?php $in_count = 0;?>
                                                @foreach ($tx['inputs'] as $in)
                                                    <li>
                                                        @foreach ($in['prev_addresses'] as $a)
                                                            <a href="{{ route('search.general', ['q' => $a]) }}" class="txio-address" id="in_{{ $in_count }}">
                                                                @if (count($in['prev_addresses']) > 1)
                                                                {{ count($in['prev_addresses']) > 1 ? (substr($a, 0, intval(30 / count($in['prev_addresses']))) . '..') : $a }}
                                                                @else
                                                                    @if (! array_key_exists($a, $address_tags))
                                                                        {{ $a }}</a>
                                                                    @else
                                                                        {!! address_format($a, $address_tags[$a])  !!}
                                                                    @endif
                                                                @endif
                                                        @endforeach
                                                        @if ($in['prev_position'] >= 0)
                                                            <a href="{{ route('search.general', ['q' => $in['prev_tx_hash']]) }}#out_{{ $in['prev_position'] }}" class="txio-amount">
                                                                {!! btc_format($in['prev_value'], false) !!}
                                                            </a>
                                                        @else
                                                            <span class="txio-amount">
                                                                {!! btc_format($in['prev_value'], false) !!}
                                                            </span>
                                                        @endif
                                                    </li>
                                                    <?php $in_count += 1;?>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div style="line-height: 30px;">
                                                <span class="label label-primary tx-coinbase-label">Coinbase</span>
                                                <span class="tx-coinbase-decoded">{!! coinbaseTxDecodeV3($tx['inputs']['0']['script_hex'], $tx['block_height']) !!}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            <?php $out_count = 0;?>
                                            @foreach ($tx['outputs'] as $o)
                                                <li>
                                                    @if (empty($o['addresses']))
                                                        <span class="txio-address txio-address-decodefail">
                                                            {{ trans('global.common.tx_decode_fail') }}
                                                            @if (Tx_OP_RETURN_Decode($o['script_asm']) !== false)
                                                                <span class="txScripts-inner"> - ({{ trans('global.page.tx.decoded') }}) {{ Tx_OP_RETURN_Decode($o['script_asm']) }} </span>
                                                            @endif
                                                        </span>
                                                    @else
                                                        @foreach ($o['addresses'] as $a)
                                                            @if (count($o['addresses']) > 1)
                                                                <a href="{{ route('search.general', ['q' => $a]) }}" class="txio-address" id="out_{{ $out_count }}">
                                                                    {{ count($o['addresses']) > 1 ? (substr($a, 0, intval(30 / count($o['addresses']))) . '..') : $a }}
                                                                </a>
                                                            @else
                                                                <a href="{{ route('search.general', ['q' => $a]) }}" class="txio-address" id="out_{{ $out_count }}">
                                                                @if (! array_key_exists($a, $address_tags))
                                                                    {{ $a }} </a>
                                                                @else
                                                                    {!! address_format($a, $address_tags[$a]) !!}
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    @if($o['spent_by_tx_position'] >= 0)
                                                        <a href="{{ route('search.general', ['q' => $o['spent_by_tx']]) }}#in_{{ $o['spent_by_tx_position'] }}" class="txio-amount">
                                                            {!! btc_format($o['value'], false) !!}
                                                        </a>
                                                    @else
                                                        <span class="txio-amount">
                                                            {!! btc_format($o['value'], false) !!}
                                                        </span>
                                                    @endif
                                                </li>
                                                <?php $out_count += 1;?>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>

                                <tr class="tx-item-footer">
                                    <td class="tx-item-footer-note"></td>
                                    <td class="tx-item-footer-additional">
                                        @if ($tx['is_double_spend'])
                                            <span class="tx-item-footer-additional-box" style="color: red"> {{ trans('global.common.removed-doubleSpending') }} </span>
                                        @elseif($tx['confirmations'] <= 0)
                                            <span class="tx-item-footer-additional-box"> {{ trans('global.common.unconfirmed') }} </span>
                                        @else
                                            <span class="tx-item-footer-additional-box"> {{ trans('global.common.confirmations', ['n' => ' ' . number_format($tx['confirmations'])]) }} </span>
                                        @endif
                                    </td>
                                </tr>


                            </table>

                        </div>
                    </div>
                </div>
            </div>
        @if($tx_note)
            <div class="row">
                <div class="panel panel-bm txNotes">
                    <div class="panel-heading"><div class="panel-heading-title">{{ trans('global.page.tx.note') }}</div></div>
                    <div class="panel-body">
                        <ul>
                        @foreach($tx_note as $note)
                            <li>
                                <i class="icon-txnote"></i>
                                <span class="txNotes-addr">{{ $note['address'] }}</span>
                                {{-- 重要：在输出时，为 span 标签添加 title 属性，内容为 notes 全文，以防折叠后无法看到全文 --}}
                                <span class="txNotes-content" title="{{ $note['note'] }}">{{ $note['note'] }}</span>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

            <div class="row">
                <div class="panel panel-bm txScripts">
                    <div class="panel-heading"><div class="panel-heading-title">{{ trans('global.page.tx.inputScripts') }}</div></div>
                    <div class="panel-body">
                        <div class="txScripts-inner">
                            <ul>
                                @foreach ($tx['inputs'] as $in)
                                    @if($tx['is_coinbase'])
                                        <li>
                                            {{ $in['script_hex'] }}<br>
                                            ({{ trans('global.page.tx.decoded') }})
                                            {!! coinbaseTxDecodeV3($tx['inputs']['0']['script_hex'], $tx['block_height']) !!}
                                        </li>
                                    @else
                                        <li>{{ $in['script_hex'] }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="panel panel-bm txScripts">
                    <div class="panel-heading"><div class="panel-heading-title">{{ trans('global.page.tx.outputScripts') }}</div></div>
                    <div class="panel-body">
                        <div class="txScripts-inner">
                            <ul>
                                @foreach ($tx['outputs'] as $o)
                                    @if (Tx_OP_RETURN_Decode($o['script_asm']))
                                        <li>
                                            {{ $o['script_asm'] }} <br>
                                            ({{ trans('global.page.tx.decoded') }})
                                            {{ Tx_OP_RETURN_Decode($o['script_asm']) }}
                                        </li>
                                    @else
                                        <li>{{ $o['script_asm'] }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @inlinescript
    <script src="/components/utils/blink.js?__inline"></script>
    @endinlinescript
@endsection