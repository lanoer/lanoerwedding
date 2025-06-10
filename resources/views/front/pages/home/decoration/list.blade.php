@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Decorations')

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
                                Decorations</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio -->
    <div class="portfolio-section portfolio pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                @foreach ($decoration as $dec)
                <div class="col-md-4">
                    <div class="item animate-box" data-animate-effect="fadeInLeft">
                        <div class="portfolio-img">
                            <a href="{{ route('decoration.detail.show', $dec->slug) }}"><img
                                    src="{{ asset('storage/back/images/decoration/thumbnails/thumb_800_' . $dec->image) }}"
                                    alt="">
                        </div>
                        <div class="content">
                            <h5><a href="{{ route('decoration.detail.show', $dec->slug) }}">{{ $dec->name }}</a>
                            </h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Team -->
    @include('front.layouts.inc.testimonial')
    @include('front.layouts.inc.footer')
</div>
@endsection