@foreach ($txList as $t)
<?php
  $inputMerged = $outputMerged = false;
?>
<div class="tx-item">
    <table class="table">
        <tr class="tx-item-summary">
            <td>
                <a href="{{ route('search.general', ['q' => $t['hash'] ]) }}" class="tx-item-summary-hash">{{ $t['hash'] }}</a>
            </td>
            <td>
                <span class="tx-item-summary-timestamp">{!! btc_format($t['fee'], true, false) !!}</span>
                @if($t['confirmations'] > 0)
                    @if ($address)
                        <span class="tx-item-summary-timestamp"> {{ number_format($t['block_height'], 0) }} </span>
                    @endif
                    <span class="tx-item-summary-timestamp">{{ date('Y-m-d H:i:s', $t['block_time']) }}</span>
                @else
                    <span class="tx-item-summary-timestamp">{{ date('Y-m-d H:i:s') }}</span>
                @endif
            </td>
        </tr>

        <tr class="txio">
            <td>
                @if (! $t['is_coinbase'])
                <ul>
                    <?php
                        $ins = address_clear_repeat_v3($t['inputs'], 'inputs', $address, config('app.maxTxIOCount'), $inputMerged);
                    ?>
                    @foreach($ins as $addr => $info)
                    <?php $as = explode(',', $addr);?>
                        @if (is_null($info))
                            <li><a class="txio-address" href="{{ route('search.general', ['q' => $t['hash']]) }}" target="_blank">...</a></li>
                        @else
                            <li>
                                @if ($info['merged'])
                                <a class="txio-mergedSign txio-mergedSign-in" href="{{ route('search.general', ['q' => $t['hash']]) }}" target="_blank">+</a>
                                @endif
                                @foreach ($as as $a)
                                    @if($a == $address && array_key_exists($a, $address_tags))
                                        <span class="txio-address">{!! address_format($a, $address_tags[$a], true) !!}</span>
                                    @elseif ($a == $address)
                                        <span class="txio-address">{{ $a }}</span>
                                    @else
                                        <a href="{{ route('search.general', ['q' => $a]) }}" class="txio-address">
                                        @if (count($as) > 1)
                                            {{ count($as) > 1 ? (substr($a, 0, intval(30 / count($as))) . '..') : $a }}
                                        @else
                                            @if (! array_key_exists($a, $address_tags))
                                                {{ $a }}</a>
                                            @else
                                                {!! address_format($a, $address_tags[$a]) !!}
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                <a href="{{ route('search.general', ['q' => $info['tx_hash']]) }}" class="txio-amount">
                                    {!! btc_format($info['value'], false) !!}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @else
                    <span class="label label-primary tx-coinbase-label" data-toggle="tooltip"
                            data-placement="right" title="<span class='tx-coinbase-label-tooltip'> {!! coinbaseTxDecodeV3($t['inputs']['0']['script_hex'], $t['block_height']) !!} </span>" data-html="true">Coinbase</span>
                @endif
            </td>
            <td>
                @if ($address)
                    <i class="glyphicon glyphicon-chevron-right txio-arrow{{ address_tx_income($t) ? ' txio-address-income' : ' txio-address-outcome' }}"></i>
                @else
                    <i class="glyphicon glyphicon-chevron-right txio-arrow txio-address-coinbasecome"></i>
                @endif
                <ul>
                    <?php
                        $outs = address_clear_repeat_v3($t['outputs'], 'outputs', $address, config('app.maxTxIOCount'), $outputMerged);
                    ?>
                    @foreach ($outs as $addr => $info)
                        @if (is_null($info))
                            <li><a class="txio-address" href="{{ route('search.general', ['q' => $t['hash']]) }}" target="_blank">...</a></li>
                        @else
                            <li>
                                @if ($info['merged'])
                                    <a class="txio-mergedSign txio-mergedSign-out" href="{{ route('search.general', ['q' => $t['hash']]) }}" target="_blank">+</a>
                                @endif
                                @if (empty($addr))
                                    <span class="txio-address txio-address-decodefail">{{ trans('global.common.tx_decode_fail') }}</span>
                                @else
                                    <?php $as = explode(',', $addr); ?>
                                    @foreach ($as as $a)
                                        @if($a == $address && array_key_exists($a, $address_tags))
                                            <span class="txio-address">{!! address_format($a, $address_tags[$a], true) !!}</span>
                                        @elseif ($a == $address)
                                            <span class="txio-address">{{ $a }}</span>
                                        @else
                                            <a href="{{ route('search.general', ['q' => $a]) }}" class="txio-address">
                                            @if (count($as) > 1)
                                                {{ count($as) > 1 ? (substr($a, 0, intval(30 / count($as))) . '..') : $a }}
                                            @else
                                                @if (! array_key_exists($a, $address_tags))
                                                    {{ $a }}
                                                @else
                                                    {!! address_format($a, $address_tags[$a]) !!}
                                                @endif
                                            @endif
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                                @if($info['tx_hash'] !== '0000000000000000000000000000000000000000000000000000000000000000')
                                    <a href="{{ route('search.general', ['q' => $info['tx_hash']]) }}" class="txio-amount">
                                    {!! btc_format($info['value'], false) !!}
                                    </a>
                                @else
                                    <span class="txio-amount">
                                    {!! btc_format($info['value'], false) !!}
                                    </span>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </td>
        </tr>

        <tr class="tx-item-footer">
            <td class="tx-item-footer-note">
                <p class="tx-item-footer-note-inner">
                    @if (array_key_exists('note', $t))
                        <i class="icon-txnote"></i>
                        <span class="txNotes-content" title="{{ $t['note'] }}">
                            {{ $t['note'] }}
                        </span>
                    @endif
                </p>
            </td>
            <td class="tx-item-footer-additional">
                @if ($inputMerged || $outputMerged)
                <a href="{{ route('search.general', ['q' => $t['hash']]) }}" target="_blank" class="tx-item-showalltx">
                    {{ trans('global.common.show_all_address') }}
                </a>
                @endif

            </td>
        </tr>
        <tr class="tx-item-footer">
            <td class="tx-item-footer-note"></td>
            <td class="tx-item-footer-additional">
                @if($address && $t['confirmations'] <= 0)
                    <span class="tx-item-footer-additional-box"> {{ trans('global.common.unconfirmed') }} </span>
                @elseif($address)
                    <span class="tx-item-footer-additional-box"> {{ trans('global.common.confirmations', ['n' => ' ' . number_format($t['confirmations'])]) }} </span>
                @endif

                @if($address)
                    @if(address_tx_income($t))
                        <span class="tx-item-footer-additional-box txio-address-income">
                    @else
                        <span class="tx-item-footer-additional-box txio-address-outcome">
                    @endif
                    {!! btc_format($t['balance_diff'], false, false, true) !!}
                @else
                    <span class="tx-item-footer-additional-box">
                    {!! btc_format($t['outputs_value'], false, false, false) !!}
                @endif
                </span>
            </td>
        </tr>
    </table>
</div>
@endforeach
