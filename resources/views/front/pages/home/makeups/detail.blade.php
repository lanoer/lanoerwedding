@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Makeups Detail')

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
                        <div class="col-md-12"> <span class="heading-meta">{{ $eventMakeup->name ?? '' }}</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">
                                {{ $eventMakeup->name ?? '' }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="services-section services pt-0 pb-90">
        <div class="container-fluid">
            <div class="row">
                @foreach ($eventMakeup->events as $event)
                <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                    <div class="item mb-30">
                        <div class="position-re o-hidden">
                            <img src="{{ asset('storage/back/images/event/eventmakeup/' . $event->image) }}" alt="">
                        </div>
                        <div class="con">
                            <span class="category">
                                <a href="{{ route('makeup.event', ['eventMakeupSlug' => $eventMakeup->slug]) }}">{{
                                    $eventMakeup->name }}</a>
                            </span>
                            <h5><a href="{{ route('makeup.event', ['eventMakeupSlug' => $eventMakeup->slug]) }}">{{
                                    $event->name }}</a>
                            </h5>
                            <a
                                href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $eventMakeup->slug, 'slug' => $event->slug]) }}"><i
                                    class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Team -->
    @include('front.layouts.inc.team')

    @include('front.layouts.inc.testimonial')
    @include('front.layouts.inc.footer')
</div>
@endsection