{{-- @foreach ($users as $item)
    <!-- boxsection Section1 -->




    <section id="boxsection" class="boxsection bgbluelight">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="packageboxhead">
                        <img src="/assets/images/handicapperpackicon1.png" class="iconmain">
                        <span class="title">Joe Smith</span>
                        <span class="line"></span>
                        <span class="value">82-50</span>
                        <span class="per">(62.1%)</span>
                    </div>
                </div>

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="packagebox_slider">
                        <div class="packagebox">
                            <h2 class="texttitle">Weekly Package</h2>
                            <ul>
                                <li>iste natus error sit voluptatem</li>
                                <li>accusantium doloremque</li>
                                <li>laudantium</li>
                                <li>Sed ut perspiciatis unde omnis</li>
                                <li>iste natus error sit</li>
                            </ul>
                            <div class="redbox">
                                <button class="redboxbtn">
                                    <sup>Buy Now</sup>
                                    <span>$1200</span>
                                    <i></i>
                                    <sub>Terms*</sub>
                                </button>
                            </div>
                        </div>
                        <div class="packagebox">
                            <h2 class="texttitle">Monthly Package</h2>
                            <ul>
                                <li>iste natus error sit voluptatem</li>
                                <li>accusantium doloremque</li>
                                <li>laudantium</li>
                                <li>Sed ut perspiciatis unde omnis</li>
                                <li>iste natus error sit</li>
                            </ul>
                            <div class="redbox">
                                <button class="redboxbtn">
                                    <sup>Buy Now</sup>
                                    <span>$2000</span>
                                    <i></i>
                                    <sub>Terms*</sub>
                                </button>
                            </div>
                        </div>
                        <div class="packagebox">
                            <h2 class="texttitle">Monthly Package</h2>
                            <ul>
                                <li>iste natus error sit voluptatem</li>
                                <li>accusantium doloremque</li>
                                <li>laudantium</li>
                                <li>Sed ut perspiciatis unde omnis</li>
                                <li>iste natus error sit</li>
                            </ul>
                            <div class="redbox">
                                <button class="redboxbtn">
                                    <sup>Buy Now</sup>
                                    <span>$2000</span>
                                    <i></i>
                                    <sub>Terms*</sub>
                                </button>
                            </div>
                        </div>
                        @foreach ($item->packages as $package)
                        <div class="packagebox">
                            <h2 class="texttitle">Daily Package</h2>
                            <ul>
                                <li>iste natus error sit voluptatem</li>
                                <li>accusantium doloremque</li>
                                <li>laudantium</li>
                                <li>Sed ut perspiciatis unde omnis</li>
                                <li>iste natus error sit</li>
                            </ul>
                            <div class="redbox">
                                <button class="redboxbtn">
                                    <sup>Buy Now</sup>
                                    <span>$800</span>
                                    <i></i>
                                    <sub>Terms*</sub>
                                </button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./boxsection Section1 -->
@endforeach --}}

@foreach ($users as $key=>$item)
<section id="boxsection" class="boxsection @if($key%2!=0) bgbluelight @endif">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="packageboxhead">
                    <img src="/images/profile/{{$item->image}}" class="iconmain">
                    <span class="title">{{ $item->name }}</span>
                    <span class="line"></span>
                    <span class="value">{{ $item->verified_wins }}-{{ $item->verified_losses }}</span>
                    <span class="per">({{ $item->verified_win_loss_percentage }}%)</span>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="packagebox_slider">
                    @foreach ($item->packages as $package)
                    <div class="packagebox">
                        <h2 class="texttitle">{{ $package->name }}</h2>
                            <p>
                                {{ $package->description }}
                            </p>

                            <div class="redbox">
                                <a href="{{route('package',$package->id)}}">
                                <button class="redboxbtn">
                                    <sup>Buy Now</sup>
                                    <span>${{ $package->price }}</span>
                                    <i></i>
                                    <sub>Terms*</sub>
                                </button>
                            </a>
                            </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
@endforeach

<div style="align-items: center">
    {{ $users->links() }}
</div>
<script>
     $('.packagebox_slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,

            autoplay: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
</script>
