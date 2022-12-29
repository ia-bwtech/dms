{{-- \resources\views\welcome.blade.php --}}
@extends('layouts.front.app')

@section('content')
    <div id="app">
        <!-- Banner Section -->
        <!--        <section id="banner" class="banner-section banner-home">
                            <div class="container">
                                @if (session('error'))
    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
    @endif
                                <div class="row banner-row align-items-center justify-content-between">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark text-center">
                                        @guest
                                                            <span>Sign Up to become Handicap Verified.</span>
                                        @endguest
                                        <h3>Welcome To Blind Side Bets</h3>
                                        <h1>The #1 Handicapper Verification Network</h1>
                                        @guest
                                                            <a class="custom-btn prime-bg" href="#howtouse">Learn More</a>
                                        @endguest
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid zindexback">
                                <div class="row bannerimg-row">
                                    <img src="/assets/images/bannerimg1.jpg">
                                </div>
                            </div>

                        </section> -->
        <!-- home Banner Section -->
        <section id="banner" class="banner-section banner-row banner-row-home">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Welcome To Blind Side Bets</h1>
                        <h2>The #1 Handicapper</h2>
                        <h3>Verification Network</h3>
                        <a class="btn-borderred" href="#howtouse">Explore More</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- home end Banner Section -->

        <!-- Banner Section -->

        <!-- boxsection Section -->
        <section id="boxsection" class="boxsection">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div
                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center justify-content-between headsection">
                        <h2>Which type of <span>winner</span> are you?</h2>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="bgbox">
                            <a class="btn-blue" href="/">Handicapper</a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row handicapper-col">
                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <p>Track your bets<br> Leaderboard tournaments<br> Sell betting packages</p>

                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <a class="btn-borderred" href="{{ route('handicapper.signup') }}">Get Started</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center second-sport-row ">

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="row sports-bettor-col">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <a class="btn-borderred" href="{{ route('handicapper.signup') }}">Get Started</a>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <p>Buy plays from verified cappers<br> View handicapper betting history<br> Increase your
                                    ROI</p>

                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="bgbox">
                            <a class="btn-blue btn-cus-gra" href="/">Sports Bettor</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- boxsection Section -->



        <!-- Handicappers Section -->
        <section id="Handicappers" class="Handicappers">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div
                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center justify-content-between headsection">
                        <h2>Featured Handicappers</h2>
                    </div>
                    <div id="handicappers_slider" class="handicappers_slider">
                        @foreach ($featuredHandicappers as $item)
                            <a href="{{ route('handicappers.profile', $item['user_id']) }}">
                                <div class="handicap-item">
                                    <div class="handicap-img">
                                        <img src="/images/profile/{{ $item['image'] }}" style="width: 90%; height:180px;">
                                    </div>
                                    <h3>{{ $item['name'] }}</h3>
                                    <span class="desc">Records</span>
                                    <div class="winlosses">
                                        <span>Wins : {{ $item['wins'] }}</span>
                                        <span class="barline"></span>
                                        <span>Losses : {{ $item['losses'] }}</span>
                                    </div>
                                    <div class="unitswon">
                                        <span>Units Won : {{ $item['net_units'] }}</span>
                                        <span>ROI : {{ $item['roi'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach


                    </div>
                </div>
            </div>
        </section>
        <!-- Handicappers Section -->






        <!-- Top Section -->
        <top-sports></top-sports>
        <!-- Top Section -->



        <!-- boxsection Section -->
        <section id="howtouse" class="howtouse">
            <div class="container-fluid">
                <div class="row align-items-center howtouse-video">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2>How to <span>use the website?</span></h2>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                            alteration in<br> some form, by injected humour, or randomised word.</p>
                        <!-- <video class="howtouseimg" width="100%" height="100%" controls="controls"
                                            poster="/assets/images/howtouseimg.jpg">
                                            <source src="https://www.blindsidebets.com/videos/blindsidebets.mp4" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video> -->
                        <div class="howtousevideoplay">
                            <img src="/assets/images1/howtousevideo.png" class="howtouseimg">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- boxsection Section -->




        <!-- boxsection Section -->
        <!-- Blind Side Bets - Lyman Philips 'sign up as a sports bettor?' end Section -->



    </div>
@endsection
