@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Catering')

@section('content')
<style>
    .portfolio-img img {
        width: 100%;
        height: 200px;
        /* Sesuaikan tinggi gambar sesuai keinginan */
        object-fit: cover;
        border-radius: 8px;
    }
</style>
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
            @foreach ($cateringList as $index => $package)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="{{ strtolower($package->name) }}-tab"
                    href="javascript:void(0);" role="tab" onclick="openTab(event, '{{ strtolower($package->name) }}')">
                    {{ $package->name }}
                </a>
            </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="cateringTabsContent">
            @foreach ($cateringList as $index => $package)
            <div class="tab-pane {{ $index == 0 ? 'show active' : '' }}" id="{{ strtolower($package->name) }}"
                role="tabpanel">
                <div class="portfolio-section portfolio pt-0 pb-60">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Menampilkan Premium Catering Packages -->
                            @foreach ($package->premiumCaterings as $premium)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a href="{{ route('premium.detail.show', $premium->slug) }}">
                                            <img src="{{ asset('storage/back/images/catering/premium/' . $premium->image) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5><a href="{{ route('premium.detail.show', $premium->slug) }}">{{
                                                $premium->name }}</a></h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <!-- Menampilkan Medium Catering Packages -->
                            @foreach ($package->mediumCaterings as $medium)
                            <div class="col-md-4">
                                <div class="item animate-box" data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a href="{{ route('medium.detail.show', $medium->slug) }}">
                                            <img src="{{ asset('storage/back/images/catering/medium/' . $medium->image) }}"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5><a href="{{ route('medium.detail.show', $medium->slug) }}">{{ $medium->name
                                                }}</a></h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('front.layouts.inc.footer')
</div>
@endsection

@push('js')
<script>
    function openTab(evt, tabName) {
        // Mengambil semua elemen dengan kelas 'tab-pane' dan menyembunyikannya
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-pane");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("show", "active"); // Menyembunyikan tab
        }

        // Mengambil semua elemen dengan kelas 'nav-link' dan menghapus kelas 'active'
        tablinks = document.getElementsByClassName("nav-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }

        // Menampilkan tab yang dipilih dan menambahkan kelas 'active' pada link tab
        document.getElementById(tabName).classList.add("show", "active");
        evt.currentTarget.classList.add("active"); // Menandai tab yang dipilih
    }
</script>
@endpush