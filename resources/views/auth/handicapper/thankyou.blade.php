@extends('layouts.front.app')

@section('content')
    <div id="app">

        <section id="banner" class="banner-section banner-row height-auto sports-bettor-banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <img src="/assets/images1/whitewalilarki.png" class="sportsbettor-left-img">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h2>Welcome, {{ auth()->user()->name }}</h2>
                        <h3>You're now a handicapper</h3>
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

                                    <a class="btn-blue-1" href="{{ route('user.my-ranking') }}">My Bets</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="capperconfirmbox">
                                    <a class="btn-blue-2" href="{{ route('user.packages') }}">Create packages</a>
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
                                    <a class="btn-blue-3" href="{{ route('user.payments') }}">payment setup</a>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="capperconfirmbox">
                                    <a class="btn-blue-4" href="{{ route('handicappers.leaderboard') }}">Leaderboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
