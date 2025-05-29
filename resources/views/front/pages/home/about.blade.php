@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'About')

@section('content')
<div id="pwe-main">
    <!-- Banner Title -->
    <div class="banner-container">
        <div class="banner-img"> <img class="banner-img-width" src="{{ asset('front/assets/images/topbanner.jpeg') }}"
                alt=""> </div>
        <div class="banner-head">
            <div class="banner-head-padding banner-head-margin">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12"> <span class="heading-meta">.wedding</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">About Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us -->
    <div class="about-section pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 text-center"> <img src="{{ asset('storage/back/images/about/' . $about->image) }}"
                        class="img-fluid mb-30 animate-box" data-animate-effect="fadeInLeft" alt="">
                    <h4 class="pwe-about-subheading animate-box" data-animate-effect="fadeInUp">To Know Us is to Love
                        Us!</h4>
                </div>
                <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                    <h3 class="pwe-about-heading">{{ $about->title }}</h3>
                    <h4 class="pwe-about-subheading">{{ $about->desc_singkat }}</h4>
                    <p>{!! $about->desc_lengkap !!}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Team -->
    @include('front.layouts.inc.team')
    {{--
    <!-- Pricing -->
    <div class="price-section pt-60 pb-60 price">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12"> <span class="heading-meta">wedding</span>
                    <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Planning Packages</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 owl-carousel owl-theme">
                    <div class="item">
                        <div class="cont">
                            <div class="type">
                                <h6>Ceremony</h6>
                            </div>
                            <div class="value">
                                <h4>2500<span>$</span></h4>
                                <p>Starting From</p>
                            </div>
                            <div class="feat">
                                <ul>
                                    <li>Decoration</li>
                                    <li>DJ & Sound</li>
                                    <li><del>Photographer</del></li>
                                    <li>Celebrant</li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-contact"> <a href="#"><span>See more</span></a> </div>
                    </div>
                    <div class="item">
                        <div class="cont">
                            <div class="type">
                                <h6>Party</h6>
                            </div>
                            <div class="value">
                                <h4>3500<span>$</span></h4>
                                <p>Starting From</p>
                            </div>
                            <div class="feat">
                                <ul>
                                    <li>Decoration</li>
                                    <li>DJ & Sound</li>
                                    <li>Photographer</li>
                                    <li>Party Planner</li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-contact"> <a href="#"><span>See more</span></a> </div>
                    </div>
                    <div class="item">
                        <div class="cont">
                            <div class="type">
                                <h6>Full Wedding</h6>
                            </div>
                            <div class="value">
                                <h4>6500<span>$</span></h4>
                                <p>Starting From</p>
                            </div>
                            <div class="feat">
                                <ul>
                                    <li>Decoration</li>
                                    <li>DJ & Sound</li>
                                    <li>Photographer</li>
                                    <li>Make-Up & Hair Dresser</li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-contact"><a href="#"><span>See More</span></a></div>
                    </div>
                    <div class="item">
                        <div class="cont">
                            <div class="type">
                                <h6>Pre - Wedding</h6>
                            </div>
                            <div class="value">
                                <h4>5500<span>$</span></h4>
                                <p>Starting From</p>
                            </div>
                            <div class="feat">
                                <ul>
                                    <li>Decoration</li>
                                    <li>DJ & Sound</li>
                                    <li>Photographer</li>
                                    <li>Venue Booking</li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-contact"><a href="#"><span>See More</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @include('front.layouts.inc.testimonial')
    @include('front.layouts.inc.footer')
</div>
@endsection