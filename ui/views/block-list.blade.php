@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {!! json_encode([
            'endTimestamp' => $latest_block['timestamp'],
            'startTimestamp' => env('BLOCK_CHAIN_START_TIME'),
            'currentTimestamp' => $current_date->timestamp,
            'trans' => $trans
        ]) !!};
</script>
@endsection

@section('body')
    <div class="main-body">
        <div class="container">

            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    <li>{{ $current_date->format('Y-m-d')  }}</li>
                </ol>
            </div>

            <div class="row blockList">
                <div class="blockList-inner">
                    <div class="blockList-cal">
                        @inlinescript
                        <script src="/components/block-list-cal/index.js?__inline"></script>
                        @endinlinescript

                        @template
                        <link rel="import" href="/components/block-list-cal/index.html?__inline"/>
                        @endtemplate
                    </div>

                    <div class="blockList-list">
                        <table class="table">
                            <tr>
                                <th class="text-right">{{ trans('global.block-table-header.height') }}</th>
                                <th>{{ trans('global.block-table-header.relayed-by') }}</th>
                                <th class="text-right">{{ trans('global.block-table-header.n_tx') }}</th>
                                <th class="text-right">{{ trans('global.block-table-header.size') }}(B)</th>
                                <th class="text-center">{{ trans('global.block-table-header.rewords') }}</th>
                                <th class="blockList-list-timestamp">{{ trans('global.block-table-header.block-time') }}</th>
                                <th class="text-center">{{ trans('global.block-table-header.block-hash') }}</th>
                                <th class="text-right">{{ trans('global.block-table-header.block-version') }}</th>
                            </tr>
                            @foreach($block_list as $block)
                                <tr>
                                    <td class="text-right"><a href="{{ route('block.height', ['height' => $block['height']]) }}">{{ number_format($block['height'], 0) }}</a></td>
                                    <td><i class="icon-pool icon-pool-{{ pool2classname(pool_name_format($block)['pool_name']) }}"></i><div class="cell-poolname">{!! pool_name_format($block)['html'] !!}</div></td>
                                    <td class="text-right">{{ number_format($block['tx_count']) }}</td>
                                    <td class="text-right">{{ number_format($block['size'])  }}</td>
                                    <td>{{ 1 / pow(2, floor($block['height'] / 210000)) * 50 }} + {!! btc_format($block['reward_fees']) !!}</td>
                                    <td class="blockList-list-timestamp blockList-list-smallsize"><span class="text-muted">{{ relative_time_format($block['timestamp']) }}</span></td>
                                    <td class="blockList-list-smallsize text-center"><a href="{{ route('search.general', ['q' => $block['hash'] ]) }}" class="text-muted text-monospace">{{ substr($block['hash'], 0, 32) }}<br>{{ substr($block['hash'], 32, 32) }}</a></td>
                                    <td class="text-right">{!! block_version_format($block['version']) !!}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="page-nav">
                        <a href="{{ route('blockList', [ 'date' => $current_date->copy()->subDay()->format('Y-m-d') ]) }}" class="page-navPrev text-hide">{{ trans('global.page.block-list.Prev-day') }}</a>
                        @if($current_date->copy()->format('Y-m-d') != date('Y-m-d'))
                        <a href="{{ route('blockList', [ 'date' => $current_date->copy()->addDay()->format('Y-m-d') ]) }}" class="page-navNext text-hide">{{ trans('global.page.block-list.Next-day') }}</a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@inlinescript
<script>
    document.onkeydown = function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode == 37) {
            changePageOnKey('left');
        }
        if(e && e.keyCode == 39) {
            changePageOnKey('right');
        }
    };

    function changePageOnKey(direct) {
        var base_url = '{{ route("blockList") }}';
        var block_date = globals.currentTimestamp;

        if (direct == 'left') {
            block_date -= 86400;
        } else {
            block_date += 86400;
        }

        if (moment.unix(block_date).utc().isBetween(
                        moment.unix(globals.startTimestamp).utc().format('YYYY-MM-DD'),
                        moment.unix(globals.endTimestamp + 86400).utc().format('YYYY-MM-DD')
           )) {
            window.location.href = base_url + "?date=" + moment.unix(block_date).utc().format('YYYY-MM-DD');
        }
    }

</script>
@endinlinescript
