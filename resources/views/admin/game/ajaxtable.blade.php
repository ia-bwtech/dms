@forelse ($games as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->game_id }}</td>
        <td>{{ $item->league }}</td>
        <td>{{ $item->sport}}</td>
        <td>{{ $item->home_team}}</td>
        <td>{{ $item->away_team}}</td>
        <td>{{ optional($item)->start_date }}</td>


        {{-- <td>{{ optional($item)->created_at->diffForHumans() }}</td> --}}

        {{-- <td>
            <a href="{{ route('admins.games.show', $item->id) }}" class="float-left mr-3"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admins.games.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admins.games.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td> --}}


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
