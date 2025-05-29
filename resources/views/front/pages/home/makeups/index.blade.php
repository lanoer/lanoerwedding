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
                        <div class="col-md-12"> <span class="heading-meta">.wedding</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Makeups</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('front.makeups-list')
    <!-- Team -->
    @include('front.layouts.inc.team')

    @include('front.layouts.inc.testimonial')
    @include('front.layouts.inc.footer')
</div>
@endsection