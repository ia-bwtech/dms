@extends('layouts.front.app')
@section('header')
<meta name="description" content="{{$blog->meta_title}}">
<script>
    var title="{{$blog->meta_title}}"
    document.title = title;
</script>
<title>{{$blog->meta_title}}</title>
@endsection
@section('content')
    <style>
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

        section#blog-signle {
            padding-top: 70px;
            padding-bottom: 70px;
        }

        ul.cat-list-date {
            padding: 0;
            margin: 7px 0;
            list-style-type: none;
        }

        ul.cat-list-date li {
            display: inline-block;
            font-size: 18px;
            padding: 0 20px 0 0;
        }

        ul.cat-list-date li svg.svg-inline--fa.fa-clock {
            color: #33cccc;
            margin: 0 10px 0 0;
        }

        ul.share-icons {
            list-style-type: none;
            padding: 0;
            margin: 0 0 30px 0;
        }

        ul.share-icons li {
            font-weight: bold;
            font-size: 25px;
            display: inline-block;
            padding: 0 15px 0 0;
        }

        ul.share-icons li i {}

        ul.share-icons li svg.svg-inline--fa.fa-facebook {
            color: #3e578c;
            font-size: 25px;
        }

        ul.share-icons li svg.svg-inline--fa.fa-twitter {
            font-size: 25px;
            color: 00acee;
        }

        ul.share-icons li svg.svg-inline--fa.fa-twitter path {
            color: #00acee;
        }

        ul.share-icons li:nth-child(4) path {
            color: #dd4b39;
        }

        ul.share-icons li path {}

        ul.share-icons li svg {
            font-size: 25px;
        }

        ul.share-icons li:nth-child(5) path {
            color: #c92228;
        }

        ul.share-icons li:nth-child(6) path {
            color: #0e76a8;
        }

        .blog-single-content p {
            padding-top: 40px;
            font-size: 18px;
            line-height: 28px;
        }

        .banner-image-detail {
            width: 99%;
            height: 500px;
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


    <section id="blog-signle" class="blog-signle-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="blog-single-content">
                        <h2>{{ $blog->title }}</h2>
                        <ul class="cat-list-date">
                            <li>{{ $blog->category->name }}</li>
                            <li><i class="fa-sharp fa-solid fa-clock"></i>{{ $blog->created_at->format('M d, Y') }}</li>
                        </ul>
                        <ul class="share-icons d-none">
                            <li>SHARE:</li>
                            <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                        <div class="listing-box-img">
                            <img src="/images/{{ $blog->banner }}" class="img-fluid banner-image-detail">
                        </div>
                        <p>"{{ $blog->banner_description }}"

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {!! $blog->blog !!}
                </div>
            </div>
        </div>
    </section>
@endsection
