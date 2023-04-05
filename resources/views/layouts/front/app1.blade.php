<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<!-- Required Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Blind Side Bets') }}</title>
	<!-- Required Meta Tags -->

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
	<!-- Favicon -->

	<!-- Css Links -->
	<!-- FontAwesome Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.min.css') }}">
	<!-- FontAwesome Css -->
	<!-- Bootsrap Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<!-- Bootsrap Css -->
	<!-- Stylesheet Css -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<!-- Stylesheet Css -->
	<!-- Responisve Css -->
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
	<!-- Responisve Css -->

	<!-- Css Links -->
</head>
<body>

<!-- Header -->
<header class="pt-40 pb-40">
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-expand-lg p-0">
    			<a class="navbar-brand" href="/"><img src="assets/images/header-logo.png" align="Logo" class="img-fluid"></a>
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="collapse navbar-collapse" id="navbarNav">
			     	<ul class="navbar-nav">
			        	<li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">Get Ranked</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">My Ranking</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">My Ranking</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">Ranked Packages</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">Free Play & Social Media</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">Reward</a></li>
			        	<li class="nav-item"><a class="nav-link" href="#">Forum</a></li>
			        	<li class="nav-item"><a class="nav-link login-btn prime-bg" href="#">Login / SignUp</a></li>
			      	</ul>
			    </div>
			</nav>
		</div>
	</div>
</header>
<!-- Header -->

<!-- Banner Section -->
<section id="banner" class="banner-section">
	<div class="container">
		<div class="row banner-row align-items-center justify-content-between">
			<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
				<span>Sign Up to become Handicap Verified.</span>
				<h1>Welcome To Blind Side Bets,<br>The <span class="prime-color">Amateur</span> & <span class="prime-color">Professional</span><br>Handicapper Network.</h1>
				<a class="custom-btn prime-bg" href="#">Get Started</a>
				<ul class="list-unstyled mb-0 custom-list">
					<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/tiktok-icon.png" alt="TikTok Icon" class="img-fluid"></a></li>
					<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/insta-icon.png" alt="Instagram Icon" class="img-fluid"></a></li>
					<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/twitter-icon.png" alt="Twitter Icon" class="img-fluid"></a></li>
					<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/youtube-icon.png" alt="Youtube Icon" class="img-fluid"></a></li>
				</ul>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 d-flex justify-content-end">
				<div class="banner-right-img">
					<img src="assets/images/banner-right-img.png" alt="Banner Image" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Banner Section -->

<!-- About Section -->
<section id="about" class="abt-section pt-120 pb-120">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<img src="assets/images/abt-img.png" alt="About Us" class="img-fluid">
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<h2>Overview</h2>
				<p class="mt-3">Welcome to the THE blindATL, The home of THE blind consensus<br>group with 22 years of professional documented success!    Here you<br>can purchase THE blindATL plays but also we challenge you to get<br>RANKED for free and beat our team to grow from an Amateur to a<br>Professional Handicapper yourself.</p>
				<p class="mt-4">Here you have the ability to track your own plays and get rated,<br>ranked per sport against your peers and then be marketed by THE<br>blindATL consensus group whereby you'll have the ability to create<br>and sell your own packages.</p>
				<a class="custom-btn prime-bg mt-5" href="#">Read More</a>
			</div>
		</div>
	</div>
</section>
<!-- About Section -->

<!-- Record Section -->
<section id="record" class="record-section pb-120">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
				<div class="record-head-box">
					<img src="assets/images/header-logo.png" alt="Logo" class="img-fluid">
					<h2>Records</h2>
				</div>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 d-flex justify-content-end">
				<div class="cat-select-box">
					<select id="cat-select">
						<option value="nbp">Nba</option>
						<option value="nbp">Nba</option>
						<option value="nbp">Nba</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row mt-30">
			<table>
				<thead>
					<tr>
						<th>Teams</th>
						<th>Records</th>
						<th>Pick Record</th>
						<th>Units Won</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Atlanta Hawks VS Boston Celtics</td>
						<td>0&nbsp; &nbsp; : &nbsp; &nbsp;0</td>
						<td>92-92-12</td>
						<td>+152.77</td>
					</tr>
					<tr>
						<td>Brooklyn Nets VS Charlotte Hornets</td>
						<td>0&nbsp; &nbsp; : &nbsp; &nbsp;1</td>
						<td>41-28</td>
						<td>+110.00</td>
					</tr>
					<tr>
						<td>Chicago Bulls VS Cleveland Cavaliers</td>
						<td>0&nbsp; &nbsp; : &nbsp; &nbsp;2</td>
						<td>110-66-10</td>
						<td>+321.82</td>
					</tr>
					<tr>
						<td>Dallas Mavericks VS Denver Nuggets</td>
						<td>0&nbsp; &nbsp; : &nbsp; &nbsp;3</td>
						<td>101-62-8</td>
						<td>+309.33</td>
					</tr>
					<tr>
						<td>Detroit Pistons VS Golden State Warriors</td>
						<td>0&nbsp; &nbsp; : &nbsp; &nbsp;4</td>
						<td>96-65-3</td>
						<td>+261.89</td>
					</tr>
					<tr>
						<td>Houston Rockets VS Indiana Pacers</td>
						<td>0&nbsp; &nbsp; : &nbsp; &nbsp;5</td>
						<td>26-24-1</td>
						<td>+9.42</td>
					</tr>
			</table>
		</div>
	</div>
</section>
<!-- Record Section -->

<!-- Package Section -->
<section id="package" class="package-section pt-120 pb-120">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="record-head-box">
					<img src="assets/images/header-logo.png" alt="Logo" class="img-fluid">
					<h2>Records</h2>
				</div>
			</div>
		</div>
		<div class="row mt-60">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="package-box">
					<h3 class="text-center">Click Here To Buy <span class="prime-color">Daily</span></h3>
					<span class="prime-color">$ 15.00</span>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="package-box">
					<h3 class="text-center">Click Here To Buy <span class="prime-color">Weekly</span></h3>
					<span class="prime-color">$ 25.00</span>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<div class="package-box">
					<h3 class="text-center">Click Here To Buy <span class="prime-color">Monthly</span></h3>
					<span class="prime-color">$ 150.00</span>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Package Section -->

<!-- Top Section -->
<section id="top" class="top-section pt-120 pb-120">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<h2>Top 10 Handicapper </h2>
			</div>
		</div>
		<div class="row mt-30">
			<table class="top">
				<thead>
					<tr>
						<th>Icons</th>
						<th>Rank</th>
						<th>Handicapper</th>
						<th>Win</th>
						<th>Losses</th>
						<th>Units Won</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><img src="assets/images/big-al-mcmordie.png"></td>
						<td>01</td>
						<td>Big Al McMordie</td>
						<td>407</td>
						<td>317</td>
						<td>+152.77</td>
					</tr>
					<tr>
						<td><img src="assets/images/calvin-king.png"></td>
						<td>02</td>
						<td>Calvin King</td>
						<td>510</td>
						<td>450</td>
						<td>+110.00</td>
					</tr>
					<tr>
						<td><img src="assets/images/black-widow.png"></td>
						<td>03</td>
						<td>Black Widow</td>
						<td>345</td>
						<td>284</td>
						<td>+321.82</td>
					</tr>
					<tr>
						<td><img src="assets/images/steve-janus.png"></td>
						<td>04</td>
						<td>Steve Janus</td>
						<td>339</td>
						<td>284</td>
						<td>+309.33</td>
					</tr>
					<tr>
						<td><img src="assets/images/calvin-king.png"></td>
						<td>05</td>
						<td>Jack Jones</td>
						<td>308</td>
						<td>247</td>
						<td>+261.89</td>
					</tr>
					<tr>
						<td><img src="assets/images/big-al-mcmordie.png"></td>
						<td>06</td>
						<td>Mark Wilson</td>
						<td>499</td>
						<td>453</td>
						<td>+9.42</td>
					</tr>
					<tr>
						<td><img src="assets/images/black-widow.png"></td>
						<td>07</td>
						<td>Timothy Balck</td>
						<td>278</td>
						<td>251</td>
						<td>+321.82</td>
					</tr>
					<tr>
						<td><img src="assets/images/steve-janus.png"></td>
						<td>08</td>
						<td>Scott Rickenbach</td>
						<td>331</td>
						<td>288</td>
						<td>+309.33</td>
					</tr>
					<tr>
						<td><img src="assets/images/calvin-king.png"></td>
						<td>09</td>
						<td>Kevin Young</td>
						<td>488</td>
						<td>424</td>
						<td>+261.89</td>
					</tr>
					<tr>
						<td><img src="assets/images/calvin-king.png"></td>
						<td>10</td>
						<td>Sal Michals</td>
						<td>360</td>
						<td>310</td>
						<td>+9.42</td>
					</tr>
			</table>
		</div>
	</div>
</section>
<!-- Top Section -->

<!-- Footer -->
<footer>
	<div class="footer-wrap">
		<div class="container">
			<div class="row">
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 first-col">
					<img src="assets/images/footer-logo.png" alt="Footer Logo" class="img-fluid">
					<p class="mt-4 mb-4">Lorem Ipsum is simply dummy text of the<br>printing and typesetting industry.</p>
					<ul class="list-unstyled mb-0 custom-list">
						<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/tiktok-icon.png" alt="TikTok Icon" class="img-fluid"></a></li>
						<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/insta-icon.png" alt="Instagram Icon" class="img-fluid"></a></li>
						<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/twitter-icon.png" alt="Twitter Icon" class="img-fluid"></a></li>
						<li><a href="#" target="_blank" rel="nofollow"><img src="assets/images/youtube-icon.png" alt="Youtube Icon" class="img-fluid"></a></li>
					</ul>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 second-col">
					<h2>Quick Links</h2>
					<ul class="list-unstyled mb-0">
						<li><a href="/">Home</a></li>
						<li><a href="#">Get Ranked</a></li>
						<li><a href="#">My Ranking</a></li>
						<li><a href="#">Leader Board</a></li>
					</ul>
					<ul class="list-unstyled mb-0">
						<li><a href="#">Ranked Packages</a></li>
						<li><a href="#">Free Play</a></li>
						<li><a href="#">Reward</a></li>
						<li><a href="#">Forum</a></li>
					</ul>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 third-col">
					<h2>Contact Info</h2>
					<ul class="list-unstyled mb-0">
						<li><i class="fa-solid fa-envelope"></i><a href="mailto:info@blindsidebets.com">info@blindsidebets.com</a></li>
						<li><i class="fa-solid fa-phone"></i><a href="tel:12231123111">+1 223 1123 111</a></li>
					</ul>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 fourth-col">
					<h2>Newsletter</h2>
					<form action="" method="post" class="newsletter-form">
						<div class="row">
							<div class="col-12 form-group">
								<input type="email" name="email" class="form-control" placeholder="Email" required>
							</div>
							<div class="col-12 form-group">
								<button type="submit" value="submit" class="form-control prime-bg">Subscribe</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<p class="mb-0">Copyright 2022 © Blind Side Bets, All Rights Reserved.</p>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex justify-content-end">
					<ul class="list-unstyled mb-0">
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Terms of Service</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer -->

<!-- Required Js Files -->

<!-- Jquery Js -->
<script src="assets/js/jquery-3.4.1.min.js"></script>
<!-- Jquery Js -->
<!-- Bootstrap Js -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- Bootstrap Js -->
<!-- FontAwesome Js -->
<script src="assets/js/all.min.js"></script>
<!-- FontAwesome Js -->
<!-- Function Js -->
<!-- <script src="assets/js/function.js"></script> -->
<!-- Function Js -->

<!-- Required Js Files -->
</body>
</html>
