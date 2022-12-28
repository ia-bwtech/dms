{{-- @dd($__data) --}}
@extends('layouts.front.app')

@section('header')
<style>
    .banner-section span { 
		display: inline-flex !important;
	}

	.leaderboard-pagination .pagination {
		justify-content: center;
	}

    .thumbnail-wrapper {
        margin: 0 5px;
    }
</style>
@endsection

@section('content')
<!-- Banner Section -->
<section id="banner" class="banner-section">
	<div class="container">
		<div class="row banner-row bg-white pt-96 pb-96">
			<div class="col-12 text-center">
				<h1><span class="prime-color">Social Media</span> <br></h1>
			</div>
		</div>
	</div>
</section>
<!-- Banner Section -->



{{-- <section id="handicapper" class="handicapper pt-120 pb-120 text-center">
    <div class="container">
        <widgetbot
        server="992447989912191166"
        channel="992538047583367258"
        width="1520"
        height="1200"
        ></widgetbot>
    </div>
</section> --}}

<div class="container">
    <!-- SnapWidget -->
    <div class="mb-5 mt-5 coachescall-heading">
        <h2 class="">Coachescall - Your home for coaching, betting and all things sports</h2>
        <a target="_blank" href="https://coachescall.store/"><img src="{{ asset('images/coachescall.png') }}" class="img-fluid mt-5" alt=""></a>
    </div>

    <div class="mb-5 mt-5 coachescall-heading">
        <h2 class="">WeWin Games - Sports Betting Made Easy</h2>
        <a target="_blank" href="https://www.wewingames.com/"><img src="{{ asset('images/wewingames.jpg') }}" class="img-fluid mt-5" alt=""></a>
    </div>
    
    <div class="">
        <h2 class="mb-5">Instagram</h2>
        <!-- SnapWidget -->
        <iframe src="https://snapwidget.com/embed/1008815" class="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden;  width:100%; "></iframe>
        <!-- SnapWidget -->
    </div>

    <!-- SnapWidget -->
    <div class="">
        <h2 class="mb-5 mt-5">Youtube</h2>
        <!-- SnapWidget -->
    <iframe src="https://snapwidget.com/embed/1008816" class="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden;  width:100%; "></iframe>
    </div>

    <!-- SnapWidget -->
    <div class="mb-5 text-center">
        <h2 class="mb-5 mt-5">Tiktok</h2>
        <!-- SnapWidget -->
        <iframe src="https://snapwidget.com/embed/1008821" class="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; border-radius:5px; width:500px; height:600px"></iframe>
    </div>

    <!-- SnapWidget -->
    <div class="mb-5 text-center">
        <h2 class="mb-5 mt-5">Twitter</h2>
        <!-- SnapWidget -->
        <iframe src="https://snapwidget.com/embed/1008834" class="snapwidget-widget" allowtransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden;  width:100%; "></iframe>
    </div>
</div>

@endsection

<script src="https://snapwidget.com/js/snapwidget.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script> --}}