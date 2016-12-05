@extends('mobile.layout')


@section('body')

<section class="section">
    <div class="section-body">
        <nav class="pool-panel-interval">
            <ul class="clearfix">
                <li {!! active_class($pool_mode, 'all') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'all']) }}">{{ trans('global.page.stats-pool.mobile-pool-mode.all') }}</a></li>
                <li {!! active_class($pool_mode, 'year') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'year']) }}">{{ trans('global.page.stats-pool.mobile-pool-mode.1year') }}</a></li>
                <li {!! active_class($pool_mode, 'month3') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'month3']) }}">{{ trans('global.page.stats-pool.mobile-pool-mode.3month') }}</a></li>
                <li {!! active_class($pool_mode, 'month') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'month']) }}">{{ trans('global.page.stats-pool.mobile-pool-mode.1month') }}</a></li>
                <li {!! active_class($pool_mode, 'week') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'week']) }}">{{ trans('global.page.stats-pool.mobile-pool-mode.1week') }}</a></li>
                <li {!! active_class($pool_mode, 'day3') !!}><a href="{{ route('stats.pool', ['pool_mode' => 'day3']) }}">{{ trans('global.page.stats-pool.mobile-pool-mode.3days') }}</a></li>
            </ul>
        </nav>

        <table class="table section-body-table" style="margin-top: 24px;">
            <tr>
                <th class="text-muted">{{ trans('global.page.stats-pool.PoolName') }}</th>
                <th class="text-right text-muted" style="width: 70px;">%</th>
                @if(in_array($pool_mode, ['day', 'day3', 'week'] ))
                    <th class="text-right text-muted" style="width: 70px;">Phs</th>
                @else
                    <th class="text-right text-muted" style="width: 70px;">{{ trans('global.page.stats-pool.Count') }}</th>
                @endif
            </tr>
            @foreach(array_slice($pools, 0, 15) as $pool)
                <tr>
                    <td>
                         <div class="table-pool-name"><a href="{{ route('pool', ['pool_name' => $pool['name']]) }}">{{ $pool['name'] }}</a></div>
                    </td>
                    <td class="text-right text-muted">{{ number_format($pool['p'] * 100, 2) }} %</td>
                    @if(in_array($pool_mode, ['day', 'day3', 'week'] ))
                        <td class="text-right text-muted">{{ number_format($pool['hash_share'] / pow(10, 15), 2) }}</td>
                    @else
                        <td class="text-right text-muted">{{ $pool['count'] }} </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</section>
@endsection