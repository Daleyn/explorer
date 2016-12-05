@extends('layout')

@section('script_resource_prepend')@parent
<script>
    var globals = {
        page: {!! json_encode($page) !!},
        pagesize: {!! json_encode($pagesize) !!},
        page_count: {!! json_encode($page_count) !!},
    };
</script>
@endsection

@inlinescript
<script>
    $('[data-toggle="tooltip"]').tooltip();
</script>
@endinlinescript

@section('body')
    <div class="main-body">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb bm">
                    <li><a href="/">{{ trans('global.menu.index') }}</a></li>
                    <li>{{ trans('global.page.block-list.Block') }} - {{ $blk['hash'] }}</li>
                </ol>
            </div>
            <div class="row">
                <div class="panel panel-bm blockAbstract">
                        <div class="panel-heading">
                            <div class="panel-heading-title">{{ trans('global.page.block-list.summary') }}</div>
                        </div>
                        <div class="panel-body text-center">
                            <div class="blockAbstract-inner">
                                <div class="blockAbstract-section">
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.height') }}</dt>
                                        <dd>
                                            {{ number_format($blk['height'], 0) }}
                                            @if ($blk['is_orphan'])
                                                ({{ trans('global.common.orphan') }})
                                            @endif
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>{{ trans('global.common.confirmations', ['n' => '']) }}</dt>
                                        <dd> {{ number_format($blk['confirmations'], 0) }} </dd>
                                    </dl>
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.size') }}</dt>
                                        <dd> {{ number_format($blk['size']) }} <span class="text-muted">Bytes</span> </dd>
                                    </dl>
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.n_tx') }}</dt>
                                        <dd> {{ number_format($blk['tx_count']) }} </dd>
                                    </dl>
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.block-time') }}</dt>
                                        <dd> {{ date('Y-m-d H:i:s', $blk['timestamp']) }} </dd>
                                    </dl>
                                </div>
                                <div class="blockAbstract-section">
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.version') }}</dt>
                                        @if ($blk['version'] > env('BLOCK_MAIN_VER'))
                                            <dd> 0x{{ dechex($blk['version']) }} </dd>
                                        @else
                                            <dd> {{ $blk['version'] }} </dd>
                                        @endif
                                    </dl>
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.difficulty') }}</dt>
                                        <dd> {!! number_unit_format($blk['pool_difficulty'])['size'] !!} <span class="text-muted">{!! number_unit_format($blk['pool_difficulty'])['unit'] !!}</span>
                                            /
                                            {!! number_unit_format($blk['difficulty'])['size'] !!} <span class="text-muted">{!! number_unit_format($blk['difficulty'])['unit'] !!}</span>
                                        </dd>
                                    </dl>
                                    <dl>
                                        <dt>Bits</dt>
                                        <dd class="text-monospace"> 0x{{ dechex($blk['bits']) }} </dd>
                                    </dl>
                                    <dl>
                                        <dt>Nonce</dt>
                                        <dd class="text-monospace"> 0x{{ dechex($blk['nonce']) }} </dd>
                                    </dl>
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.relayed-by') }}</dt>
                                        <dd> {!! pool_name_format($blk)['html'] !!} </dd>
                                    </dl>
                                </div>
                                <div class="blockAbstract-section blockAbstract-section-smallsize">
                                    <dl>
                                        <dt>{{ trans('global.block-table-header.block-hash') }}</dt>
                                        <dd><a href="{{ route('search.general', ['q' => $blk['hash']]) }}">{{ $blk['hash'] }}</a></dd>
                                    </dl>
                                    <dl>
                                        <dt class="blockRussianWordBreak">{{ trans('global.page.block-list.Prev-block') }}</dt>
                                        @if ($blk['prev_block_hash'] === '0000000000000000000000000000000000000000000000000000000000000000')
                                        <dd><span>N/A</span></dd>
                                        @else
                                        <dd><a href="{{ route('search.general', ['q' => $blk['prev_block_hash'] ]) }}">{{ $blk['prev_block_hash'] }}</a></dd>
                                        @endif
                                    </dl>
                                    <dl>
                                        <dt class="blockRussianWordBreak">{{ trans('global.page.block-list.Next-block') }}</dt>
                                        @if ($blk['next_block_hash'] === '0000000000000000000000000000000000000000000000000000000000000000')
                                        <dd><span>N/A</span></dd>
                                        @else
                                        <dd><a href="{{ route('search.general', ['q' => $blk['next_block_hash']]) }}">{{ $blk['next_block_hash'] }}</a></dd>
                                        @endif
                                    </dl>
                                    <dl>
                                        <dt class="blockRussianWordBreak">{{ trans('global.page.block-list.Markele-root') }}</dt>
                                        <dd class="text-muted"> {{ $blk['mrkl_root'] }} </dd>
                                    </dl>
                                    @if ($blk['version'] > env('BLOCK_MAIN_VER'))
                                    <dl>
                                        <dt></dt>
                                        <dd class="text-left">{!! block_version_format($blk['version']) !!}</dd>
                                    </dl>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="row">
                <div class="panel panel-bm blockTxList">
                    <div class="panel-heading">
                        <div class="panel-heading-title">{{ trans('global.page.block-list.Transaction') }}</div>
                    </div>
                    <div class="panel-body">
                        @include('block-show-tx-part', ['txList' => $blk['txs'], 'address' => false, 'address_tags' => $address_tags])
                        <div class="more-append"></div>
                        <div class="page-nav">
                            @if (isset($blk['prev_block']))
                            <a href="{{ route('search.general', ['q' => $blk['prev_block']]) }}" class="page-navPrev" title="{{ trans('global.page.block-list.Prev-block') }}"></a>
                            @endif
                            @if ($blk['tx_count'] - $page * $pagesize > 0)
                                @inlinescript
                                <script src="/components/loadmore/index.js?__inline"></script>
                                @endinlinescript
                                {{--<a href="javascript:" class="page-navMore" data-append=".more-append" data-page="{{ $page }}" data-pagesize="{{ $pagesize }}" data-total="{{ $blk['tx_count'] }}">{{ trans('global.common.load-more') }} (<span>{{ $blk['tx_count'] - $page * $pagesize }}</span> {{ trans_choice('global.common.load-more-left', $blk['tx_count'] - $page * $pagesize) }})</a>--}}
                            @endif
                            @if (isset($blk['next_block']))
                            <a href="{{ route('search.general', ['q' => $blk['next_block']]) }}" class="page-navNext" title="{{ trans('global.page.block-list.Next-block') }}"></a>
                            @endif

                            <ul id="page-pagination" class="pagination-sm"></ul>
                        </div>
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
        var base_url = '{{ route("search.general", ['q' => '']) }}';
        var empty_block = '0000000000000000000000000000000000000000000000000000000000000000';

        if (direct == 'left' && "{{ $blk['prev_block_hash'] }}" != empty_block) {
            window.location.href = base_url + '/' + "{{ $blk['prev_block_hash'] }}";
        }

        if (direct == 'right' && "{{ $blk['next_block_hash'] }}" != empty_block) {
            window.location.href = base_url + '/' + "{{ $blk['next_block_hash'] }}";
        }
    }

    $('#page-pagination').twbsPagination({
        totalPages: globals.page_count,
        visiblePages: 7,
        first: '<<',
        prev: '<',
        next: '>',
        last: '>>',
        href: '?page=@{{number}}' ,
        onPageClick: function (event, page) {
            $('#not-spa-demo-content').text('Page ' + page);
        }
    });

</script>
@endinlinescript