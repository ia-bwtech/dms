{{-- @dd($__data) --}}
@extends('layouts.front.app')

@section('header')
    <style>
        .banner-section span {
            display: inline-flex !important;
        }

        .leaderboard-pagination .pagination {
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <!-- Banner Section -->
    <section id="banner" class="banner-section banner-row banner-row-leaderboard">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Welcome To Blindside Bets</h1>
                    <h2>top sports bettor</h2>
                    <h3>leaderboard</h3>
                </div>
            </div>
        </div>
    </section>
    {{-- <section id="banner" class="banner-section banner-row banner-row-leaderboard">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Welcome To Blind Side Bets</h1>
                    <h2>top sports bettor</h2>
                    <h3>leaderboard</h3>
                    <a class="btn-borderred" href="#">Explore More</a>
                </div>
            </div>

            <section id="banner" class="banner-section">
                <div class="container">
                    <div class="row banner-row bg-white pt-96 pb-96">
                        <div class="col-12 text-center">
                            <h1>Top Sports <span class="prime-color">Bettor</span> <br>Leaderboard</h1>
                            <p class="mt-3 mb-0">Welcome to our leaderboard page. This is where we rank the <b>best
                                </b><br><b>sports bettors</b> for the current season.</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Banner Section --> --}}

    <textarea>{{@json_encode($data)}}</textarea>

            <div id="app">
                <leaderboard-component></leaderboard-component>
            </div>

            <!-- Handicapper -->
            {{-- <section id="handicapper" class="handicapper pt-120 pb-120">
	<div class="container">
		<div class="row">
			<form class="option-form" action="" method="">
				<div class="row justify-content-center">
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<label>Sports</label>
						<select id="league" class="league-option">
							<option value="All Sports">All Sports</option>
							<option value="All Sports">All Sports</option>
							<option value="All Sports">All Sports</option>
						</select>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<label>Date Range</label>
						<select id="league" class="league-option">
							<option value="Current Season">1 day</option>
							<option value="Current Season">7 days</option>
							<option value="Current Season">14 days</option>
							<option value="Current Season">30 days</option>
							<option value="Current Season">Season</option>
							<option value="Current Season">All time</option>
						</select>
					</div>
				</div>
			</form>
		</div>
		<div class="row mt-80">
			<div class="col-12 text-center">
				<h2>Top Sports Bettors</h2>
			</div>
		</div>
		<div class="row mt-40">
			<table class="top">
				<thead>
					<tr>
						<th>Rank</th>
						<th>Icon</th>
						<th>Name</th>
						<th>Wins</th>
						<th>Losses</th>
						<th>Win/Loss Percentage</th>
						<th>Units</th>
						<th>ROI</th>
					</tr>
				</thead>
					<tbody>
						@foreach ($data as $key => $item)
						<tr>
							<td>{{ $key + 1 }}</td>
							<td><a href="{{ route('handicappers.profile', $item->id) }}"><img src="{{ asset('images/profile/' . ($item->image ?? 'default-avatar.jpg')) }}" class="rounded-circle" width="80" height="80" style="object-fit: contain;" alt="Profile Image"></a></td>
							<td><a href="{{ route('handicappers.profile', $item->id) }}">{{ $item->name }}</a></td>
							<td>{{ $item->wins ?? '-' }}</td>
							<td>{{ $item->losses ?? '-' }}</td>
							<td style="text-align: center;" >{{ $item->win_loss_percentage ? $item->win_loss_percentage . '%' : '-' }}</td>
							<td>{{ $item->units ?? '-' }}</td>
							<td>{{ $item->roi ? $item->roi . '%' : '-' }}</td>
						</tr>
						@endforeach
				</tbody>
			</table>
		</div>
		<div class="leaderboard-pagination">
			{{ $data->links() }}
		</div>
	</div>
</section> --}}
            <!-- Handicapper -->
        @endsection
