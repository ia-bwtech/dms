@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                {{-- @include('admin.layouts.date-filter', [
                    'role' => 0,
                    'route' => 'dashboardajax',
                    'show' => 1,
                ]) --}}

                <!-- /.col -->

                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <style>
        .dashboardcards {
            height: 105px;
            font-size: 1.5rem;
        }

        .dashboardcards h5 {
            font-weight: 510;
            font-size: 1.5rem;

        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row datefilter" id="datefilter">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="callout callout-danger dashboardcards">
                        <h5>Total Picks</h5>
                        <p>{{ auth()->user()->verified_wins + auth()->user()->verified_losses + auth()->user()->unverified_wins + auth()->user()->unverified_losses }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="callout callout-danger dashboardcards">
                        <h5>Wins</h5>
                        <p>{{ auth()->user()->verified_wins + auth()->user()->unverified_wins }}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="callout callout-danger dashboardcards">
                        <h5>Active Subscriptions</h5>
                        <p>{{ auth()->user()->subscriptions->where('status', 1)->count() }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="callout callout-danger dashboardcards">
                        <h5>Active Bets</h5>
                        <p>{{ auth()->user()->bets->where('status', 1)->count() }}</p>
                    </div>
                </div>


            </div>


        </div>
        <!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header text-center">
            <h2>Subscribed Picks</h2>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        {{-- <th>Game ID</th> --}}
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
                        <th>Graded</th>
                        {{-- <th>Wagered Team</th> --}}

                        <th>Date</th>

                    </tr>
                </thead>
                <tbody id="ajaxupdate">
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    @forelse (auth()->user()->subscribedPicks1() as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            {{-- <td>{{ $item->game_id }}</td> --}}
                            <td>{{ optional($item->user)->name }}</td>
                            <td>
                                @if ($item->status == 0)
                                    @if ($item->is_won == 1)
                                        Won
                                    @elseif ($item->is_won == 2)
                                        Refunded
                                    @else
                                        Lost
                                    @endif
                                @else
                                    Pending
                                @endif
                            </td>
                            <td>{{ $item->is_verified }}</td>
                            <td>{{ $item->league }}</td>
                            <td>{{ $item->risk }}</td>
                            <td>{{ $item->odds }}</td>
                            <td>{{ $item->market_name }}</td>
                            <td>{{ $item->odd_name }}</td>
                            <td>{{ $item->to_win }}</td>
                            <td>{{ $item->home_team }}</td>
                            <td>{{ $item->away_team }}</td>
                            <td>{{ $item->status ? 'Pending' : 'Graded' }}</td>

                            {{-- <td>{{ $item->wagered_team }}</td> --}}

                            <td>{{ $item->created_at->format('d-M-Y') }}</td>
                            @if (auth()->user()->is_admin == 1)
                                <td>
                                    <a href="{{ route($last[1] . '.bets.edit', $item->id) }}" class="float-left"><i
                                            class="fas fa-edit"></i></a>

                                </td>
                            @endif
                        </tr>
                    @empty
                        <p>No Data Found</p>
                    @endforelse

                </tbody>
            </table>
            {{-- <div id="wow" class="align-right paginationstyle">
            {{ $complains->links() }}
        </div> --}}
        </div>
    </div>
    <!-- /.content -->
@endsection
