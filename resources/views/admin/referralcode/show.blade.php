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
                        <h3 class="card-title">User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="col-md-12">
                        <form action="#" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row invoice-info">
                                    <div class="col-sm-6 invoice-col">
                                        <label class="m-4" for="">Name:</label>
                                        <label class="m-4" for="">{{ $user->name }}</label>
                                        <br>
                                        <label class="m-4" for="">Verified Wins:</label>
                                        <label class="m-4"
                                            for="">{{ $user->verified_wins ? $user->verified_wins : 0 }}</label>
                                        <br>
                                        <label class="m-4" for="">Verified Losses:</label>
                                        <label class="m-4"
                                            for="">{{ $user->verified_losses ? $user->verified_losses : 0 }}</label>
                                        <br>

                                        <label class="m-4" for="">Verified Plays:</label>
                                        <label class="m-4"
                                            for="">{{ $user->verified_plays ? $user->verified_plays : 0 }}</label>
                                        <br>
                                        <label class="m-4" for="">Verified ROI:</label>
                                        <label class="m-4"
                                            for="">{{ $user->verified_roi ? $user->verified_roi : 0 }}</label>
                                        <br>


                                    </div>



                                    <div class="col-sm-6 invoice-col">
                                        <label class="m-4" for="">Email:</label>
                                        <label class="m-4" for="">{{ $user->email }}</label>
                                        <br>
                                        <label class="m-4" for="">Un Verified Wins:</label>
                                        <label class="m-4"
                                            for="">{{ $user->unverified_wins ? $user->unverified_wins : 0 }}</label>
                                        <br>
                                        <label class="m-4" for="">Un Verified Losses:</label>
                                        <label class="m-4"
                                            for="">{{ $user->unverified_losses ? $user->unverified_losses : 0 }}</label>
                                        <br>

                                        <label class="m-4" for="">Un Verified Plays:</label>
                                        <label class="m-4"
                                            for="">{{ $user->unverified_plays ? $user->unverified_plays : 0 }}</label>
                                        <br>
                                        <label class="m-4" for="">Un Verified ROI:</label>
                                        <label class="m-4"
                                            for="">{{ $user->unverified_roi ? $user->unverified_roi : 0 }}</label>
                                        <br>

                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer">
                                <button type="submit" class="btn btn-default float-right">Cancel</button>
                            </div>
                            <!-- /.card-footer --> --}}
                        </form>

                    </div>
                    <h1 style="text-align: center;">Bets ({{ $user->bets->count() }})</h1>
                    <hr>

                    <div class="align-right">
                    </div>
                    <div class="card-header">
                        @include('admin.layouts.date-filter', [
                            'role' => 0,
                            'route' => 'usersajax',
                            'show' => 1,
                            'smallview' => 1,
                        ])
                        <br>
                        <div class="card-tools mt-4">
                            <div class="input-group input-group-sm">
                                <form style="display: flex;" onsubmit="event.preventDefault();"
                                    action="{{ route('users.index') }}">
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
                                {{-- <a href="{{ route($last[1].'.users.create') }}"><button type="button"
                                        class="btn btn-primary rounded-pill rounded-bill m-1 d-none">Add User</button></a> --}}
                            </div>
                        </div>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Game ID</th>
                                    <th>User</th>
                                    <th>Won</th>
                                    <th>Verified</th>
                                    <th>League</th>
                                    <th>Risk</th>
                                    <th>Odds</th>
                                    <th>Market Name</th>
                                    <th>ODD Name</th>
                                    <th>To Win</th>
                                    <th>Home Team</th>
                                    <th>Away Team</th>
                                    <th>Wagered Team</th>
                                    <th>Graded</th>
                                    <th>Date</th>

                                </tr>
                            </thead>
                            <tbody id="ajaxupdate">
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                @forelse ($bets as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->game_id }}</td>
                                        <td>{{ $item->user->name }}</td>
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
                                        <td>{{ $item->status ? 'Pending' : 'Graded' }}</td>

                                        <td>{{ $item->created_at->format('d-M-Y') }}</td>




                                        {{-- <td>
                                            <a href="{{ route($last[1].'.users.show', $item->id) }}" class="float-left mr-3"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route($last[1].'.users.edit', $item->id) }}" class="float-left"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route($last[1].'.users.destroy', $item->id) }}" method="POST">
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
                            {{ $bets->links() }}
                        </div>
                    </div>


                    <h1 style="text-align: center;">Packages ({{ $packages->total() }})</h1>
                    <hr>

                    <div class="align-right">
                    </div>
                    <div class="card-header">
                        @include('admin.layouts.date-filter', [
                            'role' => 0,
                            'route' => 'usersajax',
                            'show' => 1,
                            'smallview' => 1,
                        ])
                        <br>
                        <div class="card-tools mt-4">
                            <div class="input-group input-group-sm">
                                <form style="display: flex;" onsubmit="event.preventDefault();"
                                    action="{{ route('users.index') }}">
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
                                {{-- <a href="{{ route($last[1].'.users.create') }}"><button type="button"
                                        class="btn btn-primary rounded-pill rounded-bill m-1 d-none">Add User</button></a> --}}
                            </div>
                        </div>

                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Owner</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Duration</th>
                                    <th>Subscribers</th>
                                    <th>Created At</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                @forelse ($packages as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td style="word-break: break-word; white-space: normal;">{{ $item->description }}
                                        </td>
                                        <td>{{ $item->duration }}</td>
                                        <td>{{ $item->subscribers->count() }}</td>
                                        <td>{{ optional($item)->created_at->diffForHumans() }}</td>

                                        <td>
                                            <a href="{{ route($last[1].'.packages.edit', $item->id) }}"
                                                class="float-left"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route($last[1].'.packages.destroy', $item->id) }}"
                                                method="POST">
                                                @method('delete') @csrf <button class="btn btn-link pt-0"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>


                                    </tr>
                                @empty
                                    <p>No Data Found</p>
                                @endforelse
                            </tbody>
                        </table>
                        <div id="wow" class="align-right paginationstyle">
                            {{ $packages->links() }}
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
