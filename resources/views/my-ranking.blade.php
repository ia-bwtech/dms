@extends('layouts.front.app')
@section('header')
<style>
    .card {
		box-shadow: unset;
    	background: transparent;
	}
</style>
@endsection

@section('content')
<div id="app">
<!-- Banner Section -->
{{-- <section id="banner" class="banner-section profile-section pb-60">
	<div class="container">
		<div class="row banner-row justify-content-center pt-70 pb-70 bg-white">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
				<div class="card align-items-center position-relative">
					<img src="{{ asset('images/profile/' . (Auth::user()->image ?? 'default-avatar.jpg')) }}" class="rounded-circle border border-info" width="350" height="350" style="object-fit: contain;" alt="Profile Image">
					<div class="card-body mb-5">
						<a href="{{ route('handicappers.profile', Auth::id()) }}"><h2 class="mt-4 mb-4">{{ Auth::user()->name }}</h2></a>
						<verified-component :auth='@json(Auth::user())'></verified-component>
						<div class="ranking-detail">
							<div class="ranking-box">
								<span>{{ Auth::user()->is_verified == 1 ? Auth::user()->verified_wins + Auth::user()->verified_losses : Auth::user()->unverified_wins + Auth::user()->unverified_losses }}</span>
								<p>Total Bets</p>
							</div>
							<div class="ranking-box">
								<span>{{ Auth::user()->is_verified == 1 ? Auth::user()->verified_wins ?? '-' : Auth::user()->unverified_wins ?? '-' }}</span>
								<p>Wins</p>
							</div>
							<div class="ranking-box">
								<span>{{ Auth::user()->is_verified == 1 ? Auth::user()->verified_losses ?? '-' : Auth::user()->unverified_losses ?? '-' }}</span>
								<p>Losses</p>
							</div>
							<div class="ranking-box">
								<span>{{ Auth::user()->is_verified == 1 ?  Auth::user()->verified_win_loss_percentage . '%' ?? '-' : Auth::user()->unverified_win_loss_percentage . '%' ?? '-' }}</span>
								<p>Win %</p>
							</div>
							<div class="ranking-box">
								<span>{{  Auth::user()->is_verified == 1 ? Auth::user()->verified_roi . '%' ?? '-' : Auth::user()->unverified_roi . '%' ?? '-' }}</span>
								<p>ROI</p>
							</div>
						</div>
					</div>
					<div class="my-ranking-hatl">
						<h2 class="mb-3">BLINDSIDEBETS</h2>
							<a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
						<p  class="card-text mt-5 text-light">{{ Auth::user()->bio ?? '' }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> --}}
<!-- Banner Section -->

{{-- 
<section id="netunit-blase" class="pb-120">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h2 class="pl-95">My Bets</h2>
				<div class=" pl-95 pr-120 pt-55 pb-55 mt-40">
					<div class="row">
						@if(isset($data))
						@foreach($data as $item)
						<div class="slider-box unit-slider-box col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 custom-col">
							<h3>{{ $item->odd_name . ' (' . $item->odds . ')' }}</h3>
							<h6><i>{{ $item->market_name }}</i></h6><br>
							<h3 class="prime-color mb-1">{{ $item->risk . 'u' }}</h3>
							<small>{{ $item->home_team . ' VS ' . $item->away_team }}</small>
							<small class="prime-color">Pending</small>
						</div>
						@endforeach
						@else
						<div class="slider-box unit-slider-box">
							<h3>No current Active Bets</h3>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section> 
--}}

<!-- Net Units -->
@if(request()->input('league'))
<odds-component :auth='@json(Auth::user())' :league_prop='@json(request()->input('league'))' :sport_prop='@json(request()->input('sport'))'></odds-component>
@else
<odds-component :auth='@json(Auth::user())' :league_prop='@json('MLB')' :sport_prop='@json('baseball')'></odds-component>
@endif
<!-- Net Units -->

</div>
@endsection
