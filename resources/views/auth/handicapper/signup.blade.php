@extends('layouts.front.app')

@section('content')
    <div id="app">
        <!-- Handicapper - Registration Page Banner Section -->
        <section id="banner" class="banner-section banner-row sports-bettor-banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <h2>Join The #1 Handicapper</h2>
                        <h3>Verification Network</h3>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <img src="/assets/images1/handicapperregistrationright.png" class="sportsbettor-left-img">
                    </div>

                </div>
            </div>
        </section>
        <!-- Handicapper - Registration Page end Banner Section -->
        <!-- Banner Section -->

        <!-- Blind Side Bets - Lyman Philips Why 'sign up as a sports bettor?'  Section -->
        <section id="sports-bettor-sec" class="howtouse">
            <div class="container-fluid">
                <div class="row align-items-center howtouse-video">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2>Why sign up as a <span>handicapper?</span></h2>

                        <!-- <video class="howtouseimg" width="100%" height="100%" controls="controls"
                                            poster="/assets/images/howtouseimg.jpg">
                                            <source src="https://www.blindsidebets.com/videos/blindsidebets.mp4" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video> -->
                    </div>
                </div>

                <div class="row align-items-center sportsbettor-row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sportsbettor-box">
                            <img src="/assets/images1/user.png" class="howtouseimg">
                            <h4>Track Your<br>
                                bet</h4>
                        </div>


                        <div class="sportsbettor-box">
                            <img src="/assets/images1/return-on-investment.png" class="howtouseimg">
                            <h4>Leaderboard<br>
                                tournaments</h4>
                        </div>

                        <div class="sportsbettor-box box-s-r">
                            <img src="/assets/images1/award.png" class="howtouseimg">
                            <h4>Sell<br>
                                Betting Packages</h4>
                        </div>
                        <div class="sportsbettor-box box-s-r">
                            <img src="/assets/images1/award.png" class="howtouseimg">
                            <h4>Cash prizes<br>
                                every two weeks</h4>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center howtouse-video">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="howtousevideoplay">
                            <img src="/assets/images1/howtousevideo.png" class="howtouseimg">
                        </div>
                        <div class="registration-form">
                            <h3>Registration Form</h3>
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" required type="text" name="name" placeholder="Name">
                                    @error('name')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required type="text" name="email"
                                        placeholder="Email Adress">
                                    @error('email')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required type="password" name="password"
                                        placeholder="Password">
                                    @error('password')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                    <input type="hidden" name="is_handicapper" value="1">

                                </div>
                                <div class="form-group">
                                    <input class="form-control" required type="password" name="password_confirmation"
                                        placeholder="Confirm Password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" name="referral_code" placeholder="Referral Code (Optional)">
                                    @error('referral_code')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required id="file12" accept="image/png, image/jpeg"
                                        type="button" value="Profile Icon" style="color: #9b9b9b"
                                        onclick="openFileDialogue()">
                                    <input id="file1" class="d-none" required accept="image/png, image/jpeg"
                                        type="file" name="image" placeholder="Profile Icon" value="Profile Icon"
                                        style="color: #9b9b9b">
                                    @error('image')
                                        <div class="invalid-feedback"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Get Started</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </section>

        <script>
            function openFileDialogue() {
                document.getElementById("file1").click();
                $('#file12').val('File Selected')
            }
        </script>



    </div>
@endsection
