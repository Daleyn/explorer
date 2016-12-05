@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        pool: {!! json_encode($pool['name']) !!},
        monthData: {!! json_encode($data) !!},
        trans: {!! json_encode($trans) !!}
    };
</script>
@endsection

@section('body')

    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="{{ route('index') }}">{{ trans('global.menu.index') }}</a></li>
                    <li><a href="{{ route('stats') }}">{{ trans('global.menu.stats') }}</a></li>
                    <li><a href="{{ route('stats.pool') }}">{{ trans('global.page.pool-block.pool') }}</a></li>
                    <li>{{ $pool['name'] }}</li>
                </ol>
            </div>

            <div class="row pool">
                <div class="pool-summary">
                    <table class="table">
                        <tr>
                            <td class="pool-summary-section">
                                <table class="table">
                                    <tr>
                                        <td class="text-center pool-logo-container">
                                            <a href="{{ $pool['link'] }}" class="pool-logo" target="_blank">
                                                {{$pool['name']}}
                                                <i class="glyphicon glyphicon-new-window"></i>
                                            </a>
                                        </td>
                                        {{-- TODO: 如果矿池没有 logo 图片，则输出下面的 script --}}
                                        @if (true)
                                        @inlinescript
                                        <script>
                                            $(function() {
                                                var $logoContainer = $('.pool-logo-container');
                                                var $logo = $logoContainer.find('.pool-logo');
                                                if ($logo.find('img').length) return false;
                                                var maxWidth = $logoContainer.width() - 10, maxHeight = $logoContainer.height() - 10;
                                                for (var size = 12; $logo.width() <= maxWidth && $logo.height() <= maxHeight; $logo.css('font-size', size++)){
                                                    // do nothing
                                                }
                                            });
                                        </script>
                                        @endinlinescript
                                        @endif
                                        <td>
                                            <table class="table">
                                                <tr>
                                                    <td class="text-muted">{{ trans('global.page.pool-block.pool-name') }}</td>
                                                    <td class="text-right">{{$pool['name']}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">{{ trans('global.page.pool-block.current-hashrate') }}</td>
                                                    @if($hash_share)
                                                    <td class="text-right">{{ number_format($hash_share / pow(10, 15), 2) }} PH/s</td>
                                                    @else
                                                        <td class="text-right">N/A</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">{{ trans('global.page.pool-block.current-hashrate-share') }}</td>
                                                    @if($pool_share)
                                                    <td class="text-right">{{ number_format($pool_share * 100, 2) }}%</td>
                                                    @else
                                                        <td class="text-right">N/A</td>
                                                    @endif
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="pool-summary-section pool-summary-blockStats">
                                <table class="table">
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th class="text-right">{{ trans('global.page.pool-block.half-year') }}</th>
                                        <th class="text-right">{{ trans('global.page.pool-block.all') }}</th>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">{{ trans('global.page.pool-block.block-count') }}</td>
                                        <td class="text-right">{{number_format($stats['half_year']['raw_info']['count'])}}</td>
                                        <td class="text-right">{{number_format($stats['all']['raw_info']['count'])}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">{{ trans('global.page.pool-block.block-rank') }}</td>
                                        <td class="text-right">{{ $stats['half_year']['rank'] }}<span class="text-muted"> / {{ $stats['half_year']['pool_count'] }}</span></td>
                                        <td class="text-right">{{ $stats['all']['rank'] }}<span class="text-muted"> / {{ $stats['all']['pool_count'] }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">{{ trans('global.page.pool-block.block-share') }}</td>
                                        <td class="text-right"><span class="text-muted">{{number_format($stats['half_year']['raw_info']['count'])}} / {{number_format($stats['half_year']['total_count'])}} = </span>{{number_format($stats['half_year']['raw_info']['count'] / $stats['half_year']['total_count'] * 100, 2)}} %</td>
                                        <td class="text-right"><span class="text-muted">{{number_format($stats['all']['raw_info']['count'])}} / {{number_format($stats['all']['total_count'])}} = </span>{{number_format($stats['all']['raw_info']['count'] / $stats['all']['total_count'] * 100, 2)}} %</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="cal">
                    <div class="cal-svg"></div>
                    <div class="cal-month-bar"></div>
                </div>

                {{-- 日期选择器 --}}
                @script('/components/pool-chart/cal.js')
                @inlinescript
                <script>
                    window.Chart.cal.init('pool');
                </script>
                @endinlinescript

                <div class="pool-blockList">
                    <table class="table">
                        <tr>
                            <th class="text-right">{{ trans('global.block-table-header.height') }}</th>
                            <th class="text-right">{{ trans('global.block-table-header.n_tx') }}</th>
                            <th class="text-right">{{ trans('global.block-table-header.size') }}(B)</th>
                            <th class="text-right">{{ trans('global.block-table-header.rewords') }}</th>
                            <th class="text-right">{{ trans('global.block-table-header.block-time') }}</th>
                            <th class="text-center">{{ trans('global.block-table-header.block-hash') }}</th>
                            <th class="text-right">{{ trans('global.block-table-header.difficulty') }}</th>
                            <th class="text-right">{{ trans('global.block-table-header.block-version') }}</th>
                        </tr>
                        @include('pool-block-part', ['list' => $block_list, 'pool' => $pool])
                    </table>
                </div>

                <div class="page-nav">
                    @if($stats['all']['raw_info']['count'] - $page * $pagesize > 0)
                        @inlinescript
                            <script src="/components/loadmore/index.js?__inline"></script>
                        @endinlinescript
                        <a href="javascript:" class="page-navMore" data-append=".pool-blockList .table" data-page="{{ $page }}" data-pagesize="{{ $pagesize }}" data-total="{{ $stats['all']['raw_info']['count'] }}">{{ trans('global.common.load-more') }} (<span>{{ $stats['all']['raw_info']['count'] - $pagesize * $page }}</span> {{ trans_choice('global.common.load-more-left', $stats['all']['raw_info']['count'] - $pagesize * $page)  }})</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection