@forelse ($payments as $item)
    <tr>
        <td>{{ $item->id }}</td>

        {{-- <td>{{ $item->firebase_id }}</td> --}}
        {{-- <td>@if ($item->is_handicapper == 1) Handicapper @else Bettor @endif</td> --}}
        <td>{{ optional($item->package)->is_admin ? 'Admin' : 'Package Owner' }}</td>
        <td>{{ optional($item->user)->name }}</td>
        <td>{{ optional($item->package)->name }}</td>
        <td>{{ optional(optional($item->package)->user)->name }}</td>
        <td>{{ optional(optional($item->package)->user)->payment_cut_percentage }}</td>
        <td>{{ $item->amount / 100 }}</td>
        <td>{{ $item->status }}</td>
        <td>{{ optional($item)->created_at }}</td>




    </tr>
@empty
    @if (auth()->user()->is_handicapper == 1 && auth()->user()->stripe_id == null)
        <p class="text-danger">{{ ucfirst('stripe not connected') }}</p>
    @endif
    <p>No Data Found</p>
@endforelse
