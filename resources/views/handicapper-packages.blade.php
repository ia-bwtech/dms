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
                        <h1>Handicapper Packages</h1>
                    </div>
                </div>
            </div>

            <div class="container-fluid zindexback">
                <div class="row bannerimg-row">
                    <img src="/assets/images/handicapperpackbanner1.jpg">
                </div>
            </div>
        </section>
        <!-- ./Banner Section -->

        <section id="packagesfilter" class="boxsection packagesfilter">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 packagesfiltercol">
                        <select class="select-warp" id="sortBy" onchange="sort()">
                            <option value="asc">Ascending</option>
                            <option value="desc" selected>Descending</option>
                        </select>

                        <div class="radio-warp">
                            <div class="form-group">
                                <div class="radio">
                                    <label> <input type="radio" name="radio-input" onclick="sort()" id="orderBy"
                                            checked="checked" value="verified_win_loss_percentage"> Win / Loss <span
                                            class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="radio">
                                    <label> <input type="radio" name="radio-input" onclick="sort()" id="orderBy"
                                            value="roi"> ROI <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="radio">
                                    <label> <input type="radio" name="radio-input" onclick="sort()" id="orderBy"
                                            value="name"> Name <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="search-warp">
                            <input type="search" id="search" placeholder="What're you searching for?"
                                aria-describedby="button-addon5" class="form-control" onkeyup="sort()">
                            {{-- <button id="button-addon5" type="submit" class="btn btn-primary"><i
                                    class="fa fa-search"></i></button> --}}
                        </div>


                    </div>
                </div>
            </div>
        </section>

        <div id="ajaxData">

        </div>
        {{-- <!-- boxsection Section1 -->
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
      </div>
    </div>
  </div>
</div>
</section>
<!-- ./boxsection Section1 --> --}}





    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>

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
    <script>
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            sort(page);
        });

        populateData()

        function reinitializeSlider() {

        }

        function getSliderSettings() {
            return {
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1
            }
        }

        function populateData() {
            $.ajax({
                type: "GET",
                url: "{{ route('front.packages') }}",
                success: function(data) {
                    $('#ajaxData').html(data)
                    // console.log($('.packagebox_slider').text()); /* ONLY remove the classes and handlers added on initialize */

                    // $('.packagebox_slider').slick('unslick'); /* ONLY remove the classes and handlers added on initialize */
                    // $('.my-slide').remove(); /* Remove current slides elements, in case that you want to show new slides. */
                    // $('.packagebox_slider').slick(getSliderSettings()); /* Initialize the slick again */
                }
            });
        }

        function sort(page) {
            data = {
                sortBy: $('#sortBy').val(),
                orderBy: $('input[name="radio-input"]:checked').val(),
                search: $('#search').val()

            }
            $.ajax({
                type: "GET",
                url: "{{ route('front.packages') }}?page="+page,
                data: data,
                success: function(data) {
                    $('#ajaxData').html(data)
                    // console.log($('.packagebox_slider').text()); /* ONLY remove the classes and handlers added on initialize */

                    // $('.packagebox_slider').slick('unslick'); /* ONLY remove the classes and handlers added on initialize */
                    // $('.my-slide').remove(); /* Remove current slides elements, in case that you want to show new slides. */
                    // $('.packagebox_slider').slick(getSliderSettings()); /* Initialize the slick again */
                }
            });
        }
    </script>
@endsection
