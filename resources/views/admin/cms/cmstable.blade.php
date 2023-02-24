@forelse ($cmss as $key=>$item)
    <tr>
        <td>{{ $key+1 }}</td>

        <td>{{ $item->page }}</td>

        {{-- <td>{{ optional($item)->created_at->diffForHumans() }}</td> --}}

        <td>
            {{-- <a href="{{ route($last[1].'.cmss.show', $item->page) }}" class="float-left mr-3"><i class="fas fa-eye"></i></a> --}}
            <a href="{{ route($last[1].'.cmss.edit', $item->page) }}" class="float-left"><i class="fas fa-edit"></i></a>
            {{-- <form action="{{ route($last[1].'.cmss.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form> --}}
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
