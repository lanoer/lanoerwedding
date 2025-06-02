@extends('front.layouts.pages-home')

@section('pageTitle', isset($decoration->name) ? $decoration->name : 'Decorations')
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
                        <div class="col-md-12"> <span class="heading-meta">Decorations</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">
                                {{ $decoration->name }}</h2>
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
    </style>
    <!-- About Us -->
    <div class="about-section pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 text-center"> <img
                        src="{{ asset('storage/back/images/decoration/' . $decoration->image) }}"
                        class="img-fluid mb-30 animate-box" data-animate-effect="fadeInLeft" alt="">
                    <h4 class="pwe-about-subheading animate-box" data-animate-effect="fadeInUp">To Know Us is to Love
                        Us!</h4>
                </div>
                <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                    <h3 class="pwe-about-heading">{{ $decoration->name }}</h3>
                    <p>{!! $decoration->description !!}</p>
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