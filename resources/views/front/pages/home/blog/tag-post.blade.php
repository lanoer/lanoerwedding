@extends('front.layouts.pages-home')

@section('pageTitle', webInfo()->web_name . ' | ' . $currentTag)
@push('meta')
{!! SEO::generate() !!}
@endpush
@push('schema')
{!! $tagSchema->toScript() !!}
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
                            <h2 class="pwe-heading animate-box" data-animate-effect="fadeInLeft">{{ $currentTag }}</h2>
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
                    @forelse ($posts as $post)
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
                    @empty
                    <div class="blog-entry animate-box" data-animate-effect="fadeInLeft">
                        <h3>No posts found</h3>
                    </div>
                    @endforelse

                    <!-- Pagination -->
                    {{ $posts->links('vendor.pagination.custom') }}
                </div>
                <div class="col-sm-4">
                    <div class="pwe-sidebar-part animate-box" data-animate-effect="fadeInLeft">
                        <!-- Search Blog -->
                        <x-search-blog />


                        <x-category-post />

                        {{-- related posts --}}
                        @if ($related_post->isNotEmpty())

                        <div class="pwe-sidebar-block pwe-sidebar-block-latest-posts">
                            <div class="pwe-sidebar-block-title"> Related Posts </div>
                            <div class="pwe-sidebar-block-content">
                                @foreach ($related_post as $related)
                                <div class="latest">
                                    <a href="{{ route('blog.detail', $related->slug) }}" class="clearfix">
                                        <div class="txt1">{{ $related->post_title }}</div>
                                        <div class="txt2">{{ date_formatter($related->created_at) }}</div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="pwe-sidebar-block pwe-sidebar-block-latest-posts">
                            <div class="pwe-sidebar-block-title"> Related Posts </div>
                            <div class="pwe-sidebar-block-content">
                                <div class="latest">
                                    <p>No related posts available.</p>
                                </div>
                            </div>
                        </div>
                        @endif
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