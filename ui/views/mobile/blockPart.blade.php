@foreach($txs as $tx)
    <li class="border-show">
        <div><p class="block-trade-common"><a href="{{ route('search.general', ['q' => $tx['hash']]) }}" class="monospace"> {{ $tx['hash'] }}</a></p></div>
        @if($tx['is_coinbase'])
            <div class="block-trade-coinbase"><span class="label label-primary label-coinbase">Coinbase</span></div>
        @endif
        <div>
            <div class="block-trade-bg-common block-trade-bg-common-gray fr">
                <span style="font-size: 12px;">{!! btc_format($tx['outputs_value'], false, false, false) !!}</span> BTC
            </div>
            <div class="block-trade-bg-arrow-common block-trade-bg-arrow-common-gray fr"></div>
        </div>
    </li>
@endforeach