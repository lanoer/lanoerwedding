@extends('front.layouts.pages-home')

@section('pageTitle', isset($decoration->name) ? $decoration->name : 'Premum Cattering')
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
                        <div class="col-md-12"> <span class="heading-meta">Premium</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">
                                {{ $premium->name }}</h2>
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
                <div class="col-md-6 text-center">
                    <img src="{{ asset('storage/back/images/catering/premium/' . $premium->image) }}"
                        class="img-fluid mb-30 animate-box" data-animate-effect="fadeInLeft"
                        alt="{{ $premium->image_alt_text }}">
                    <div class="row mt-4">
                        @foreach ($galleryImages as $image)
                        <div class="col-4 mb-3">
                            <a href="{{ asset('storage/back/images/catering/premium/gallery/' . $image->image) }}"
                                title="" class="img-zoom">
                                <div class="gallery-box">
                                    <div class="gallery-img">
                                        <img src="{{ asset('storage/back/images/catering/premium/gallery/' . $image->image) }}"
                                            class="img-fluid mx-auto d-block" alt="work-img" loading="lazy">
                                    </div>
                                    <div class="gallery-detail text-center">
                                        <i class="ti-fullscreen"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $galleryImages->links('pagination::custom') }}
                        </div>
                    </div>
                    <h4 class="pwe-about-subheading animate-box" data-animate-effect="fadeInUp">{{
                        webInfo()->web_tagline }}</h4>
                </div>
                <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                    <h3 class="pwe-about-heading description">{{ $premium->name }}</h3>
                    <p>{!! $premium->description !!}</p>
                </div>
            </div>
        </div>
    </div>
    @include('front.layouts.inc.cta')
    <!-- Team -->

    @include('front.layouts.inc.footer')
</div>
@endsection

@push('js')
<script src="{{ asset('back/assets/vendor/fancybox/dist/jquery.fancybox.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('back/assets/vendor/fancybox/dist/jquery.fancybox.css') }}">
@endpush