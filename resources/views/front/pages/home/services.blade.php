@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Services')

@section('content')
<!-- Banner Title -->
<div id="pwe-main">
    <div class="banner-container">
        <div class="banner-img"> <img class="banner-img-width" src="{{ asset('front/assets/images/topbanner-1.jpeg') }}"
                alt=""> </div>
        <div class="banner-head">
            <div class="banner-head-padding banner-head-margin">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12"> <span class="heading-meta">weddings . events</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Our Services</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services -->

    <div class="services-section services pt-0 pb-90">
        <div class="banner-head">
            <div class="banner-head-padding banner-head-margin">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12"> <span class="heading-meta">weddings</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Weddings</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                @forelse ($weddings as $item)
                <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                    <div class="item mb-30">
                        <div class="position-re o-hidden">
                            <img src="{{ asset('storage/back/images/wedding/weddingmakeup/' . $item->image) }}" alt="">
                        </div>
                        <div class="con">
                            <span class="category">
                                <a
                                    href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $item->weddingMakeups->slug]) }}">.
                                    <!-- Check if weddingMakeups exists -->
                                    {{ optional($item->weddingMakeups)->name ?? 'No Makeup Found' }}
                                </a>
                            </span>
                            <!-- Check if wedding exists -->
                            <h5><a
                                    href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $item->weddingMakeups->slug, 'slug' => $item->slug]) }}">{{
                                    $item->name }}</a></h5>

                            <a
                                href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $item->weddingMakeups->slug, 'slug' => $item->slug]) }}"><i
                                    class="ti-arrow-right"></i></a>
                        </div>
                    </div>

                </div>
                @empty
                <p>Not Found</p>
                @endforelse
                <!-- Pagination Links -->
                <div class="pagination-wrapper" style="text-align: center;">
                    {{ $weddings->links('vendor.pagination.custom') }}
                </div>
                <hr>
                @forelse ($event as $item)
                <div class="col-md-4 animate-box" data-animate-effect="fadeInLeft">
                    <div class="item mb-30">
                        <div class="position-re o-hidden">
                            <img src="{{ asset('storage/back/images/event/eventmakeup/' . $item->image) }}" alt="">
                        </div>
                        <div class="con">
                            <span class="category">
                                <a href="{{ route('makeup.event', ['eventMakeupSlug' => $item->eventMakeup->slug]) }}">.
                                    <!-- Check if weddingMakeups exists -->
                                    {{ optional($item->eventMakeup)->name ?? 'No Makeup Found' }}
                                </a>
                            </span>
                            <!-- Check if wedding exists -->
                            <h5><a
                                    href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $item->eventMakeup->slug, 'slug' => $item->slug]) }}">{{
                                    $item->name }}</a></h5>

                            <a
                                href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $item->eventMakeup->slug, 'slug' => $item->slug]) }}"><i
                                    class="ti-arrow-right"></i></a>
                        </div>
                    </div>

                </div>
                @empty
                <p>Not Found</p>
                @endforelse
                <!-- Pagination Links -->
                <div class="pagination-wrapper" style="text-align: center;">
                    {{ $event->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection