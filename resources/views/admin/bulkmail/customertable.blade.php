@forelse ($users as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td><img class="rounded-circle  " style="height: 50px;width: 50px;"
                src="{{ asset('images/userdp/default.png') }}" id="dpuser"></td>
        {{-- <td>{{ $item->firebase_id }}</td> --}}
        {{-- <td>{{ $item->role->name }}</td> --}}
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        {{-- <td>{{ $item->status }}</td> --}}
        <td>{{ $item->phone }}</td>
        <td><a href="{{route('orders.customerorders',$item->id)}}">{{ optional($item->orders)->count() }}</a></td>
        <td><a href="{{route('customer.customerwishlist',$item->id)}}">{{ optional($item->wishlist)->count() }}</a></td>

        {{-- <td>

            <div class="col-sm-2">
                <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}

                {{-- <input id="status{{ $item->id }}" type="hidden" class="toggle "
                    onclick="statusToggle('{{ $item->id }}')" name="locked" value="0"> --}}
                {{-- <label class="switch">
                    <input id="status{{ $item->id }}" @if ($item->status == 1) checked @endif onclick="statusToggle('{{ $item->id }}')"
                        type="checkbox" name="locked" value="1">
                    <span></span>
                </label>
            </div>

        </td> --}}
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        <td>
            <a href="{{ route('users.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route('users.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
