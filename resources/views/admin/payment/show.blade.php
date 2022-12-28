@extends('layouts.app')
@section('content')
<style>
    .pull-right{
        margin-left: 92%;
    }
</style>
<div class="row">
    {{-- <div id="div1" class="pull-right">

    <a href="{{ route('users.create') }}"><button class="btn btn-primary btn-round">
            <i class="fa fa-plus"></i> Add
        </button>
    </a>
    </div> --}}
    @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if(Session::has('danger'))
            <div class="alert alert-danger">
                {{ Session::get('danger') }}
            </div>
            @endif
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">user Details</h4>
          {{-- <p class="card-description"> Add class <code>.table-striped</code> </p> --}}
          <table class="table table-striped">
            <thead>
              <tr>
                <th> Name </th>
                <th> Value </th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td> {{$user->id}} </td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->state}}</td>
                  <td>{{$user->city}}</td>
                  <td>{{$user->postal_code}}</td>
                  <td> {{$user->primary_address}}</td>
                  <td> {{$user->orders->count()}} </td>
                  {{-- <td> {{$item->total}} </td>
                  <td> {{$item->status == 1 ? 'Active' : 'Inactive'}} </td> --}}
                </tr>


            </tbody>
            @if (isset($item))

            <tfoot>
                <th>Total</th>
                <th>{{$item->user->user_total}}</th>
            </tfoot>
            <tfoot>
                <th>Customer Name</th>
                <th>{{$item->user->user->name}}</th>
            </tfoot>
            <tfoot>
                <th>Customer Contact</th>
                <th>{{$item->user->user->phone}}</th>
            </tfoot>
            <tfoot>
                <th>Status</th>
                <th>{{$item->user->status}}</th>
            </tfoot>
            <tfoot>
                <th>Address</th>
                <th>{{$item->user->address}}</th>
            </tfoot>
            @endif

        </table>
        </div>
      </div>
    </div>

  </div>


  {{-- ---------------------------------------------------------------------------------- --}}

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="col-md-12" action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">


                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Enter Category Name">

                    </div>
                    <select class="form-control selectpicker" data-live-search="true" selectAllText="true"
                        data-style="form-control" name="parent_id">
                        <option selected disabled value="0">None</option>
                        @foreach ($users as $item)

                        <option value="{{$item->id}}">{{$item->name}}</option>

                        @endforeach

                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

  {{-- ---------------------------------------------------------------------------------- --}}

@endsection
@section('scripts')
    <script>
        $('a').on('click',function(){
        var id = $(this).prop('id');
        var url= '{{route("users.edit",":id")}}';
        url = url.replace(':id', id);
$.ajax({
  type: "GET",
  url: url,
  dataType:"json",
  success: function(data){
     console.log(data);
  }
});
        })

    </script>
@endsection
