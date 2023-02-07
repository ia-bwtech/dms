@forelse ($leagues as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->sport->name }}</td>
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        {{-- <td>
            <a href="{{ route($last[1].'.leagues.show', $item->id) }}" class="float-left mr-3"><i class="fas fa-eye"></i></a>
            <a href="{{ route($last[1].'.leagues.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route($last[1].'.leagues.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td> --}}


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
