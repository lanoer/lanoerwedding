@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Home')

@section('content')
<div id="pwe-main">
    <!-- Slider -->
    @include('front.layouts.inc.slider')
    <!-- Services -->
    <div class="services-section services clear pt-90 pb-90">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-30">
                    <span class="heading-meta">weddings . events</span>
                    <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Our Services</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel owl-theme">
                        @foreach ($wedding as $wed)
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ asset('storage/back/images/wedding/weddingmakeup/' . $wed->image) }}"
                                    alt="{{ $wed->name }}">
                            </div>
                            <div class="con">
                                <span class="category">
                                    <a
                                        href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $wed->weddingMakeups->slug]) }}">{{
                                        $wed->weddingMakeups->name }}</a>
                                </span>
                                <h5><a
                                        href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $wed->weddingMakeups->slug, 'slug' => $wed->slug]) }}">{{
                                        $wed->name }}</a>
                                </h5>
                                <a
                                    href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $wed->weddingMakeups->slug, 'slug' => $wed->slug]) }}"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        @endforeach

                        @foreach ($event as $evt)
                        <div class="item">
                            <div class="position-re o-hidden">
                                <img src="{{ asset('storage/back/images/event/eventmakeup/' . $evt->image) }}"
                                    alt="{{ $evt->name }}">
                            </div>
                            <div class="con">
                                <span class="category">
                                    <a
                                        href="{{ route('makeup.event', ['eventMakeupSlug' => $evt->eventMakeup->slug]) }}">{{
                                        $evt->eventMakeup->name }}</a>
                                </span>
                                <h5><a
                                        href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $evt->eventMakeup->slug, 'slug' => $evt->slug]) }}">{{
                                        $evt->name }}</a>
                                </h5>
                                <a
                                    href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $evt->eventMakeup->slug, 'slug' => $evt->slug]) }}"><i
                                        class="ti-arrow-right"></i></a>
                            </div>
                        </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testiominals -->
    <div class="testiominal-section pt-90 pb-90 testimonials bg-img bg-fixed" data-overlay-dark="5"
        data-background="{{ asset('front/assets/images/banner.jpg') }}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="section-head">
                        <span>testiominals</span>
                        <h4>From our clients</h4>
                        <p>We are always eager to hear your opinion and share your experience. Here you can find
                            some of our affectionate customers opinions.</p>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="owl-carousel owl-theme">
                        @foreach (testimonials() as $testimoni)
                        <div class="item-box"> <span class="quote">
                                <img src="{{ $testimoni->image }}" alt="">
                            </span>
                            <p>{!! $testimoni->testimoni !!}</p>
                            <div class="info">
                                <div class="author-img"> <img src="{{ $testimoni->image }}" alt="">
                                </div>
                                <div class="cont">
                                    <h6>{{ $testimoni->name }}</h6> <span>{{ $testimoni->date }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog -->
    {{-- <div class="blog-section blog pt-90 pb-90">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-30"> <span class="heading-meta">read news</span>
                    <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Latest News</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="item mb-30 animate-box" data-animate-effect="fadeInLeft">
                        <div class="post-img"> <img src="{{ asset('front/assets/images/blog/2.jpg') }}" alt="">
                            <div class="date">
                                <a href="post.html"> <span>Apr</span> <i>02</i> </a>
                            </div>
                        </div>
                        <div class="content"> <span class="tag">
                                <a href="blog.html">Wedding</a>
                            </span>
                            <h5><a href="post.html">Crush Your Wedding Day Style!</a></h5>
                            <p>Quality fusce suscipit the conce viviense ante a hendrerit ullamcor risus nise
                                the cursus purus sit amet viverra.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item mb-30 animate-box" data-animate-effect="fadeInLeft">
                        <div class="post-img"> <img src="{{ asset('front/assets/images/blog/3.jpg') }}" alt="">
                            <div class="date">
                                <a href="post.html"> <span>Apr</span> <i>04</i> </a>
                            </div>
                        </div>
                        <div class="content"> <span class="tag">
                                <a href="post.html">Wedding</a>
                            </span>
                            <h5><a href="post.html">How to be the best bridesmaid ever!</a></h5>
                            <p>Quality fusce suscipit the conce viviense ante a hendrerit ullamcor risus nise
                                the cursus purus sit amet viverra.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item mb-30 animate-box" data-animate-effect="fadeInLeft">
                        <div class="post-img"> <img src="{{ asset('front/assets/images/blog/1.jpg') }}" alt="">
                            <div class="date">
                                <a href="post.html"> <span>Apr</span> <i>08</i> </a>
                            </div>
                        </div>
                        <div class="content"> <span class="tag">
                                <a href="blog.html">Hairstyle</a>
                            </span>
                            <h5><a href="post.html">15 Best Bridal Hairstyles Ever</a></h5>
                            <p>Quality fusce suscipit the conce viviense ante a hendrerit ullamcor risus nise
                                the cursus purus sit amet viverra.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Clients -->
    @include('front.layouts.inc.clients')
    @include('front.layouts.inc.footer')
</div>
@endsection