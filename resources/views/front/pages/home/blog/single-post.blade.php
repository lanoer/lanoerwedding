@extends('front.layouts.pages-home')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Blog Detail')
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
                        <div class="col-md-12"> <span class="heading-meta">.read</span>
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">{{ $posts->post_title
                                }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog -->
    <!-- Post -->
    <style>
        .about-section ul,
        .about-section ol {
            list-style: initial;
            margin-left: 1.5em;
        }
    </style>
    <div class="post-section pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 image-content animate-box" data-animate-effect="fadeInLeft"> <img
                        src="{{ asset('storage/back/images/post_images/' . $posts->featured_image) }}"
                        class="img-fluid mb-30" alt=""> </div>
                {{-- Social Share --}}
                <style>
                    .social-share {
                        display: flex;
                        justify-content: center;
                        gap: 12px;
                        margin-bottom: 1rem;
                    }

                    .social-share a {
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        width: 38px;
                        height: 38px;
                        border-radius: 50%;
                        background: #f5f5f5;
                        transition: background 0.2s, box-shadow 0.2s;
                        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
                        text-decoration: none;
                        overflow: visible;
                    }

                    .social-share a:hover {
                        background: #e0e0e0;
                        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
                    }

                    .social-share svg {
                        width: 22px;
                        height: 22px;
                        display: block;
                        transition: transform 0.2s;
                    }

                    .social-share a:hover svg {
                        transform: scale(1.18);
                    }

                    /* Tooltip */
                    .social-share a .tooltip-share {
                        visibility: hidden;
                        opacity: 0;
                        width: max-content;
                        background: #222;
                        color: #fff;
                        text-align: center;
                        border-radius: 4px;
                        padding: 2px 10px;
                        position: absolute;
                        z-index: 1;
                        bottom: 120%;
                        left: 50%;
                        transform: translateX(-50%);
                        font-size: 12px;
                        pointer-events: none;
                        transition: opacity 0.2s, visibility 0.2s;
                        white-space: nowrap;
                    }

                    .social-share a:hover .tooltip-share {
                        visibility: visible;
                        opacity: 1;
                    }
                </style>
                <div class="social-share">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                        target="_blank" title="Share to Facebook">
                        <span class="tooltip-share">Share</span>
                        <svg fill="#1877f3" viewBox="0 0 24 24">
                            <path
                                d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/?url={{ urlencode(Request::fullUrl()) }}" target="_blank"
                        title="Share to Instagram">
                        <span class="tooltip-share">Share</span>
                        <svg fill="#E4405F" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.974.974 1.246 2.241 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.974.974-2.241 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.974-.974-1.246-2.241-1.308-3.608C2.175 15.647 2.163 15.267 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608C4.515 2.567 5.782 2.295 7.148 2.233 8.414 2.175 8.794 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.771.131 4.659.363 3.678 1.344 2.697 2.325 2.465 3.437 2.406 4.718 2.347 5.998 2.334 6.407 2.334 12c0 5.593.013 6.002.072 7.282.059 1.281.291 2.393 1.272 3.374.981.981 2.093 1.213 3.374 1.272 1.28.059 1.689.072 7.282.072s6.002-.013 7.282-.072c1.281-.059 2.393-.291 3.374-1.272.981-.981 1.213-2.093 1.272-3.374.059-1.28.072-1.689.072-7.282s-.013-6.002-.072-7.282c-.059-1.281-.291-2.393-1.272-3.374C21.393.363 20.281.131 19 .072 17.719.013 17.31 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a3.999 3.999 0 1 1 0-7.998 3.999 3.999 0 0 1 0 7.998zm6.406-11.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z" />
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($posts->post_title) }}"
                        target="_blank" title="Share to Twitter">
                        <span class="tooltip-share">Share</span>
                        <svg fill="#1da1f2" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557a9.83 9.83 0 0 1-2.828.775 4.932 4.932 0 0 0 2.165-2.724c-.951.555-2.005.959-3.127 1.184A4.916 4.916 0 0 0 16.616 3c-2.717 0-4.924 2.206-4.924 4.924 0 .386.044.763.127 1.124C7.728 8.807 4.1 6.884 1.671 3.965c-.423.724-.666 1.561-.666 2.475 0 1.708.87 3.216 2.188 4.099a4.904 4.904 0 0 1-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.936 4.936 0 0 1-2.224.084c.627 1.956 2.444 3.377 4.6 3.417A9.867 9.867 0 0 1 0 21.543a13.94 13.94 0 0 0 7.548 2.212c9.057 0 14.009-7.513 14.009-14.009 0-.213-.005-.425-.014-.636A10.012 10.012 0 0 0 24 4.557z" />
                        </svg>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(Request::fullUrl()) }}&text={{ urlencode($posts->post_title) }}"
                        target="_blank" title="Share to Telegram">
                        <span class="tooltip-share">Share</span>
                        <svg fill="#0088cc" viewBox="0 0 24 24">
                            <path
                                d="M12 0C5.373 0 0 5.373 0 12c0 6.627 5.373 12 12 12s12-5.373 12-12c0-6.627-5.373-12-12-12zm5.707 7.293l-2.828 10.607c-.211.789-.678.978-1.372.609l-3.799-2.803-1.833.883c-.202.099-.384.183-.786.183l.28-3.963 7.225-6.531c.314-.28-.069-.437-.486-.157l-8.933 5.625-3.844-1.2c-.834-.257-.849-.834.174-1.236l15.437-5.953c.711-.276 1.334.17 1.104 1.13z" />
                        </svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode(Request::fullUrl()) }}" target="_blank"
                        title="Share to WhatsApp">
                        <span class="tooltip-share">Share</span>
                        <svg fill="#25d366" viewBox="0 0 24 24">
                            <path
                                d="M20.52 3.48A11.93 11.93 0 0 0 12 0C5.373 0 0 5.373 0 12c0 2.11.55 4.16 1.6 5.96L0 24l6.26-1.64A11.93 11.93 0 0 0 12 24c6.627 0 12-5.373 12-12 0-3.19-1.24-6.19-3.48-8.52zM12 22c-1.85 0-3.68-.5-5.26-1.44l-.37-.22-3.72.98.99-3.62-.24-.38A9.96 9.96 0 0 1 2 12c0-5.52 4.48-10 10-10s10 4.48 10 10-4.48 10-10 10zm5.2-7.6c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.43-2.25-1.37-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.34.42-.51.14-.17.18-.29.28-.48.09-.19.05-.36-.02-.5-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.35-.01-.54-.01-.19 0-.5.07-.76.34-.26.27-1 1-.99 2.43.01 1.43 1.03 2.81 1.18 3 .15.19 2.03 3.1 4.93 4.23.69.3 1.23.48 1.65.61.69.22 1.32.19 1.81.12.55-.08 1.65-.67 1.88-1.32.23-.65.23-1.21.16-1.32-.07-.11-.25-.18-.53-.32z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                    <p>{!! $posts->post_content !!}</p>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 animate-box" data-animate-effect="fadeInLeft">
                    <!-- Comments & Leave a Comment (Livewire) -->
                    <div class="clear" id="comment-list">
                        @livewire('front.page.comment', ['post' => $posts])
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team -->

    @include('front.layouts.inc.footer')
</div>
@endsection