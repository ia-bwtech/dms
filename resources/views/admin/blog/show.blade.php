@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <!-- /.card -->
                <!-- Form Element sizes -->
                <!-- /.card -->
                <!-- /.card -->
                <!-- Input addon -->
                <!-- /.card -->
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Add complains</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-8">
                        <form action="#" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body">

                                {{-- <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Roles</label>
                                    <div class="col-sm-6">
                                     <select required class="form-control" name="role_id" id="role_id">
                                        @foreach ($roles as $item)
                                        <option @if ($complain->role_id == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>

                                </div> --}}

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-6">
                                        <input disabled value="{{ $complain->name }}" required type="text" name="name"
                                            class="form-control">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-6">
                                        <input disabled type="email" value="{{ $complain->email }}" required type="text"
                                            name="email" class="form-control">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Wins</label>
                                    <div class="col-sm-6">
                                        <input disabled value="{{ $complain->verified_wins ? $complain->verified_wins : 0 }}"
                                            required type="number" name="verified_wins" class="form-control">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Losses</label>
                                    <div class="col-sm-6">
                                        <input disabled value="{{ $complain->verified_losses ? $complain->verified_losses : 0 }}"
                                            required type="number" name="verified_losses" class="form-control">
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-6">
                                        <select disabled required class="form-control" name="status" id="status">
                                            <option value="">Select</option>
                                            <option @if ($complain->status == 1) selected @endif value="1">Active
                                            </option>
                                            <option @if ($complain->status == 0) selected @endif value="0">In
                                                Active</option>

                                        </select>
                                    </div>

                                </div>


                                {{-- <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Profile Image</label>
                                    <div class="col-sm-6">
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                </div> --}}

                                {{-- <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div> --}}
                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer">
                                <button type="submit" class="btn btn-default float-right">Cancel</button>
                            </div>
                            <!-- /.card-footer --> --}}
                        </form>

                    </div>
                    <h1 style="text-align: center;">Bets ({{ $complain->bets->count() }})</h1>
                    <hr>

                    <div class="align-right">
                    </div>
                    <div class="card-header">
                        @include('admin.layouts.date-filter', [
                            'role' => 0,
                            'route' => 'complainsajax',
                            'show' => 1,
                            'smallview' => 1,
                        ])
                        <br>
                        <div class="card-tools mt-4">
                            <div class="input-group input-group-sm">
                                <form style="display: flex;"  onsubmit="event.preventDefault();" action="{{ route('complains.index') }}">
                                    <div class="input-group border rounded-pill m-1 ">
                                        <input name="keyword" id="keyword" type="search" placeholder="Search"
                                            aria-describedby="button-addon3" class="form-control bg-none border-0">
                                        <div class="input-group-append border-0">
                                            {{-- <button type="button" id="button-addon3" type="button"
                                                class="btn btn-link text-blue"><i class="fa fa-search"></i></button> --}}
                                        </div>
                                    </div>
                                </form>

                                {{-- <a href="{{ route('products.import') }}"><button type="button"
                                        class="btn btn-danger rounded-pill specialbutton m-1">Import products</button></a> --}}
                                {{-- <a href="{{ route($last[1].'.complains.create') }}"><button type="button"
                                        class="btn btn-primary rounded-pill rounded-bill m-1 d-none">Add Complain</button></a> --}}
                            </div>
                        </div>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Game ID</th>
                                    <th>Complain</th>
                                    <th>Won</th>
                                    <th>Verified</th>
                                    <th>Sport</th>
                                    <th>League</th>
                                    <th>Risk</th>
                                    <th>Odds</th>
                                    <th>Market Name</th>
                                    <th>ODD Name</th>
                                    <th>To Win</th>
                                    <th>Home Team</th>
                                    <th>Away Team</th>
                                    <th>Wagered Team</th>

                                    <th>Date</th>

                                </tr>
                            </thead>
                            <tbody id="ajaxupdate">
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                @forelse ($complain->bets as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->game_id }}</td>
                                        <td>{{ $item->complain->name }}</td>
                                        <td>{{ $item->is_won }}</td>
                                        <td>{{ $item->is_verified }}</td>
                                        <td>{{ $item->league }}</td>
                                        <td>{{ $item->risk }}</td>
                                        <td>{{ $item->odds }}</td>
                                        <td>{{ $item->market_name }}</td>
                                        <td>{{ $item->odd_name }}</td>
                                        <td>{{ $item->to_win }}</td>
                                        <td>{{ $item->home_team }}</td>
                                        <td>{{ $item->away_team }}</td>
                                        <td>{{ $item->wagered_team }}</td>

                                        <td>{{ $item->created_at->format('d-M-Y') }}</td>




                                        {{-- <td>
                                            <a href="{{ route($last[1].'.complains.show', $item->id) }}" class="float-left mr-3"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route($last[1].'.complains.edit', $item->id) }}" class="float-left"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route($last[1].'.complains.destroy', $item->id) }}" method="POST">
                                                @method('delete') @csrf <button class="btn btn-link pt-0"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td> --}}


                                    </tr>
                                @empty
                                    <p>No Data Found</p>
                                @endforelse
                            </tbody>
                        </table>
                        <div id="wow" class="align-right paginationstyle">
                            {{-- {{ $complains->links() }} --}}
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div>
@endsection
