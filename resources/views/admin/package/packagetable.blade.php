@forelse ($packages as $item)

    <tr>
        <td>{{ $item->id }}</td>
        <td>
            @if ($item->is_admin != 1)
                {{ optional($item->user)->name }}
                @else
                Admin
            @endif
        </td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->price }}</td>
        <td>{{ $item->duration }}</td>
        <td>{{ $item->status ? 'Active' : 'Inactive' }}</td>
        @if (auth()->user()->is_admin != 0 || auth()->user()->is_handicapper == 1)
            <td>{{ $item->subscribers->count() }}</td>
        @endif

        <td>{{ optional($item)->created_at->diffForHumans() }}</td>
        @if (auth()->user()->is_admin != 0 || auth()->user()->is_handicapper == 1)
            <td>
                {{-- <a href="{{ route('admins.packages.show', $item->id) }}" class="float-left mr-3"><i
                        class="fas fa-eye"></i></a> --}}
                <a href="{{ route($last[1] . '.packages.edit', $item->id) }}" class="float-left"><i
                        class="fas fa-edit"></i></a>
                <form action="{{ route($last[1] . '.packages.destroy', $item->id) }}" method="POST">
                    @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        @endif
    </tr>
@empty
    @if (auth()->user()->is_handicapper == 1 && auth()->user()->stripe_id == null)
        <p class="text-danger">{{ ucfirst('stripe not connected') }}</p>
    @endif
    <p>No Data Found</p>

@endforelse
