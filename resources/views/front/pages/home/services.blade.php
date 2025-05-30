@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Services')

@section('content')
    <!-- Banner Title -->
    <div id="pwe-main">
        <div class="banner-container">
            <div class="banner-img"> <img class="banner-img-width" src="{{ asset('front/assets/images/topbanner-1.jpeg') }}"
                    alt=""> </div>
            <div class="banner-head">
                <div class="banner-head-padding banner-head-margin">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12"> <span class="heading-meta">weddings . events</span>
                                <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Our Services</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Services -->

        <div class="services-section services pt-0 pb-90">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden"> <img src="{{ asset('front/assets/images/services/1.jpg') }}"
                                    alt=""> </div>
                            <div class="con"> <span class="category">
                                    <a href="services-page.html">. weddings</a>
                                </span>
                                <h5><a href="services-page.html">WEDDING PLANNER</a></h5> <a href="services-page.html"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden"> <img src="{{ asset('front/assets/images/services/2.jpg') }}"
                                    alt=""> </div>
                            <div class="con"> <span class="category">
                                    <a href="services-page.html">. weddings</a>
                                </span>
                                <h5><a href="services-page.html">MASTER OF CEREMONIES</a></h5> <a href="#"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden"> <img src="{{ asset('front/assets/images/services/3.jpg') }}"
                                    alt=""> </div>
                            <div class="con"> <span class="category">
                                    <a href="services-page.html">. weddings</a>
                                </span>
                                <h5><a href="services-page.html">DESTINATION WEDDING</a></h5> <a href="#"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden"> <img src="{{ asset('front/assets/images/services/4.jpg') }}"
                                    alt=""> </div>
                            <div class="con"> <span class="category">
                                    <a href="services-page.html">. events</a>
                                </span>
                                <h5><a href="services-page.html">SPECIAL EVENTS</a></h5> <a href="services-page.html"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden"> <img src="{{ asset('front/assets/images/services/5.jpg') }}"
                                    alt=""> </div>
                            <div class="con"> <span class="category">
                                    <a href="services-page.html">. events</a>
                                </span>
                                <h5><a href="services-page.html">BIRTHDAY PARTY PLANNER</a></h5> <a
                                    href="services-page.html"><i class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                        <div class="item mb-30">
                            <div class="position-re o-hidden"> <img src="{{ asset('front/assets/images/services/6.jpg') }}"
                                    alt=""> </div>
                            <div class="con"> <span class="category">
                                    <a href="services-page.html">. events</a>
                                </span>
                                <h5><a href="services-page.html">CORPORATE EVENTS</a></h5> <a href="services-page.html"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
