@extends('front.layouts.pages-home')

@section('pageTitle', webInfo()->web_name . ' | ' . $query)
@push('meta')
{!! SEO::generate() !!}
@endpush
@push('schema')
{!! $searchSchema->toScript() !!}
@endpush

@push('css')
<!-- Tambahkan CDN Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">{{ $query }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog -->
    <div class="blog-section pt-0 pb-60">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    @if ($posts->isEmpty())
                    <div class="col-12">
                        <style>
                            /* Custom Styles for Notification Card */
                            .card-notification {
                                border: none;
                                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                border-radius: 10px;
                                margin-bottom: 20px;
                            }

                            .card-notification .card-header {
                                background-color: #f8d7da;
                                color: #e1091f;
                                font-weight: bold;
                                border-radius: 10px 10px 0 0;
                            }

                            .card-notification .card-body {
                                background-color: #fff3f3;
                                color: #e1091f;
                                font-size: 1rem;
                                padding: 20px;
                            }

                            .card-notification .close-btn {
                                color: #e1091f;
                                font-size: 1.25rem;
                                border: none;
                                background: transparent;
                                cursor: pointer;
                            }

                            /* Responsive design */
                            @media (max-width: 768px) {
                                .card-notification {
                                    margin: 10px;
                                }
                            }
                        </style>
                        <div class="card card-notification">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Informasi Pencarian</span>
                                <button class="close-btn" aria-label="Close"
                                    onclick="this.closest('.card').remove()">×</button>
                            </div>
                            <div class="card-body">
                                <p>Mohon maaf, kami tidak dapat menemukan hasil untuk pencarian: "<strong
                                        style="color: #c82630;">{{ $query
                                        }}</strong>". Silakan coba dengan kata kunci lain.</p>
                            </div>
                        </div>


                        @if (!empty($suggestions))
                        <div class="card" style="border: none;">
                            <div class="card-header center">
                                <i class="fas fa-lightbulb" style="color: orange"></i>
                                Kami mendeteksi beberapa saran pencarian:
                            </div>
                            <div class="card-body">
                                <style>
                                    .list-unstyled {
                                        list-style-type: disc;
                                        padding-left: -5px;
                                    }

                                    .list-item a {
                                        color: blue;
                                        text-decoration: underline;
                                    }
                                </style>
                                <ul class="list-unstyled">
                                    @foreach ($suggestions as $suggestion)
                                    <li class="list-item"><a
                                            href="{{ route('blog.search', ['query' => $suggestion]) }}">{{ $suggestion
                                            }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @else
                        <p>kami tidak menemukan saran pencarian yang relevan.</p>
                        @endif
                    </div>
                    @else


                    @foreach($posts as $post)
                    <div class="blog-entry animate-box" data-animate-effect="fadeInLeft">
                        <a href="post.html" class="blog-img"><img
                                src="{{ asset('storage/back/images/post_images/thumbnails/resized_' . $post->featured_image) }}"
                                class="img-fluid" alt=""></a>
                        <div class="desc"> <span><small>{{ date_formatter($post->created_at) }} | {{
                                    $post->subcategory->subcategory_name }}</small></span>
                            <h3><a href="{{ route('blog.detail', $post->slug) }}">{{ $post->post_title }}</a></h3>
                            <p>{!! words($post->post_content, 15) !!}</p>
                            <div class="btn-contact"><a href="{{ route('blog.detail', $post->slug) }}"><span>Read
                                        More</span></a></div>
                        </div>
                    </div>

                    @endforeach
                    @endif
                    <!-- Pagination -->
                    {{ $posts->links('vendor.pagination.custom') }}
                </div>
                <div class="col-sm-4">
                    <div class="pwe-sidebar-part animate-box" data-animate-effect="fadeInLeft">
                        <!-- Search Blog -->
                        <x-search-blog />


                        <x-category-post />

                        {{-- related posts --}}
                        <x-recommended-post />
                        <div class="pwe-sidebar-block pwe-sidebar-block-tags">
                            <div class="pwe-sidebar-block-title"> Tags </div>
                            <div class="pwe-sidebar-block-content">
                                <ul class="tags clearfix">
                                    @foreach (all_tags() as $item)
                                    <li><a href="{{ route('blog.tag', $item) }}">{{ $item }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team -->
    @include('front.layouts.inc.clients')

    @include('front.layouts.inc.footer')
</div>
@endsection