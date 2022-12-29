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
</style>
@endsection

@section('content')
<!-- Banner Section -->
<section id="banner" class="banner-section">
	<div class="container">
		<div class="row banner-row bg-white pt-96 pb-96">
			<div class="col-12 text-center">
				<h1><span class="prime-color">BLINDSIDEBETS Forum powered by Coachescall</span> <br></h1>
			</div>
		</div>
	</div>
</section>
<!-- Banner Section -->

{{-- Hunch Server --}}
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

{{-- CoachesCall Server --}}
<section id="handicapper" class="handicapper pt-120 pb-120 text-center">
    <div class="container">
        <widgetbot
        server="934979108352434256"
        channel="1041865963898937486"
        width="1520"
        height="1200"
        ></widgetbot>
    </div>
</section>

@endsection

<script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
