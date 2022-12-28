{{-- \resources\views\welcome.blade.php --}}
@extends('layouts.front.app')

@section('content')
    <div id="app">
        <!-- Banner Section -->
        <section id="banner" class="banner-section banner-home">
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
                        <h3>Welcome To The Hunch ATL</h3>
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

        </section>
        <!-- Banner Section -->

        <!-- boxsection Section -->
        <section id="boxsection" class="boxsection">
            <div class="container">
                <div class="row align-items-center">
                    <div
                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center justify-content-between headsection">
                        <h2>What is TheHunchATL?</h2>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="bgbox">
                            <a class="btn-blue" href="/">Handicapper</a>
                            <ul>
                                <li>Track your bets</li>
                                <li>Leaderboard tournaments</li>
                                <li>Sell betting packages</li>
                            </ul>
                            <a class="btn-borderred" href="{{ route('handicapper.signup') }}">Get Started</a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="bgbox">
                            <a class="btn-blue" href="/">Sports Bettor</a>
                            <ul>
                                <li>Buy plays from verified cappers</li>
                                <li>View handicapper betting history</li>
                                <li>Increase your ROI</li>
                            </ul>
                            <a class="btn-borderred" href="{{ route('bettor.signup') }}">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- boxsection Section -->



        <!-- Handicappers Section -->
        <section id="Handicappers" class="Handicappers pt-55 pb-55">
            <div class="container">
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
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h2>How to use the website?</h2>
                        <p>Quick Start Guide - Please Open Video Tutorial on Navigation of TheHunchATL website.</p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <video class="howtouseimg" width="100%" height="100%" controls="controls"
                            poster="/assets/images/howtouseimg.jpg">
                            <source src="https://www.thehunchatl.com/videos/thehunchatl.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        {{-- <img src="/assets/images/howtouseimg.jpg" class="howtouseimg"> --}}
                    </div>
                </div>
            </div>
        </section>
        <!-- boxsection Section -->




    </div>
@endsection
