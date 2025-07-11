@extends('front.layouts.pages-home')

@section('pageTitle', isset($catering->name) ? $catering->name : 'Catering Medium')
@push('meta')
{!! SEO::generate() !!}
@endpush
@push('schema')
{!! $articleSchema->toScript() !!}
@endpush
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
                        <div class="col-md-12"> <span class="heading-meta">Catering</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">
                                {{ $medium->name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .about-section ul,
        .about-section ol {
            list-style: initial;
            margin-left: 1.5em;
        }

        .description img {
            width: 100%;
            height: auto;
            max-width: 100%;
        }
    </style>
    <!-- About Us -->
    <div class="about-section pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 text-center"> <img
                        src="{{ asset('storage/back/images/catering/medium/' . $medium->image) }}"
                        class="img-fluid mb-30 animate-box" data-animate-effect="fadeInLeft"
                        alt="{{ $medium->image_alt_text }}">
                    <h4 class="pwe-about-subheading animate-box" data-animate-effect="fadeInUp">{{
                        webInfo()->web_tagline }}</h4>
                </div>
                <div class="col-md-6 animate-box description" data-animate-effect="fadeInLeft">
                    <h3 class="pwe-about-heading">{{ $medium->name }}</h3>
                    <p>{!! $medium->description !!}</p>
                </div>
            </div>
        </div>
    </div>
    @include('front.layouts.inc.cta')
    <!-- Team -->
    @include('front.layouts.inc.footer')
</div>
@endsection