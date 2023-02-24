@forelse ($blogs as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->category->name }}</td>
        <td>{{ $item->title }}</td>
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>
        <td>{{$item->published ? 'Yes' :'No'}}</td>
        <td>

            <a href="{{ route($last[1].'.blogs.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route($last[1].'.blogs.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
