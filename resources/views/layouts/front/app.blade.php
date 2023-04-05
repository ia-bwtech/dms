{{-- \resources\views\layouts\front\app.blade.php --}}
{{-- @dd(auth()->user()->hasRole('admin')) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @auth

    @if (auth()->user()->is_admin == 1)
        @php
            $route = route('admins.dashboard.index');
        @endphp
    @elseif(auth()->user()->is_handicapper == 1)
        @php
            $route = route('handicapperscrm.dashboard.index');
        @endphp
    @else
        @php
            $route = route('bettorscrm.dashboard.index');
        @endphp
    @endif
@endauth
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-BSM2QDM');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Blind Side Bets') }}</title>

    <!-- Favicon -->
	<link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
	<!-- Favicon -->

	<!-- Css Links -->
	<!-- FontAwesome Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.min.css') }}">
	<!-- FontAwesome Css -->

    <!-- Slick Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}">
    <!-- Slick Css -->

	<!-- Bootsrap Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<!-- Bootsrap Css -->

    <!-- Responisve Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
	<!-- Responisve Css -->

    <!-- Stylesheet Css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
	<!-- Stylesheet Css -->


	<!-- Css Links -->

    @yield('header')
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-BSM2QDM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Header -->
    <header class="headermain">
        <div class="container-fluid ps-5 pe-5">
            <div class="row">
                <nav class="navbar navbar-expand-lg p-0">
                    <a class="navbar-brand" href="/"><img src="{{ asset('assets/images1/logo12.png') }}" align="Logo" class="img-fluid"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            {{-- <li class="nav-item"><a class="nav-link @if(request()->url()==url('/')) active @endif" href="/">Home</a></li> --}}
                            {{-- @guest --}}
                            {{-- <li class="nav-item"><a class="nav-link @if(request()->url()==url('/login')) active @endif" href="/login">Get Ranked</a></li> --}}
                            {{-- @endguest --}}
                            <li class="nav-item"><a class="nav-link @if(request()->url()==url('/my-ranking')) active @endif" href="/my-ranking">My Bets</a></li>
                            <li class="nav-item"><a class="nav-link @if(request()->url()==url('/leaderboard')) active @endif" href="/leaderboard">Leaderboard</a></li>
                            {{-- <li class="nav-item"><a class="nav-link @if(request()->url()==url('/packages')) active @endif" href="/packages">Ranked Packages</a></li> --}}
                            {{-- <li class="nav-item"><a class="nav-link @if(request()->url()==url('/socials')) active @endif" href="/socials">Social Media and Partner Offers</a></li> --}}
                            <li class="nav-item"><a class="nav-link @if(request()->url()==route('front.packages')) active @endif" href="{{route('front.packages')}}">Packages</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Explore More
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    {{-- <li><a class="dropdown-item @if(request()->url()==url('/tournaments')) active @endif" href="/tournaments">Handicapper Tournaments</a></li> --}}
                                    <li><a class="dropdown-item @if(request()->url()==url('/historical-records')) active @endif" href="/historical-records">Historical Records</a></li>
                                    {{-- <li><a class="dropdown-item @if(request()->url()==url('/forum')) active @endif" href="/forum">Forum</a></li> --}}
                                    <li><a class="dropdown-item @if(request()->url()==url('/faq')) active @endif" href="/faq">FAQ</a></li>
                                    <li><a class="dropdown-item @if(request()->url()==url('/blog-listing')) active @endif" href="/blog-listing">News and Articles</a></li>


                                </ul>
                            </li>

                            {{-- <li class="nav-item"><a class="nav-link @if(request()->url()==url('/forum')) active @endif" href="/forum">Forum</a></li> --}}
                            {{-- <li class="nav-item"><a class="nav-link @if(request()->url()==url('/')) active @endif" href="#">FAQ</a></li> --}}

                            @auth
                            {{-- Mobile Dashboard --}}
                            <li class="nav-item dropdown login-btn  mobiledashboardbtn">

                                <a class="nav-link dropdown-toggle" href="{{ $route }}" id="navbarDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dashboard
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @role('admin')
                                        <li><a class="dropdown-item @if (request()->routeIs('admin.dashboard')) active @endif"
                                                href="{{ route('admin.dashboard') }}">Dashboard Home</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('admin.handicappers')) active @endif"
                                                href="{{ route('admin.handicappers') }}">Handicappers</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('faqs')) active @endif"
                                                href="{{ route('faqs') }}">FAQs</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('admin.bets')) active @endif"
                                                href="{{ route('admin.bets') }}">All Bets</a></li>
                                    @endrole
                                    @role('user')
                                        <li><a class="dropdown-item @if (request()->routeIs('user.dashboard')) active @endif"
                                                href="{{ route('user.dashboard') }}">Dashboard Home</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('user.packages')) active @endif"
                                                href="{{ route('user.packages') }}">Packages</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('user.payments')) active @endif"
                                                href="{{ route('user.payments') }}">Payments Setup</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('user.bets')) active @endif"
                                                href="{{ route('user.bets') }}">My Bets</a></li>
                                        <li><a class="dropdown-item @if (request()->routeIs('user.subscribers')) active @endif"
                                                href="{{ route('user.subscribers') }}">My Subscribers</a></li>
                                    @endrole
                                </ul>
                            </li>

                            {{-- Admin Dashboard --}}
                            <li class="nav-item desktopdashboardbtn"><a class="nav-link login-btn prime-bg"
                                href="{{ $route }}">Dashboard</a></li>
                            <li class="nav-item">
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                    {{ __('Log Out') }}
                                </a>
                            </li>
                            @endauth
                            @guest
                            <li class="nav-item"><a class="nav-link login-btn prime-bg" href="/login">Login</a></li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <!-- Header -->

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="footer-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 first-col">
                        <img src="{{ asset('assets/images1/logo-footer.png') }}" alt="Footer Logo" class="img-fluid">
                        <p class="mt-4 mb-4">The Amateur & Professional Sports better Verification Network</p>
                        <ul class="list-unstyled mb-0 custom-list">
                            <li><a href="https://www.tiktok.com/@blindsidebets" target="_blank" rel="nofollow"><img src="{{ asset('assets/images/tiktok-icon.png') }}" alt="TikTok Icon" class="img-fluid"></a></li>
                            <li><a href="https://instagram.com/blindsidebets" target="_blank" rel="nofollow"><img src="{{ asset('assets/images/insta-icon.png') }}" alt="Instagram Icon" class="img-fluid"></a></li>
                            <li><a href="https://twitter.com/BLINDSIDEBETS" target="_blank" rel="nofollow"><img src="{{ asset('assets/images/twitter-icon.png') }}" alt="Twitter Icon" class="img-fluid"></a></li>
                            <li><a href="https://www.youtube.com/channel/UCxIHE3MLFgWITrDmMmDlHfg" target="_blank" rel="nofollow"><img src="{{ asset('assets/images/youtube-icon.png') }}" alt="Youtube Icon" class="img-fluid"></a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 second-col">
                        <h2>Quick Links</h2>
                        <ul class="list-unstyled mb-0">
                            <li><a href="/">Home</a></li>
                            {{-- <li><a href="get-ranked">Get Ranked</a></li> --}}
                            <li><a href="/my-ranking">My Profile</a></li>
                        </ul>
                        <ul class="list-unstyled mb-0">
                            {{-- <li><a href="#">Ranked Packages</a></li> --}}
                            {{-- <li><a href="#">Free Play</a></li> --}}
                            {{-- <li><a href="#">Reward</a></li> --}}
                            <li><a href="/leaderboard">Leader Board</a></li>
                            <li><a href="/faq">FAQ</a></li>
                            <li><a href="/forum">Forum</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 third-col">
                        <h2>Contact Info</h2>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fa-solid fa-envelope"></i><a href="mailto:admin@blindsidebets.com">admin@blindsidebets.com</a></li>
                            <li><i class="fa-solid fa-phone"></i>
                                <p>If you or someone you know has a gambling problem and wants help, call</p>
                                <a href="tel:1800GAMBLER">1-800-GAMBLER</a></li>
                        </ul>
                    </div>
                    {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 fourth-col">
                        <h2>Newsletter</h2>
                        <form onsubmit="return alert('Thank you');" action="" method="get" class="newsletter-form">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-12 form-group">
                                    <button type="submit" value="submit" class="form-control prime-bg">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
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
                            <li><a href="/terms">Terms and Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer -->

    <!-- Required Js Files -->

    <!-- Vue.js Js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Vue.js Js -->

    <!-- Jquery Js -->
    <script src="{{ asset('assets/js/jquery-3.4.1.min.js') }}"></script>
    <!-- Jquery Js -->
    <!-- Bootstrap Js -->
    {{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> --}}
    <!-- Bootstrap Js -->

    <!-- Bootstrap Js -->
    {{-- <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script> --}}
    <!-- Bootstrap Js -->

    <!-- FontAwesome Js -->
    <script src="{{ asset('assets/js/all.min.js') }}"></script>
    <!-- FontAwesome Js -->

    <!-- Function Js -->
    <script src="{{ asset('assets/js/function.js') }}"></script>
    <!-- Function Js -->

    <!-- Slick Js -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>
    <!-- Slick Js -->

    <!-- Required Js Files -->
</body>

</html>
