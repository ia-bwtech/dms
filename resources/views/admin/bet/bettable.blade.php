@forelse ($bets as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->game_id }}</td>
        <td>{{ $item->user->name }}</td>
        <td>{{ $item->is_won }}</td>
        <td>{{ $item->is_verified }}</td>
        <td>{{ $item->league }}</td>
        <td>{{ $item->risk }}</td>
        <td>{{ $item->odds }}</td>
        <td>{{ $item->market_name }}</td>
        <td>{{ $item->odd_name }}</td>
        <td>{{ $item->to_win }}</td>
        <td>{{ $item->home_team }}</td>
        <td>{{ $item->away_team }}</td>
        <td>{{ $item->wagered_team }}</td>

        <td>{{ $item->created_at->format('d-M-Y') }}</td>

    </tr>
@empty
    <p>No Data Found</p>
@endforelse
