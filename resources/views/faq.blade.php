@extends('layouts.front.app')

@section('content')

<!-- Banner Section -->
<section id="banner" class="banner-section">
	<div class="container">
		<div class="row banner-row bg-white pt-96 pb-96">
			<div class="col-12 text-center">
				<h2>FAQ</h2>
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
					<div class="accordion" id="accordionExample">
                        @forelse ($data as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}" aria-expanded="true" aria-controls="collapseOne">
                                {{ $item->name }}
                            </button>
                            </h2>
                            <div id="collapse{{ $item->id }}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {{ $item->description }}
                            </div>
                            </div>
                        </div>
                        @empty
                            <p>No FAQs</p>
                        @endforelse
                    </div>
			    </div>
		    </div>
	    </div>
    </div>
</section>

@endsection