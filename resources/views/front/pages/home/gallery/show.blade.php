@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Gallery')

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
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">Gallery</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pwe-section pt-0 pb-60">
        <div class="container-fluid">

            <div class="row mb-60">
                <style>
                    .gallery-img-size {
                        width: 100%;
                        /* Membuat gambar mengisi lebar kontainer */
                        height: 200px;
                        /* Mengatur tinggi gambar tetap */
                        object-fit: cover;
                        /* Menjaga rasio aspek dan memastikan gambar tidak terdistorsi */
                    }
                </style>
                @foreach ($fotosGallery as $f)
                <div class="col-md-4 gallery-item animate-box" data-animate-effect="fadeInLeft">
                    <a href="{{ asset('storage/back/images/gallery/foto/' . $f->image) }}"
                        title="{{ $gallery->gallery_name }}" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img">
                                <img src="{{ asset('storage/back/images/gallery/foto/' . $f->image) }}"
                                    class="img-fluid mx-auto d-block gallery-img-size" alt="work-img" loading="lazy">
                            </div>
                            <div class="gallery-detail text-center">
                                <i class="ti-fullscreen"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
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
        {{ $fotosGallery->links('pagination::custom') }}
    </div>
    @include('front.layouts.inc.cta')
    <!-- Clients -->
    @include('front.layouts.inc.clients')

    @include('front.layouts.inc.footer')
</div>
@endsection