@forelse ($subscriptions as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->package->user->name }}</td>
        <td>{{ $item->package->name }}</td>
        <td>{{ $item->package->price }}</td>
        <td>{{ $item->package->duration }}</td>
        @if (auth()->user()->is_admin != 0 || auth()->user()->is_handicapper == 1)
            {{-- <td>{{ $item->subscribers->count() }}</td> --}}
        @endif
        <td>{!! $item->status ? '<button class="btn btn-success">Active</button>' : '<button class="btn btn-danger">In Active</button>' !!}</td>
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>
        @if (auth()->user()->is_admin != 0 || auth()->user()->is_handicapper == 1)
            {{-- <td>
                <a href="{{ route('admins.packages.show', $item->id) }}" class="float-left mr-3"><i
                        class="fas fa-eye"></i></a>
                <a href="{{ route($last[1].'.packages.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
                <form action="{{ route($last[1].'.packages.destroy', $item->id) }}" method="POST">
                    @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td> --}}
        @endif
    </tr>
@empty

    <p>No Data Found</p>
@endforelse
