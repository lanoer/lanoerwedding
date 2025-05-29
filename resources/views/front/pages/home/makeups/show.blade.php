@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Makeups')

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
                        <div class="col-md-12"> <span class="heading-meta">{{ $event->eventMakeup->name ?? '' }}</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">
                                {{ $event->name ?? '' }}</h2>
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
                <div class="col-md-5 animate-box" data-animate-effect="fadeInLeft"> <img
                        src="{{ asset('storage/back/images/event/eventmakeup/' . $event->image) }}"
                        class="img-fluid mb-30" alt=""> </div>
                <div class="col-md-7 animate-box" data-animate-effect="fadeInLeft">
                    <p>{!! $event->description ?? '' !!}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Team -->
    @include('front.layouts.inc.team')

    @include('front.layouts.inc.testimonial')
    @include('front.layouts.inc.footer')
</div>
@endsection