@forelse ($payments as $item)
    <tr>
        <td>{{ $item->id }}</td>

        {{-- <td>{{ $item->firebase_id }}</td> --}}
        {{-- <td>@if($item->is_handicapper==1) Handicapper @else Bettor @endif</td> --}}
        <td>{{ $item->charge_id }}</td>
        <td>{{ optional($item->user)->name }}</td>
        <td>{{ optional($item->package)->name }}</td>
        <td>{{ optional(optional($item->package)->user)->name }}</td>
        <td>{{ $item->amount }}</td>
        <td>{{ $item->status }}</td>
        <td>{{ optional($item)->created_at }}</td>




    </tr>
@empty
    <p>No Data Found</p>
@endforelse
