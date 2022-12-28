@extends('layouts.front.app')

@section('content')

<!-- Banner Section -->
<section id="banner" class="banner-section mb-5">
	<div class="container">
		<div class="row banner-row bg-white pt-96 pb-96">
			<div class="col-12 text-center">
				<h1>Tournaments</h1>
			</div>
		</div>
	</div>
</section>
<!-- Banner Section -->

<section id="banner" class="banner-section profile-section pt-60 pb-60">
	<div class="container">
		<div class="row banner-row justify-content-center pt-70 pb-70 bg-white">
			<div class="col-12">
				<div class="card position-relative">	
					<img src="{{ asset('images/tournament-1.jpg') }}" alt="">
			    </div>
		    </div>
	    </div>
		<div class="row banner-row justify-content-center pt-70 pb-70 bg-white mt-10" style="margin-top: 10px;">
			<div class="col-12">
				<div class="card position-relative">	
					<img src="{{ asset('images/tournament-2.jpg') }}" alt="">
			    </div>
		    </div>
	    </div>
		<div class="row banner-row justify-content-center pt-70 pb-70 bg-white mt-10" style="margin-top: 10px;">
			<div class="col-12">
				<div class="card position-relative">	
					<img src="{{ asset('images/tournament-3.jpg') }}" alt="">
			    </div>
		    </div>
	    </div>
    </div>
</section>

@endsection