@foreach($list as $block)
    <tr>
        <td class="text-right"><a href="{{ route('block.height', ['height' => $block['height']]) }}">{{ number_format($block['height'], 0) }}</a></td>
        <td class="text-right">{{ number_format($block['tx_count']) }}</td>
        <td class="text-right">{{ number_format($block['size']) }}</td>
        <td class="text-right">{{ 1 / pow(2, floor($block['height'] / 210000)) * 50 }} + {!! btc_format($block['reward_fees']) !!}</td>
        <td class="text-right pool-blockList-smallsize"><span class="text-muted">{{ relative_time_format($block['timestamp']) }}</span></td>
        <td class="text-center pool-blockList-smallsize text-monospace">
            <a class="text-muted" href="{{ route('search.general', ['q' => $block['hash']]) }}">
                {{ substr($block['hash'], 0, 32) }}<br/>{{ substr($block['hash'], 32) }}
            </a>
        </td>
        <td class="text-right"><span class="text-muted">{!! number_unit_format($block['pool_difficulty'])['size'] . number_unit_format($block['pool_difficulty'])['unit'] !!} / </span>{!! number_unit_format($block['difficulty'])['size'] . number_unit_format($block['difficulty'])['unit'] !!}</td>
        <td class="text-right">{!! block_version_format($block['version']) !!}</td>
    </tr>
@endforeach