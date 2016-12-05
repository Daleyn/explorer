@extends('mobile.layout')

@section('body')

    <section class="section">
        <div class="section-header">
            <h2 class="monospace" style="font-size: 13px;">{{ $addr['address'] }}</h2>
        </div>
        <div class="section-body">
            <div class="section-body-inner">
                <table class="table section-body-table-horizontal table-no-border">
                    <tr>
                        <th> {{ trans('global.common.balance') }}</th>
                        <td class="text-right" style="width: 200px;">
                            <span>{!! btc_format($addr['balance']) !!}</span>
                        </td>
                    </tr>
                    <tr>
                        <th> {{ trans('global.common.received') }} </th>
                        <td class="text-right">
                            <span>{!! btc_format($addr['received']) !!}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.common.n_tx') }}</th>
                        <td class="text-right" style="width: 230px;">{{ number_format($addr['tx_count']) }}</td>
                    </tr>
                    {{--<tr>--}}
                    {{--<th>大家的印象</th>--}}
                    {{--<td class="text-right" style="width: 230px;"></td>--}}
                    {{--</tr>--}}
                </table>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>{{ trans('global.page.address.Transaction') }}</h2>
        </div>
        <div class="common-content" style="font-size: 12px;">
            <ul>
                @include('mobile.addressPart', ['txs' => $addr['txs']])
                <div class="more-append"></div>
            </ul>

            @if($addr['tx_count'] - $page * $pagesize > 0)
                <div id="block-trade-more-info">
                    <p id="block-trade-more-info-text" class="page-navMore" data-append=".more-append" data-page="{{ $page }}" data-pagesize="{{ $pagesize }}" data-total="{{ $addr['tx_count'] }}">
                        {{ trans('global.common.mobile_load_more') }}
                    </p>
                </div>
                @inlinescript
                <script src="/components/loadmore/index.js?__inline"></script>
                @endinlinescript
            @endif
        </div>

    </section>
@endsection