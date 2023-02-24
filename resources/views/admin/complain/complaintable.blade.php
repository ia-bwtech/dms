@forelse ($complains as $item)
    <tr>
        <td>{{ $item->id }}</td>
        {{-- <td><img class="rounded-circle  " style="height: 50px;width: 50px;"
                src="/images/profile/{{$item->image}}" id="dpcomplain"></td> --}}
        {{-- <td>{{ $item->firebase_id }}</td> --}}
        <td><a href="{{route($last[1].'.users.show',$item->user->id)}}">{{ $item->user->name}}</a></td>
        <td>{{ $item->user->email}}</td>

        <td>{{ $item->subject }}</td>
        <td>{{ $item->complain }}</td>
        <td>@if($item->status==2) Resolved @elseif($item->status==0) Received @else In Progress @endif</td>
        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

        <td>
            {{-- <a href="{{ route($last[1].'.complains.show', $item->id) }}" class="float-left mr-3"><i class="fas fa-eye"></i></a> --}}
            <a href="{{ route($last[1].'.complains.edit', $item->id) }}" class="float-left"><i class="fas fa-edit"></i></a>
            <form action="{{ route($last[1].'.complains.destroy', $item->id) }}" method="POST">
                @method('delete') @csrf <button class="btn btn-link pt-0"><i class="fas fa-trash-alt"></i></button>
            </form>
        </td>


    </tr>
@empty
    <p>No Data Found</p>
@endforelse
