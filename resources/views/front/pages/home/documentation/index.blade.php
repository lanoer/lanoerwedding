@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Documentations')

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
                        <div class="col-md-12"> <span class="heading-meta">.Top</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Documentations</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="portfolio-section portfolio pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                @foreach ($album as $a)
                <div class="col-md-4">
                    <div class="item animate-box" data-animate-effect="fadeInLeft">
                        <div class="portfolio-img">
                            <a href="{{ route('documentation.main.show', $a->slug) }}">
                                <img src="{{ asset('storage/back/images/album/thumbnail/' . $a->image) }}" alt="">
                            </a>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="{{ route('documentation.main.show', $a->slug) }}">{{ $a->album_name }}</a>
                            </h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <style>
            .pagination {
                justify-content: center !important;
                display: flex !important;
            }

            a.page-link {
                color: #a2783a !important;
                /* warna default, bisa diganti */
            }

            a.page-link:hover,
            a.page-link:focus {
                color: #2b2929 !important;
                /* warna saat hover/focus */
                text-decoration: none;
            }
        </style>
        <div class="text-center">
            {{ $album->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
    <div class="portfolio-section portfolio pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                @foreach ($videos as $v)
                <div class="col-md-4">
                    <div class="item animate-box" data-animate-effect="fadeInLeft">
                        <div class="portfolio-img">
                            <iframe width="520" height="400" src="{{ $v->video_url }}" title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="{{ $v->video_url }}">{{ $v->video_name }}</a>
                            </h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <style>
            .pagination {
                justify-content: center !important;
                display: flex !important;
            }

            a.page-link {
                color: #a2783a !important;
                /* warna default, bisa diganti */
            }

            a.page-link:hover,
            a.page-link:focus {
                color: #2b2929 !important;
                /* warna saat hover/focus */
                text-decoration: none;
            }
        </style>
        <div class="text-center">
            {{ $videos->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
    <!-- Clients -->
    @include('front.layouts.inc.clients')

    @include('front.layouts.inc.testimonial')
    @include('front.layouts.inc.footer')
</div>
@endsection