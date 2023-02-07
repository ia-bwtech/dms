@extends('layouts.front.app')

@section('content')
    <style>
        section#blog-listing {
            padding-top: 60px;
            padding-bottom: 40px;
        }

        section#blog-listing h2 {
            text-align: center;
            margin-bottom: 35px;
        }

        .blog-search input#search {
            height: 70px;
            border-radius: 0;
            border-color: #1d1d25;
            padding: 0 0 0 20px;
        }

        .blog-search input#search::placeholder {
            color: #1d1d25;
        }

        .blog-search {
            margin-bottom: 25px;
        }

        .bolg-category {
            margin-bottom: 30px;
        }

        .bolg-category select#blog-category-listing {
            height: 70px;
            border-radius: 0;
            background-color: #1d1d25;
            color: #fff;
            padding-left: 20px;
            width: 100%;
            background-image: url(/assets/images/category-bg.png);
            background-size: 7%;
            background-position: right 20px center;
        }

        .all-category {
            padding-left: 20px;
        }

        .listing-box h4 {
            padding-top: 30px;
            padding-bottom: 10px;
        }

        .all-category ul {
            padding-top: 17px;
        }

        .all-category ul li {
            transition: 0.5s linear;
            list-style-type: none;
            cursor: pointer;
        }

        .all-category ul li:hover {
            color: #ed2328;
        }

        .listing-box p {
            font-size: 16px;
            line-height: 25px;
        }

        p.date-company {
            font-weight: bold;
            margin-top: 10px;
            font-size: 14px;
        }

        p.date-company span {
            color: #ed2328;
        }

        .listing-box {
            position: relative;
            margin-bottom: 40px;
        }

        .listing-box-img {
            position: relative;
        }

        .listing-box-img:after {
            content: '';
            background-color: #00acec;
            width: 100%;
            height: 100%;
            position: absolute;
            right: 0;
            left: 12px;
            top: 12px;
            bottom: 0;
            z-index: -1;
        }
        .blog-listing-section a{
            color:black;
        }
        .blog-listing-section a:hover{
            color:black;
        }
        .blog-banner{
            height: 250px;
        }
    </style>

    <!-- Banner Section1 -->
    <section id="banner" class="banner-section banner-home">
        <div class="container">
            <div class="row banner-row align-items-center justify-content-between">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-dark text-center">
                    <h1>News And Articles</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid zindexback">
            <div class="row bannerimg-row"><img src="/images/cms/handicapperbanner1-167173669620221222141816.jpg"></div>
        </div>
    </section>
    <!-- ./Banner Section -->

    <section id="blog-listing" class="blog-listing-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 d-none">
                    <h2>Blogs</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="blog-side-col">
                        {{-- <div class="blog-search">
                            <input type="search" id="search" placeholder="Search" aria-describedby="button-addon5"
                                class="form-control">
                        </div> --}}
                        {{-- <div class="bolg-category">
                            <select class="select-warp" id="blog-category-listing">
                                @foreach ($blogcategories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach

                            </select>
                        </div> --}}
                        <div class="all-category">
                            <a href="/blog-listing"><h4>All Categories</h4></a>
                            <ul>
                                @foreach ($blogcategories as $item1)
                                @if($item1->id!=1)
                                    <li><a href="/blog-listing?category_id={{ $item1->id }}">{{ $item1->name }}</a></li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="row">
                        @foreach ($blogs->where('published',1) as $blog)
                            <a href="/blog-detail/{{ $blog->id }}" class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                {{-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12"> --}}
                                    <div class="listing-box">
                                        <div class="listing-box-img">
                                            <img src="{{ asset('images') }}/{{ $blog->banner }}" class="img-fluid blog-banner">
                                        </div>
                                        <h4>{{ $blog->title }}</h4>
                                        <p>{{ substr($blog->short_text, 0, 200) }}</p>
                                        <p class="date-company"><span>{{ $blog->created_at->format('d-M-Y') }}</span>
                                           </p>
                                    </div>
                                {{-- </div> --}}
                            </a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
