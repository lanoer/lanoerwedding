<div>
    {{-- <div class="services-section services pt-0 pb-90">
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">

                @foreach ($randomEvents as $event)
                <div class="col-md-4" data-animate-effect="fadeInLeft">
                    <div class="item mb-30">
                        <div class="position-re o-hidden">
                            <img src="{{ asset('storage/back/images/event/eventmakeup/thumbnails/thumb_' . $event->image) }}"
                                alt="{{ $event->image_alt_text }}" class="img-fluid rounded">
                        </div>
                        <div class="con">
                            <span class="category">
                                <a href="{{ route('makeup.event', ['eventMakeupSlug' => $event->eventMakeup->slug]) }}">{{
                                    $event->eventMakeup->name ?? '' }}</a>
                            </span>
                            <h5><a
                                    href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $event->eventMakeup->slug, 'slug' => $event->slug]) }}">{{
                                    $event->name }}</a>
                            </h5>
                            <a
                                href="{{ route('makeup.event.detail', ['eventMakeupSlug' => $event->eventMakeup->slug, 'slug' => $event->slug]) }}"><i
                                    class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach

                @foreach ($randomWeddings as $wedding)
                <div class="col-md-4" data-animate-effect="fadeInLeft">
                    <div class="item mb-30">
                        <div class="position-re o-hidden">
                            <img src="{{ asset('storage/back/images/wedding/weddingmakeup/thumbnails/thumb_' . $wedding->image) }}"
                                alt="{{ $wedding->name }}" class="img-fluid rounded">
                        </div>
                        <div class="con">
                            <span class="category">
                                <a
                                    href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug]) }}">{{
                                    $wedding->weddingMakeups->name ?? '' }}</a>
                            </span>
                            <h5><a
                                    href="{{ route('makeup.wedding', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug]) }}">{{
                                    $wedding->name }}</a>
                            </h5>
                            <a
                                href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug, 'slug' => $wedding->slug]) }}"><i
                                    class="ti-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div> --}}


    <style>
        /* Menjadikan gambar responsif */
        .portfolio-img img {
            width: 100%;
            height: auto;
            /* Gambar akan menyesuaikan dengan lebar kontainer */
            border-radius: 15px;
            /* Sudut membulat pada gambar */
            transition: transform 0.3s ease;
            /* Efek transisi saat hover */
        }

        /* Efek hover untuk gambar */
        .portfolio-img:hover img {
            transform: scale(1.05);
            /* Zoom gambar sedikit saat hover */
        }

        /* Responsif untuk perangkat mobile */
        @media (max-width: 767px) {
            .portfolio-img img {
                width: 100%;
                /* Pastikan gambar mengambil seluruh lebar kontainer */
                height: auto;
                /* Tinggi gambar akan mengikuti proporsi */
            }

            /* Menyesuaikan ukuran teks dan margin untuk perangkat mobile */
            .content h5 {
                font-size: 1rem;
                /* Ukuran teks lebih kecil di perangkat mobile */
            }

            /* Memastikan margin antar kolom lebih besar di perangkat mobile */
            .col-md-4 {
                margin-bottom: 20px;
            }
        }

        /* Efek Gradien Warna pada Teks */
        .content h5 a {
            color: inherit;
            text-decoration: none;
            position: relative;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .content h5 a:hover {
            color: #fff;
            /* Mengubah warna teks */
        }

        .content h5 a:before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #a2783a, #ff69b4);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.4s ease;
        }

        .content h5 a:hover:before {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Style Tab yang Aktif */
        .nav-tabs .nav-link.active {
            background-color: transparent;
            /* Menghilangkan background default */
            color: #a2783a;
            /* Warna teks tab aktif */
            border: 2px solid transparent;
            /* Menghapus border default */
            border-bottom: 4px solid #a2783a;
            /* Menambahkan garis bawah lebih tebal dengan warna #a2783a */
            font-weight: bold;
            /* Membuat teks lebih tebal */
            transition: all 0.3s ease;
            /* Efek transisi yang lebih halus */
        }

        /* Style Tab yang Tidak Aktif */
        .nav-tabs .nav-link {
            color: black;
            /* Warna teks tab yang tidak aktif */
            border: none;
            /* Menghilangkan border default */
            border-bottom: 2px solid transparent;
            /* Garis bawah transparan untuk tab yang tidak aktif */
            transition: all 0.3s ease;
            /* Efek transisi untuk hover */
        }

        /* Efek Hover untuk Tab yang Tidak Aktif */
        .nav-tabs .nav-link:hover {
            color: #a2783a;
            /* Mengubah warna teks menjadi #a2783a saat hover */
            border-bottom: 2px solid #a2783a;
            /* Menambahkan garis bawah saat hover */
        }

        /* Tab Aktif dengan Efek Bayangan */
        .nav-tabs .nav-link.active:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            /* Memberikan bayangan lembut di bawah tab aktif */
        }

        /* Tab Non-Aktif Hover dengan Efek */
        .nav-tabs .nav-link:not(.active):hover {
            border-bottom: 2px solid #a2783a;
            /* Menambahkan garis bawah saat hover pada tab non-aktif */
        }
    </style>

    <div class="container-fluid mt-4" x-data="{
    activeTab: 'weddings',
    intersectSupported: false
}" x-init="
    try { intersectSupported = !!window.IntersectionObserver } catch(e) {}
" @tab-changed.window="activeTab = $event.detail">
        <!-- Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" :class="{ 'active': activeTab === 'weddings' }"
                    @click.prevent="$dispatch('tab-changed', 'weddings')" href="#">Weddings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" :class="{ 'active': activeTab === 'events' }"
                    @click.prevent="$dispatch('tab-changed', 'events')" href="#">Events</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <!-- Weddings -->
            <div x-show="activeTab === 'weddings'" class="tab-pane fade show active" id="weddings" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="portfolio-section portfolio pt-0 pb-60">
                        <div class="row">
                            @foreach ($weddings as $wedding)
                            <div class="col-md-4">
                                <div class="item " data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a
                                            href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => optional($wedding->weddingMakeups)->slug, 'slug' => $wedding->slug]) }}">
                                            <img src="{{ asset('storage/back/images/wedding/weddingmakeup/thumbnails/thumb_' . $wedding->image) }}"
                                                alt="{{ $wedding->image_alt_text }}" class="img-fluid rounded">
                                        </a>
                                    </div>
                                    <div class="content text-center">
                                        <h5>
                                            <a
                                                href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => optional($wedding->weddingMakeups)->slug, 'slug' => $wedding->slug]) }}">
                                                {{ $wedding->name }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if (!$weddingsEnd)
                        <div class="text-center mb-3">
                            <div x-show="intersectSupported" x-intersect.once="$wire.loadMoreWeddings()">
                                <div wire:loading wire:target="loadMoreWeddings">
                                    <span class="spinner-border spinner-border-sm" role="status"></span> Loading more
                                    weddings...
                                </div>
                            </div>
                            <div x-show="!intersectSupported">
                                <button wire:click="loadMoreWeddings" class="btn text-white"
                                    style="background-color: #a2783a; border: 1px solid #a2783a;"
                                    wire:loading.attr="disabled">
                                    <span wire:loading wire:target="loadMoreWeddings"
                                        class="spinner-border spinner-border-sm me-1"></span>
                                    Load More Weddings
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>




            </div>

            <!-- Events -->
            <div x-show="activeTab === 'events'" class="tab-pane fade show active" id="events" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="portfolio-section portfolio pt-0 pb-60">
                        <div class="row">
                            @foreach ($events as $event)
                            <div class="col-md-4">
                                <div class="item " data-animate-effect="fadeInLeft">
                                    <div class="portfolio-img">
                                        <a
                                            href="{{ route('makeup.event.detail', ['eventMakeupSlug' => optional($event->eventMakeup)->slug, 'slug' => $event->slug]) }}">
                                            <img src="{{ asset('storage/back/images/event/eventmakeup/thumbnails/thumb_' . $event->image) }}"
                                                alt="{{ $event->image_alt_text }}" class="img-fluid rounded">
                                        </a>
                                    </div>
                                    <div class="content text-center">
                                        <h5>
                                            <a
                                                href="{{ route('makeup.event.detail', ['eventMakeupSlug' => optional($event->eventMakeup)->slug, 'slug' => $event->slug]) }}">
                                                {{ $event->name }}
                                            </a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if (!$eventsEnd)
                        <div class="text-center mt-3">
                            <div x-show="intersectSupported" x-intersect.once="$wire.loadMoreEvents()">
                                <div wire:loading wire:target="loadMoreEvents">
                                    <span class="spinner-border spinner-border-sm" role="status"></span> Loading more
                                    events...
                                </div>
                            </div>
                            <div x-show="!intersectSupported">
                                <button wire:click="loadMoreEvents" class="btn text-white"
                                    style="background-color: #a2783a; border: 1px solid #a2783a;"
                                    wire:loading.attr="disabled">
                                    <span wire:loading wire:target="loadMoreEvents"
                                        class="spinner-border spinner-border-sm me-1"></span>
                                    Load More Events
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>