@extends('layouts.front.app')
{{-- @dd($__data) --}}
@section('header')
<style>
    .banner-section span {
		display: inline-flex !important;
	}
</style>
@endsection

@section('content')
<!-- Banner Section -->
{{-- <section id="banner" class="banner-section">
	<div class="container">
		<div class="row banner-row bg-white pt-70 pb-70">
			<div class="col-12 text-center">
				<h1 class="mb-0">Sports Handicapper <span class="prime-color">Shawn Huns</span><br>Picks & Predictions</h1>
			</div>
		</div>
	</div>
</section> --}}
<!-- Banner Section -->

<!-- Profile Section -->
<section id="profile" class="profile-section">
	<div class="container">
		<div class="row banner-row justify-content-center">
			<div class="col-xl-11 col-lg-11 col-md-11 col-sm-12 col-xs-12">
				<div class="card text-center justify-content-center align-items-center  pt-60 pb-60">
					<img src="{{ asset('images/profile/' . ($user->image ?? 'default-avatar.jpg')) }}" class="rounded-circle border border-info" width="350" height="350" style="object-fit: contain;" alt="Profile Image">
					<div class="card-body">
						<h2 class="mt-4 mb-4">{{ $user->name }}</h2>
						{{-- <h4 class="mt-3 mb-3"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></h4> --}}
						<div class="ranking-detail">
							<div class="ranking-box">
								<span>{{ $user->verified_wins + $user->verified_losses }}</span>
								<p>Total Bets</p>
							</div>
							<div class="ranking-box">
								<span>{{ $user->verified_wins ?? '-' }}</span>
								<p>Wins</p>
							</div>
							<div class="ranking-box">
								<span>{{ $user->verified_losses ?? '-' }}</span>
								<p>Losses</p>
							</div>
							<div class="ranking-box">
								<span>{{ $user->verified_win_loss_percentage ?? '-' }}</span>
								<p>Win %</p>
							</div>
							<div class="ranking-box">
								<span>{{ $user->verified_roi ?? '-' }}</span>
								<p>ROI</p>
							</div>
						</div>
                        <p  class="card-text mt-5">{{ $user->bio ?? '' }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Profile Section -->

@guest
<section id="package" class="ranked-package-section pt-90 pb-90">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Subscribed Picks</h2>
			</div>
		</div>
		<div class="row mt-40">
			<p>Please log in to view subscribed picks</p>
		</div>
	</div>
</section>
@endguest
@auth
{{-- Recent Picks --}}
<section id="package" class="ranked-package-section pt-90 pb-90">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Subscribed Picks</h2>
			</div>
		</div>
		<div class="row mt-40">
			<table class="top">
				<thead>
					<tr>
						{{-- <th class="border-gray-200">Sports Bettor</th> --}}
						{{-- <th class="border-gray-200">Sport</th> --}}
						<th class="border-gray-200">League</th>
						<th class="border-gray-200">Bet On</th>
						<th class="border-gray-200">Market</th>
						<th class="border-gray-200">Selection</th>
						<th class="border-gray-200">Match</th>
						<th class="border-gray-200">Odds</th>
						<th class="border-gray-200">Bet Result</th>
						<th class="border-gray-200">Risk</th>
						<th class="border-gray-200">Units</th>
						<th class="border-gray-200">Date</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($subscribedPicks as $item)
							<tr>
								{{-- <td><span class="fw-normal">{{ $item->user->name }}</span></td> --}}
								{{-- <td><span class="fw-normal">{{ $item->sport }}</span></td> --}}
								<td><span class="fw-normal">{{ $item->league }}</span></td>
								<td><span class="fw-normal">{{ $item->odd_name }}</span></td>
								<td><span class="fw-normal">{{ $item->market_name }}</span></td>
								<td><span class="fw-normal"> @if($item->wagered_team == 'home_team')  {{ $item->home_team }}  @else  {{ $item->away_team }} @endif </span></td>
								<td><span class="fw-normal">{{ $item->home_team . ' vs ' . $item->away_team }}</span></td>
								<td><span class="fw-normal">{{ $item->odds > 0 ? '+' . $item->odds : $item->odds }}</span></td>
								<td><span class="fw-normal"><button class="btn @if($item->status == 1) btn-warning @else @if($item->is_won == 1) btn-success @elseif($item->is_won == 0) btn-danger @elseif($item->is_won == 2) btn-warning @endif @endif" disabled>@if($item->status == 1) Pending @else @if($item->is_won == 1) Won @elseif($item->is_won == 0) Lost @elseif($item->is_won == 2) Refunded @endif @endif</button></span></td>
								<td><span class="fw-normal">{{ $item->risk }}</span></td>
								<td><span class="fw-normal">{{ $item->is_won == 1 ? '+' . $item->to_win : '-' . $item->to_win }}</span></td>
								<td><span class="fw-normal">{{ $item->created_at }}</span></td>
							</tr>
						@empty
						<tr><td>Not Subscribed or no picks available</td></tr>
						@endforelse
				</tbody>
			</table>
		</div>
	</div>
</section>
{{-- Recent Picks --}}
@endauth

{{-- Recent Picks --}}
<section id="package" class="ranked-package-section pt-90 pb-90">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Recent Picks</h2>
			</div>
		</div>
		<div class="row mt-40">
			@if($data->isEmpty())
			No recent picks
			@else
			<table class="top">
				<thead>
					<tr>
                        {{-- <th class="border-gray-200">Sports Bettor</th> --}}
                        {{-- <th class="border-gray-200">Sport</th> --}}
                        <th class="border-gray-200">League</th>
                        <th class="border-gray-200">Bet On</th>
                        <th class="border-gray-200">Market</th>
                        <th class="border-gray-200">Selection</th>
						<th class="border-gray-200">Match</th>
                        <th class="border-gray-200">Odds</th>
                        <th class="border-gray-200">Bet Result</th>
                        <th class="border-gray-200">Risk</th>
                        <th class="border-gray-200">Units</th>
						<th class="border-gray-200">Date</th>
                    </tr>
				</thead>
				<tbody>
					@forelse ($data as $item)
                            <tr>
                                {{-- <td><span class="fw-normal">{{ $item->user->name }}</span></td> --}}
                                {{-- <td><span class="fw-normal">{{ $item->sport }}</span></td> --}}
                                <td><span class="fw-normal">{{ $item->league }}</span></td>
                                <td><span class="fw-normal">{{ $item->odd_name }}</span></td>
                                <td><span class="fw-normal">{{ $item->market_name }}</span></td>
                                <td><span class="fw-normal"> @if($item->wagered_team == 'home_team')  {{ $item->home_team }}  @else  {{ $item->away_team }} @endif </span></td>
                                <td><span class="fw-normal">{{ $item->home_team . ' vs ' . $item->away_team }}</span></td>
								<td><span class="fw-normal">{{ $item->odds > 0 ? '+' . $item->odds : $item->odds }}</span></td>
                                <td><span class="fw-normal"><button class="btn @if($item->status == 1) btn-warning @else @if($item->is_won == 1) btn-success @elseif($item->is_won == 0) btn-danger @elseif($item->is_won == 2) btn-warning @endif @endif" disabled>@if($item->status == 1) Pending @else @if($item->is_won == 1) Won @elseif($item->is_won == 0) Lost @elseif($item->is_won == 2) Refunded @endif @endif</button></span></td>
                                <td><span class="fw-normal">{{ $item->risk }}</span></td>
                                <td><span class="fw-normal">{{ $item->is_won == 1 ? '+' . $item->to_win : '-' . $item->to_win }}</span></td>
								<td><span class="fw-normal">{{ $item->created_at }}</span></td>
							</tr>
                        @empty
                        <tr><td>No recent picks</td></tr>
                        @endforelse
				</tbody>
			</table>
			@endif
		</div>
	</div>
</section>
{{-- Recent Picks --}}

<!-- Package Section -->
<section id="package" class="ranked-package-section pt-90 pb-90">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2>Packages</h2>
			</div>
		</div>
		<div class="row mt-40">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				{{-- <div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div> --}}
				@forelse ($user->packages as $package)
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">{{ $package->name }}</h3>
						<p>{{ $package->description }}</p>
						{{-- <p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p> --}}
						<a href="{{ route('package', $package->id) }}">
							<div class="buy-now-container mt-4">
								<ul class="list-unstyled">
									<li><span>Buy Now</span><span><small>Price:</small>${{ $package->price }}</span></li>
									<li><span>*Terms </span><span></span></li>
								</ul>
							</div>
						</a>
					</div>
				</div>
				@empty
					<h4>No packages available</h4>
				@endforelse
			</div>
			{{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div> --}}
		</div>
		{{-- <div class="row mt-40">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
		{{-- <div class="row mt-80">
			<div class="col-12">
				<h3>Weekly Packages</h3>
			</div>
		</div> --}}
		{{-- <div class="row mt-40">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
		{{-- <div class="row mt-80">
			<div class="col-12">
				<h3>Daily Packages</h3>
			</div>
		</div> --}}
		{{-- <div class="row mt-40">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="card">
					<div class="card-body text-center">
						<h3 class="mb-4">Shawn WNBA Wednesday NO BRAINER on Lynx/Dream!</h3>
						<p>Cole Faxon finished as the <b>SECOND BEST WNBA handicapper</b> in 2018-19 and he's <b>TEARING IT UP</b> again this season!</p>
						<p>Faxon is a <b>TRUE VEGAS INSIDER.</b> What does that mean exactly? It means he has sources and info that the amateur bettor would only dream of.</p>
						<p>It also means no one is surprised that he's on an <b>ABSOLUTE HEATER going 51-31 (62%)</b> over his last 83 basketball picks!</p>
						<p><b>DO NOT MISS</b> his NO BRAINER on Lynx v. Dream if you want to <b>GET PAID</b> on Wednesday!</p>
						<h4 class="mt-40 prime-color">100% GUARANTEED TO WIN!</h4>
						<p class="mt-3">If it doesn't, you get the next WNBA card <b>ABSOLUTELY FREE!</b></p>
						<div class="buy-now-container mt-4">
							<ul class="list-unstyled">
 								<li><span><a href="#">Buy Now</a></span><span><small>Price:</small>$19.99</span></li>
 								<li><span>*Includes 1 </span><span>WNBA Spread</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
	</div>
</section>
<!-- Package Section -->

@endsection
