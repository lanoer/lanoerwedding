@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Entertainment')

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
                        <div class="col-md-12"> <span class="heading-meta">Entertainment</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Entertainment</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab Navigation -->
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="entertainmentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="sound-tab" data-bs-toggle="tab" href="#sound" role="tab"
                    aria-controls="sound" aria-selected="true">{{ $sound->name }}</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="live-tab" data-bs-toggle="tab" href="#live" role="tab" aria-controls="live"
                    aria-selected="false">{{ $live->name }}</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ceremony-tab" data-bs-toggle="tab" href="#ceremony" role="tab"
                    aria-controls="ceremony" aria-selected="false">{{ $ceremony->name }}</a>
            </li>
        </ul>
        <div class="tab-content portfolio-section portfolio pt-0 pb-60" id="entertainmentTabsContent">
            <!-- Entertainment Tab Content -->
            <div class="tab-pane fade show active mt-5" id="sound" role="tabpanel" aria-labelledby="sound-tab">
                <div class="services-section services pt-0 pb-90">
                    <div class="">
                        <div class="row">
                            @foreach ($soundSystem as $s)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a
                                            href="{{ route('entertainment.sound.detail.show', ['slug' => $sound->slug, 'soundSystemSlug' => $s->slug]) }}">
                                            <img src="{{ asset('storage/back/images/entertainment/sound/thumbnails/thumb_' . $s->image) }}"
                                                alt="{{ $s->image_alt_text }}" class="img-fluid rounded">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5>
                                            <a
                                                href="{{ route('entertainment.sound.detail.show', ['slug' => $sound->slug, 'soundSystemSlug' => $s->slug]) }}">{{
                                                $s->name }}</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Live Music Tab Content -->
            <div class="tab-pane fade mt-5" id="live" role="tabpanel" aria-labelledby="live-tab">
                <div class="services-section services pt-0 pb-90">
                    <div class="">
                        <div class="row">
                            @foreach ($liveMusic as $lv)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a
                                            href="{{ route('entertainment.live.detail.show', ['liveSlug' => $live->slug, 'liveSubSlug' => $lv->slug]) }}">
                                            <img src="{{ asset('storage/back/images/entertainment/live/thumbnails/thumb_' . $lv->image) }}"
                                                alt="{{  $lv->image_alt_text }}" class="img-fluid rounded">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5>
                                            <a
                                                href="{{ route('entertainment.live.detail.show', ['liveSlug' => $live->slug, 'liveSubSlug' => $lv->slug]) }}">{{
                                                $lv->name }}</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ceremony Tab Content -->
            <div class="tab-pane fade mt-5" id="ceremony" role="tabpanel" aria-labelledby="ceremony-tab">
                <div class="services-section services pt-0 pb-90">
                    <div class="">
                        <div class="row">
                            @foreach ($ceremonySub as $ce)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a
                                            href="{{ route('entertainment.ceremony.detail.show', ['ceremonySlug' => $ce->ceremonial->slug, 'ceremonySubSlug' => $ce->slug]) }}">
                                            <img src="{{ asset('storage/back/images/entertainment/ceremonial/thumbnails/thumb_' . $ce->image) }}"
                                                alt="{{ $ce->image_alt_text }}" class="img-fluid rounded">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5>
                                            <a
                                                href="{{ route('entertainment.ceremony.detail.show', ['ceremonySlug' => $ce->ceremonial->slug, 'ceremonySubSlug' => $ce->slug]) }}">{{
                                                $ce->name }}</a>
                                        </h5>
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