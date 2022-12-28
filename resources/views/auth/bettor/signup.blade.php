@extends('layouts.front.app')

@section('content')

    <div id="app">


        <!-- Banner Section1 -->
        <section id="banner" class="banner-section banner-home">
            <div class="container">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row banner-row align-items-center justify-content-between">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark text-center">
                        <h3>Join the #1 Handicapper</h3>
                        <h1>Verification Network</h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid zindexback">
                <div class="row bannerimg-row">
                    <img src="{{ asset('assets/images/sportsbettorbanner1.jpg') }}">
                </div>
            </div>
        </section>
        <!-- ./Banner Section -->
        <!-- boxsection Section1 -->
        <section id="boxsection" class="boxsection boxsection2 text-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <div class="bgbox">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                                class="refformnew">
                                @csrf
                                <span class="boxtitle">Registration Form</span>
                                <input required type="text" name="name" placeholder="Name">
                                @error('name')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                                <input required type="text" name="email" placeholder="Email Adress">
                                @error('email')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                                <input required type="password" name="password" placeholder="Password">
                                @error('password')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                                <input required type="password" name="password_confirmation" placeholder="Confirm Password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                                <input required id="file12" accept="image/png, image/jpeg" type="button"
                                    value="Profile Icon" style="color: #9b9b9b" onclick="openFileDialogue()">
                                <input id="file1" class="d-none" required accept="image/png, image/jpeg" type="file"
                                    name="image" placeholder="Profile Icon" value="Profile Icon" style="color: #9b9b9b">
                                @error('image')
                                    <div class="invalid-feedback"> {{ $message }} </div>
                                @enderror

                                <p class="terms">By signing up you agree to the <a href="/terms" class="terms">Terms and Conditions</a></p>
                                <input type="hidden" name="is_handicapper" value="0">
                                <button type="submit" class="btn-borderred">Get Started</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 textullisec text-left">
                            <h2 class="texttitle">Why sign up as a sports bettor?</h2>
                            <ul>
                                <li>Access verified & transparent handicappers</li>
                                <li>View handicappers ROI</li>
                                <li>View handicappers units won</li>
                            </ul>
                            <img src="{{ asset('assets/images/videothumnil1.jpg') }}" class="videothumnil">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ./boxsection Section1 -->
        {{--
<!-- Banner Section2 -->
<section id="banner" class="banner-section banner-home">
  <div class="container">
    @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif
    <div class="row banner-row align-items-center justify-content-between">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark text-center">
        <h3>Join the #1 Handicapper</h3>
        <h1>Verification Network</h1>
      </div>
    </div>
  </div>

  <div class="container-fluid zindexback">
    <div class="row bannerimg-row">
      <img src="{{asset('assets/images/handicapperbanner1.jpg')}}">
    </div>
  </div>
</section>
<!-- ./Banner Section -->
<!-- boxsection Section2 -->
<section id="boxsection" class="boxsection boxsection2 text-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <div class="bgbox">
          <form action="" method="post" class="refformnew">
            <span class="boxtitle">Registration Form</span>
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="emailadress" placeholder="Email Adress">
            <input type="text" name="password" placeholder="Password">
            <input type="text" name="confirmpassword" placeholder="Confirm Password">
            <input type="text" name="profileicon" placeholder="Profile Icon">
            <button type="submit" class="btn-borderred">Get Started</button>
          </form>
        </div>
      </div>
      <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 textullisec text-left">
          <h2 class="texttitle">Why sign up as a sports bettor?</h2>
          <ul>
            <li>Track your bets</li>
            <li>Leaderboard tournaments</li>
            <li>Sell betting packages</li>
            <li>Cash prizes every 2 weeks</li>
          </ul>
          <img src="{{asset('assets/images/videothumnil1.jpg')}}" class="videothumnil">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ./boxsection Section2 -->


<!-- Banner Section3 -->
<section id="banner" class="banner-section banner-home">
  <div class="container">
    @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif
    <div class="row banner-row align-items-center justify-content-between">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark text-center">
        <h3>Welcome, Username</h3>
        <h1>You are now a handicapper!</h1>
      </div>
    </div>
  </div>

  <div class="container-fluid zindexback">
    <div class="row bannerimg-row">
      <img src="{{asset('assets/images/capperbanner1.jpg')}}">
    </div>
  </div>
</section>
<!-- ./Banner Section -->
<!-- boxsection Section3 -->
<section id="boxsection" class="boxsection boxsection2 text-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="bgbox">
          <h2 class="boxtitle">Quick Links</h2>
          <ul>
            <li><a class="link" href="">My Bets</a></li>
            <li><a class="link" href="">Create Packages</a></li>
            <li><a class="link" href=""> Payment Setup</a></li>
            <li><a class="link" href="">Leaderboard</a></li>
          </ul>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 align-items-center">
        <img src="{{asset('assets/images/videothumnil1.jpg')}}" class="videothumnil">
      </div>
    </div>
  </div>
</section>
<!-- ./boxsection Section3 -->


<!-- Banner Section4 -->
<section id="banner" class="banner-section banner-home">
  <div class="container">
    @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif
    <div class="row banner-row align-items-center justify-content-between">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark text-center">
        <h3>Welcome, Username</h3>
        <h1>You are now a sports bettor! </h1>
      </div>
    </div>
  </div>

  <div class="container-fluid zindexback">
    <div class="row bannerimg-row">
      <img src="{{asset('assets/images/bettortanner1.jpg')}}">
    </div>
  </div>
</section>
<!-- ./Banner Section -->
<!-- boxsection Section4 -->
<section id="boxsection" class="boxsection boxsection2 text-center">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="bgbox">
          <h2 class="boxtitle">Quick Links</h2>
          <ul>
            <li><a class="link" href="">Buy Packages</a></li>
            <li><a class="link" href="">Top 5 Leaderboard</a></li>
            <li><a class="link" href="">General Leaderboard</a></li>
            <li><a class="link" href="">My Profile</a></li>
          </ul>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 align-items-center">
        <img src="{{asset('assets/images/videothumnil1.jpg')}}" class="videothumnil">
      </div>
    </div>
  </div>
</section>
<!-- ./boxsection Section4 -->





<!-- boxsection Section2 -->
<section id="boxsection" class="boxsection boxsection3 ">
  <div class="container">
    <div class="row">
      <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <div class="bgbox">
          <form action="" method="post" class="refformnew">
            <span class="boxtitle">Create Account</span>
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="emailadress" placeholder="Email Adress">
            <input type="text" name="password" placeholder="Password">
            <input type="text" name="confirmpassword" placeholder="Confirm Password">
            <input type="text" name="profileicon" placeholder="Profile Icon">
            <button type="submit" class="btn-borderred">Get Started</button>
          </form>
        </div>
      </div>
      <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12 colspcbw">
        <img src="{{asset('assets/images/header-logo-blk.png')}}" class="logocenter">
        <img src="{{asset('assets/images/girlpic1.jpg')}}" class="girlpic1">
      </div>
    </div>
  </div>
</section>
<!-- ./boxsection Section2 -->

 --}}

        <script>
            function openFileDialogue() {
                document.getElementById("file1").click();
                $('#file12').val('File Selected')
            }
        </script>



    </div>

@endsection
