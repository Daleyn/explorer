@extends('mobile.layout')

@section('body')

 <section class="section">
        <div class="section-header">
            <h2>{{ trans('global.page.block-list.summary') }}</h2>
        </div>
        <div class="section-body">
            <div class="section-body-inner">
                <table class="table section-body-table-horizontal table-no-border">
                    <tr>
                        <th>{{ trans('global.page.block-list.Prev-block') }}</th>
                        <td class="text-right" style="width: 60%">
                            @if ($blk['prev_block_hash'] === '0000000000000000000000000000000000000000000000000000000000000000')
                                N/A
                            @else
                                <a href="{{ route('search.general', ['q' => $blk['prev_block_hash']]) }}">{{ $blk['height'] - 1 }}</a>
                            @endif
                        </td>
                    </tr>
                     <tr>
                        <th>{{ trans('global.block-table-header.height') }}</th>
                        <td class="text-right" style="width: 230px;">{{ $blk['height'] }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.page.block-list.Next-block') }}</th>
                        <td class="text-right">
                            @if ($blk['next_block_hash'] === '0000000000000000000000000000000000000000000000000000000000000000')
                                N/A
                            @else
                                <a href="{{ route('search.general', ['q' => $blk['next_block_hash']]) }}">{{ $blk['height'] + 1 }}</a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.common.confirmations', ['n' => '']) }}</th>
                        <td class="text-right" style="width: 230px;"> {!! $blk['confirmations'] !!}</td>
                    </tr>
                     <tr>
                        <th> {{ trans('global.block-table-header.size') }}</th>
                        <td class="text-right"> <span>{{ number_format($blk['size']) }}</span> Bytes</td>
                    </tr>
                     <tr>
                        <th>{{ trans('global.block-table-header.n_tx') }}</th>
                        <td class="text-right" style="width: 230px;">{{ number_format($blk['tx_count']) }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.block-table-header.block-time') }}</th>
                        <td class="text-right">{{ date('Y-m-d H:i:s', $blk['timestamp']) }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.block-table-header.relayed-by') }}</th>
                        <td class="text-right">
                            {!! pool_name_format($blk)['html'] !!}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.block-table-header.block-hash') }}</th>
                        <td class="text-right">
                        <span class="monospace" style="font-size: 12px; word-break: break-all; display: block;">
                            {{ $blk['hash'] }}
                        </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2>{{ trans('global.page.block-list.Transaction') }}</h2>
        </div>
             <div class="common-content">
                 <ul class="more-append">
                     @include('mobile.blockPart', ['txs' => $blk['txs']])
                 </ul>

                 @if($blk['tx_count'] - $page * $pagesize > 0)
                     <div id="block-trade-more-info">
                         <p id="block-trade-more-info-text" class="page-navMore" data-append=".more-append" data-page="{{ $page }}" data-pagesize="{{ $pagesize }}" data-total="{{  $blk['tx_count'] }}">
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