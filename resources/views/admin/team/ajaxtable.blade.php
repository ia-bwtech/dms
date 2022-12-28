@forelse ($teams as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->team_id }}</td>
        <td>{{ $item->sport	 }}</td>
        <td>{{ $item->league}}</td>
        <td>{{ $item->team_name}}</td>
        <td>{{ $item->team_city}}</td>
        <td>{{ $item->team_mascot}}</td>
        <td>{{ $item->team_abbreviation}}</td>

        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        <td>
            <a href="{{ route('admins.teams.show', $item->id) }}" class="float-left mr-3"><i class="fas fa-eye"></i></a>
            <a href="{{ route('admins.teams.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admins.teams.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
