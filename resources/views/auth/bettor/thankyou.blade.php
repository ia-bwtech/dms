@extends('layouts.front.app')

@section('content')
    <div id="app">

        <section id="banner" class="banner-section banner-row height-auto sports-bettor-banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h2>Welcome, {{ auth()->user()->name }}</h2>
                        <h3>You're now a sports bettor</h3>

                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <img src="/assets/images1/whitewalilarki.png" class="sportsbettor-left-img">
                    </div>

                </div>
            </div>
        </section>
        <!-- Capper - Confirm  Section -->
        <section id="capperconfirm" class="capperconfirm-sec">
            <div class="row">
                <div class="capperconfirm-row">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="capperconfirmbox">


                                    <a class="btn-blue-1" href="{{route('user.packages')}}">Buy Packages</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="capperconfirmbox">
                                    <a class="btn-blue-2" href="{{route('handicappers.leaderboard')}}#handicapper">Top 5 Leaderboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="capperconfirm-row">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="capperconfirmbox">
                                    <a class="btn-blue-3" href="{{route('profile.show')}}">My Profile</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="capperconfirmbox">
                                    <a class="btn-blue-4" href="{{ route('handicappers.leaderboard') }}">General Leaderboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

