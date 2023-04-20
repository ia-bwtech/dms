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
    <!-- Banner Section1 -->
    <section id="banner" class="banner-section banner-row banner-row-handicapperprofile">
        <div class="container">
            <div class="row">
                <div class="col-3">
                <div class="pro-image">
                        <img src="{{ asset('images/profile/' . ($user->image ?? 'default-avatar.jpg')) }}" width="316px" height="328px"
                            class="sportsbettor-left-img">
                    </div>
                   </div>
                <div class="col-9">

                        <div class="row align-items-center">
                            <div class="name-pro">
                                <h1>{{ $user->name ?? '-' }}</h1>
                                {{-- <h3>Packages</h3> --}}
                            </div>
                            <table class="table bg-dark">
                                <thead class="text-center text-white">
                                    <th class="border-bottom-0">Total Bets</th>
                                    <th class="border-bottom-0">Wins</th>
                                    <th class="border-bottom-0">Losses</th>
                                    <th class="border-bottom-0">Win %</th>
                                    <th class="border-bottom-0">ROI</th>

                                </thead>
                                <tbody class="text-center text-white font-weight-bold">
                                    <tr>
                                        <td>{{ $user->verified_wins + $user->verified_losses }}</td>
                                        <td>{{ $user->verified_wins ?? '-' }}</td>
                                        <td>{{ $user->verified_losses ?? '-' }}</td>
                                        <td>{{ $user->verified_win_loss_percentage ?? '-' }}</td>
                                        <td>{{ $user->verified_roi ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                             <p class="fs-6 text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                        </div>



                </div>



            </div>


        </div>
    </section>
    <!-- ./Banner Section -->

    @guest
        <section id="package" class="ranked-package-section pt-90 pb-90">
            <div class="container-fluid">
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
        <section id="subscribed-picks" class="ranked-package-section pt-90 pb-90">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h2>Subscribed Picks</h2>
                    </div>
                </div>
                <div class="row mt-40">
                    <table class="top sub-picks">
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
                                    <td><span class="fw-normal">
                                            @if ($item->wagered_team == 'home_team')
                                                {{ $item->home_team }}
                                            @else
                                                {{ $item->away_team }} @endif
                                        </span></td>
                                    <td><span class="fw-normal">{{ $item->home_team . ' vs ' . $item->away_team }}</span></td>
                                    <td><span class="fw-normal">{{ $item->odds > 0 ? '+' . $item->odds : $item->odds }}</span>
                                    </td>
                                    <td><span class="fw-normal"><button
                                                class="btn @if ($item->status == 1) btn-warning @else @if ($item->is_won == 1) btn-success @elseif($item->is_won == 0) btn-danger @elseif($item->is_won == 2) btn-warning @endif @endif"
                                                disabled>
                                                @if ($item->status == 1) Pending
                                                @else
                                                    @if ($item->is_won == 1) Won
                                                    @elseif($item->is_won == 0)
                                                        Lost
                                                    @elseif($item->is_won == 2)
                                                        Refunded @endif
                                                @endif
                                            </button></span></td>
                                    <td><span class="fw-normal">{{ $item->risk }}</span></td>
                                    <td><span
                                            class="fw-normal">{{ $item->is_won == 1 ? '+' . $item->to_win : '-' . $item->to_win }}</span>
                                    </td>
                                    <td><span class="fw-normal">{{ $item->created_at }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td>Not Subscribed or no picks available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        {{-- Recent Picks --}}
    @endauth

    {{-- Recent Picks --}}
    <section id="recent-picks" class="ranked-package-section pt-90 pb-90">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2>Recent Picks</h2>
                </div>
            </div>
            <div class="row mt-40">
                @if ($data->isEmpty())
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
                                    <td><span class="fw-normal">
                                            @if ($item->wagered_team == 'home_team')
                                                {{ $item->home_team }}
                                            @else
                                                {{ $item->away_team }} @endif
                                        </span></td>
                                    <td><span class="fw-normal">{{ $item->home_team . ' vs ' . $item->away_team }}</span>
                                    </td>
                                    <td><span
                                            class="fw-normal">{{ $item->odds > 0 ? '+' . $item->odds : $item->odds }}</span>
                                    </td>
                                    <td><span class="fw-normal"><button
                                                class="btn @if ($item->status == 1) btn-warning @else @if ($item->is_won == 1) btn-success @elseif($item->is_won == 0) btn-danger @elseif($item->is_won == 2) btn-warning @endif @endif"
                                                disabled>
                                                @if ($item->status == 1) Pending
                                                @else
                                                    @if ($item->is_won == 1) Won
                                                    @elseif($item->is_won == 0)
                                                        Lost
                                                    @elseif($item->is_won == 2)
                                                        Refunded @endif
                                                @endif
                                            </button></span></td>
                                    <td><span class="fw-normal">{{ $item->risk }}</span></td>
                                    <td><span
                                            class="fw-normal">{{ $item->is_won == 1 ? '+' . $item->to_win : '-' . $item->to_win }}</span>
                                    </td>
                                    <td><span class="fw-normal">{{ $item->created_at }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td>No recent picks</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </section>
    {{-- Recent Picks --}}

    <!-- Package Section -->
    <section id="packages" class="ranked-package-section pt-90 pb-90 text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Packages</h2>
                </div>
            </div>
            <div class="row mt-40">
                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
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
                    {{-- <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12"> --}}
                    <div class="packagebox_slider">
                        @foreach ($user->packages as $package)
                            <div class="packagebox">
                                <h2 class="texttitle">{{ $package->name }}</h2>
                                <p>
                                    {{ $package->description }}
                                </p>

                                <div class="redbox">
                                    <a href="{{ route('package', $package->id) }}">
                                        <button class="redboxbtn">
                                            <sup>Buy Now</sup>
                                            <span>${{ $package->price }}</span>
                                            <i></i>
                                            <sub>Terms*</sub>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                        {{-- </div> --}}
                    </div>

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
