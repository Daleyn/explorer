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
                        <th>{{ trans('global.page.pool-block.pool-name') }}</th>
                        <td class="text-right"><a href>{{ $pool_name }}</a></td>
                    </tr>
                    <tr>
                        <th>{{ trans('global.page.pool-block.current-hashrate') }}</th>
                        @if($hash_share)
                            <td class="text-right"><span>{{ number_format($hash_share / pow(10, 15), 2) }}</span> Phs</td>
                        @else
                            <td class="text-right">N/A</td>
                        @endif
                    </tr>
                    <tr>
                        <th>{{ trans('global.page.pool-block.current-hashrate-share') }}</th>
                        @if($pool_share)
                            <td class="text-right"><span>{{ number_format($pool_share * 100, 2) }}</span>%</td>
                        @else
                            <td class="text-right"><span>N/A</span></td>
                        @endif
                    </tr>
                     <tr>
                        <th>{{ trans('global.page.pool-block.current-hashrate-rank') }}</th>
                        <td class="text-right" style="width: 230px;"><span>{{ $stats['half_year']['rank'] }}</span>/{{ $stats['half_year']['pool_count'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>


    <section class="section">
    <div class="section-header">
        <h2>{{ trans('global.page.index.latestblocks') }}</h2>
    </div>
    <div class="section-body">
        <table class="table section-body-table last-row-bottom-border">
            <tbody class="more-append">
                <tr>
                    <th class="text-muted">{{ trans('global.block-table-header.height') }}</th>
                    <th class="text-muted text-right">{{ trans('global.block-table-header.size') }} (B)</th>
                    <th class="text-right text-muted" style="width: 140px;">{{ trans('global.block-table-header.block-time') }}</th>
                </tr>
                @include('mobile.poolDetailPart', ['blocks' => $blocks, 'pool_name' => $pool_name])
            </tbody>
        </table>

        @if($total - $page * $pagesize > 0)
            <div id="block-trade-more-info">
                <p id="block-trade-more-info-text" class="page-navMore" data-append=".more-append" data-page="{{ $page }}" data-pagesize="{{ $pagesize }}" data-total="{{  $total }}">
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