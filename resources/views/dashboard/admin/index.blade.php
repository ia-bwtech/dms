@extends('layouts.dashboard.app')

@section('content')
    <div class="py-4">
        <div class="row">
            <div class="col-xxl-3 col-md col-lg">
                <div class="card bg-primary text-white mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75">Earnings (Total)</div>
                                <rotate-loader class="display-4 ml-5" v-if="loading" :loading="loading" :color="color" size="15px"></rotate-loader>
                                <div v-else class="text-lg font-weight-bold">$15000</div>
                            </div>
                            <i class="fas fa-dollar-sign fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md col-lg">
                <div class="card bg-warning text-white mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75">Handicappers</div>
                                <rotate-loader class="display-4 ml-5" v-if="loading" :loading="loading" :color="color" size="15px"></rotate-loader>
                                <div v-else class="text-lg font-weight-bold">20</div>
                            </div>
                            <i class="fas fa-clipboard-list fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md col-lg">
                <div class="card bg-success text-white mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75">Packages</div>
                                <rotate-loader class="display-4 ml-5" v-if="loading" :loading="loading" :color="color" size="15px"></rotate-loader>
                                <div v-else class="text-lg font-weight-bold">3</div>
                            </div>
                            <i class="fas fa-shopping-basket fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md col-lg">
                <div class="card bg-danger text-white mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                <div class="text-white-75">Users</div>
                                <rotate-loader class="display-4 ml-5" v-if="loading" :loading="loading" :color="color" size="15px"></rotate-loader>
                                <div v-else class="text-lg font-weight-bold">7</div>
                            </div>
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main mt-5">
        <h3>Current Active Bets: {{ $activeBets }}</h3>
        <h3>Today's Picks</h3>

        <div class="card card-body border-0 shadow table-wrapper table-responsive">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- <p class="text-info mb-0">Sample table page</p> --}}

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('Name') }}</th>
                        <th class="border-gray-200">Bet</th>
                        <th class="border-gray-200">Market</th>
                        <th class="border-gray-200">Team</th>
                        <th class="border-gray-200">Odds</th>
                        <th class="border-gray-200">Risk</th>
                        <th class="border-gray-200">To Win</th>
                        <th class="border-gray-200">Sport</th>
                        <th class="border-gray-200">League</th>
                        <th class="border-gray-200">Verified Bet</th>
                        <th class="border-gray-200">Status</th>
                        <th class="border-gray-200">Bet Result</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td><span class="fw-normal"><a class="btn btn-primary" href="{{ route('handicappers.profile', $item->user->id) }}">{{ $item->user->name }}</a></span></td>
                            <td><span class="fw-normal">{{ $item->odd_name }}</span></td>
                            <td><span class="fw-normal">{{ $item->market_name }}</span></td>
                            <td><span class="fw-normal"> @if($item->wagered_team == 'home_team')  {{ $item->home_team }}  @else  {{ $item->away_team }} @endif </span></td>
                            <td><span class="fw-normal">{{ $item->odds }}</span></td>
                            <td><span class="fw-normal">{{ $item->risk }}</span></td>
                            <td><span class="fw-normal">{{ $item->to_win }}</span></td>
                            <td><span class="fw-normal">{{ $item->sport }}</span></td>
                            <td><span class="fw-normal">{{ $item->league }}</span></td>
                            <td><span class="fw-normal">{{ $item->is_verified == 1 ? "Yes" : "No" }}</span></td>
                            <td><span class="fw-normal"><button class="btn @if($item->status == 1) btn-success @elseif($item->status == 0) btn-warning @endif" disabled>{{ $item->status == 1 ? "Active" : "Not Active" }}</button></span></td>
                            <td><span class="fw-normal"><button class="btn @if($item->status == 1) btn-warning @else @if($item->is_won == 1) btn-success @elseif($item->is_won == 0) btn-danger @elseif($item->is_won == 2) btn-warning @endif @endif" disabled>@if($item->status == 1) Pending @else @if($item->is_won == 1) Won @elseif($item->is_won == 0) Lost @elseif($item->is_won == 2) Refunded @endif @endif</button></span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{-- {{ $users->links() }} --}}
            </div>
        </div>
    </div>
@endsection
