@forelse ($bulkmails as $item)
    <tr>
        <td>{{ $item->id }}</td>

        <td>{{ $item->subject }}</td>
        <td>{{ $item->recipients->count() }}</td>



        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        <td>
            {{-- <a href="{{ route($last[1].'.bulkmails.show', $item->id) }}" class="float-left mr-3"><i class="fas fa-eye"></i></a> --}}
            <form action="{{ route($last[1].'.bulkmails.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
