@forelse ($blogcategories as $item)
    @if ($item->id != 1)
        <tr>
            <td>{{ $item->id }}</td>

            <td>{{ $item->name }}</td>
            <td>

                <a href="{{ route($last[1] . '.blogcategories.edit', $item->id) }}" class="float-left"><i
                        class="fas fa-edit"></i></a>
                <form action="{{ route($last[1] . '.blogcategories.destroy', $item->id) }}" method="POST">
                    @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>


        </tr>
    @endif
@empty
    <p>No Data Found</p>
@endforelse
