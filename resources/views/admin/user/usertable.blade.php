@forelse ($users as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td><img class="rounded-circle  " style="height: 50px;width: 50px;" src="/images/profile/{{ $item->image }}"
                id="dpuser"></td>
        {{-- <td>{{ $item->firebase_id }}</td> --}}
        <td>
            @if ($item->is_handicapper == 1)
                Handicapper
            @else
                Bettor
            @endif
        </td>
        {{-- @dd($item->bets->last()->created_at); --}}
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->packages->count() }}</td>
        <td>{{ $item->verified_plays ? $item->verified_plays : 0 }}</td>
        <td>{{ $item->verified_wins ? $item->verified_wins : 0 }}</td>
        <td>{{ $item->verified_roi ? $item->verified_roi : 0 }}</td>


        {{-- <td>{{ $item->status }}</td> --}}

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
        <td>{{ isset($item->bets->last()->created_at) ? $item->bets->last()->created_at->format('d-M-Y') : 'Never Placed' }}
        </td>
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        <td>
            <a href="{{ route($last[1] . '.users.show', $item->id) }}" class="float-left mr-3"><i
                    class="fas fa-eye"></i></a>
            <a href="{{ route($last[1] . '.users.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route($last[1] . '.users.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
