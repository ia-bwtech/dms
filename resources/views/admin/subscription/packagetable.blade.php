@forelse ($subscriptions as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td><a href="#" data-toggle="modal" data-target="#exampleModal">{{ $item->package->user->name }}</a></td>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@empty

    <p>No Data Found</p>
@endforelse
