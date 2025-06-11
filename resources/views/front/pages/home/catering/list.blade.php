@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Catering')

@section('content')
<div id="pwe-main">
    <!-- Banner Title -->
    <div class="banner-container">
        <div class="banner-img">
            <img class="banner-img-width" src="{{ asset('front/assets/images/topbanner.jpeg') }}" alt="">
        </div>
        <div class="banner-head">
            <div class="banner-head-padding banner-head-margin">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="heading-meta">Catering</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Catering</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="container-fluid mt-4">
        <ul class="nav nav-tabs" id="cateringTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="premium-tab" data-bs-toggle="tab" href="#premium" role="tab"
                    aria-controls="premium" aria-selected="true">Premium Catering</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="medium-tab" data-bs-toggle="tab" href="#medium" role="tab"
                    aria-controls="medium" aria-selected="false">Medium Catering</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="cateringTabsContent">
            <!-- Premium Catering Tab -->
            <div class="tab-pane fade show active" id="premium" role="tabpanel" aria-labelledby="premium-tab">
                <div class="portfolio-section portfolio pt-0 pb-60">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach ($premium as $package)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a href="{{ route('premium.detail.show', $package->slug) }}">
                                            <img src="{{ asset('storage/back/images/catering/premium/' . $package->image) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5><a href="{{ route('premium.detail.show', $package->slug) }}">{{
                                                $package->name }}</a></h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medium Catering Tab -->
            <div class="tab-pane fade" id="medium" role="tabpanel" aria-labelledby="medium-tab">
                <div class="portfolio-section portfolio pt-0 pb-60">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach ($medium as $package)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a href="{{ route('medium.detail.show', $package->slug) }}">
                                            <img src="{{ asset('storage/back/images/catering/medium/' . $package->image) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5><a href="{{ route('medium.detail.show', $package->slug) }}">{{
                                                $package->name }}</a></h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front.layouts.inc.footer')
</div>
@endsection