@forelse ($bets as $item)
    <tr>
        <td>{{ $item->id }}</td>
        {{-- <td>{{ $item->game_id }}</td> --}}
        <td>{{ optional($item->user)->name }}</td>
        <td>
            @if ($item->status == 0)
                @if ($item->is_won == 1)
                    Won
                @elseif ($item->is_won == 2)
                    Refunded
                @else
                    Lost
                @endif
            @else
                Pending
            @endif
        </td>
        <td>{{ $item->is_verified }}</td>
        <td>{{ $item->league }}</td>
        <td>{{ $item->risk }}</td>
        <td>{{ $item->odds }}</td>
        <td>{{ $item->market_name }}</td>
        <td>{{ $item->odd_name }}</td>
        <td>{{ $item->to_win }}</td>
        <td>{{ $item->home_team }}</td>
        <td>{{ $item->away_team }}</td>
        <td>{{ $item->status ? 'Pending' : 'Graded' }}</td>

        {{-- <td>{{ $item->wagered_team }}</td> --}}

        <td>{{ $item->created_at->format('d-M-Y h:i') }}</td>
        @if (auth()->user()->is_admin == 1)
            <td>
                <a href="{{ route($last[1] . '.bets.edit', $item->id) }}" class="float-left"><i
                        class="fas fa-edit"></i></a>

            </td>
        @endif
    </tr>
@empty
    <p>No Data Found</p>
@endforelse
