<div>
    <div class="sidebar-widget popular-posts mt-3">
        <div class="sidebar-title">
            <h4>Recommended Posts</h4>
        </div>
@foreach (recommended_post() as $post)

        <article class="post">
            <figure class="post-thumb"><img src="{{ asset('storage/back/images/post_images/thumbnails/thumb_' . $post->featured_image) }}"
                alt="{{ $post->post_title }}">
                <a
                    href="{{ route('blog.detail', $post->slug) }}" class="overlay-box"><span
                        class="icon"></span></a></figure>
            <div class="text"><a href="{{ route('blog.detail', $post->slug) }}">{{ $post->post_title }}</a></div>
            <div class="post-info">{{ date_formatter($post->created_at) }}</div>
        </article>
    @endforeach
</div>
</div>
