@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Entertainment ' . $sound->name)

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
                        <div class="col-md-12"> <span class="heading-meta">Entertainment {{ $sound->name }}</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Entertainment
                                {{ $soundSystem->name }}</h2>
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
                <div class="col-md-6 text-center"> <img
                        src="{{ asset('storage/back/images/entertainment/sound/' . $soundSystem->image) }}"
                        class="img-fluid mb-30 animate-box" data-animate-effect="fadeInLeft" alt="">
                    <h4 class="pwe-about-subheading animate-box" data-animate-effect="fadeInUp">To Know Us is to Love
                        Us!</h4>
                </div>
                <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                    <h3 class="pwe-about-heading">{{ $soundSystem->name }}</h3>
                    <h4 class="pwe-about-subheading">{{ $soundSystem->desc_singkat }}</h4>
                    <p>{!! $soundSystem->description !!}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Team -->
    @include('front.layouts.inc.team')

    @endsection