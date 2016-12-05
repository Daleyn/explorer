@foreach ($blocks as $blk)
    <tr>
        <td><a href="{{ route('search.general', ['q' => $blk['hash']]) }}">{{ $blk['height'] }}</a></td>
        <td class="text-right">
            {{ number_format($blk['size']) }}
        </td>
        <td class="text-right text-muted">{!! mobile_relative_time_format($blk['timestamp']) !!}</td>
    </tr>
@endforeach

