@forelse ($faqs as $item)
    <tr>
        <td>{{ $item->id }}</td>

        <td>{{ $item->name }}</td>
        <td>{{ substr($item->description, 0, 70) }}...</td>
        {{-- <td>{{ $item->sortBy }}</td> --}}


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
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        <td>
            <a href="{{ route($last[1].'.faqs.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route($last[1].'.faqs.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
