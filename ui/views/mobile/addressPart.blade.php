@foreach($txs as $tx)
    <li class="border-show">
        <div>
            <p class="block-trade-common"><a class="monospace" href="{{ route('search.general', ['q' => $tx['hash']]) }}"> {{ $tx['hash'] }} </a> </p>
        </div>
    @if($tx['is_coinbase'])
            <div class="block-trade-coinbase"><span class="label label-primary label-coinbase">Coinbase</span></div>
    @endif
        <div>
            @if($tx['block_height'] == -1)
                <div class="block-trade-bg-arrow-common-gray fl"></div>
                <div class="block-trade-bg-common block-trade-bg-common-gray fl">{{ trans('global.common.unconfirmed') }}</div>
            @elseif($tx['confirmations'] <= 144)
                <div class="block-trade-bg-arrow-common-gray fl"></div>
                <div class="block-trade-bg-common block-trade-bg-common-gray fl">{{ trans('global.common.confirmations', ['n' => ' ' . $tx['confirmations']]) }}</div>
            @endif

            @if($tx['balance_diff'] >= 0)
                <div class="block-trade-bg-common block-trade-bg-common-yellow fr">
                    <p>
                        <span>{!! btc_format($tx['balance_diff'], false, false, true) !!}</span>
                        BTC</div>
                <div class="block-trade-bg-arrow-common-yellow fr"></div>
            @else
                <div class="block-trade-bg-common block-trade-bg-common-red fr">
                    <p>
                        <span>{!! btc_format($tx['balance_diff'], false, false, true) !!}</span>
                        BTC</div>
                <div class="block-trade-bg-arrow-common-red fr"></div>
            @endif
        </div>
    </li>
@endforeach