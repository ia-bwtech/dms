@extends('layouts.front.app')

@section('content')

<div id="app">

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
              <li><a class="link" href="{{route('user.my-ranking')}}">My Bets</a></li>
              <li><a class="link" href="{{route('user.packages')}}">Create Packages</a></li>
              <li><a class="link" href="{{route('user.payments')}}"> Payment Setup</a></li>
              <li><a class="link" href="{{route('handicappers.leaderboard')}}">Leaderboard</a></li>
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




</div>

@endsection
