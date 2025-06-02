<div>
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

                        <div class="pwe-sidebar-block pwe-sidebar-block-categories">
                            <div class="pwe-sidebar-block-title"> Categories </div>
                            <div class="pwe-sidebar-block-content">
                                <x-category-post />
                            </div>
                        </div>
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
</div>