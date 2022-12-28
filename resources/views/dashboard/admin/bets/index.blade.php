@extends('layouts.dashboard.app')

@section('content')
    <div class="main py-4">
        
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card card-body border-0 shadow table-wrapper table-responsive mt-5">
            <h2 class="mb-4 h5">All Bets</h2>
            <div>
                <form action="{{ route('admin.bets.filter') }}" method="GET">
                    Pending
                    @if(app('request')->input('pendingFilter'))
                    <input style="margin: 10px 5px 0 5px" checked class="form-check-input" type="checkbox" name="pendingFilter" id="">
                    @else
                    <input style="margin: 10px 5px 0 5px" class="form-check-input" type="checkbox" name="pendingFilter" id="">
                    @endif
                    <button style="margin-left: 10px;" class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
            

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
                        <th class="border-gray-200">Game ID</th>
                        <th class="border-gray-200">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td><span class="fw-normal"> <a class="btn btn-primary" href="{{ route('handicappers.profile', $item->user->id) }}">{{ $item->user->name }}</a></span></td>
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
                            <td><span class="fw-normal">{{ $item->game_id }}</span></td>
                            <td><span title="{{ $item->created_at }}" class="fw-normal">{{ $item->created_at->diffForHumans() }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection