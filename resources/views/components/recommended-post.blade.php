<div class="pwe-sidebar-block pwe-sidebar-block-latest-posts">
    <div class="pwe-sidebar-block-title"> Recommended Posts </div>
    <div class="pwe-sidebar-block-content">
        @foreach (recommended_post() as $post)
        <div class="latest">
            <a href="{{ route('blog.detail', $post->slug) }}" class="clearfix">
                <div class="txt1">{{ $post->post_title }}</div>
                <div class="txt2">{{ date_formatter($post->created_at) }}</div>
            </a>
        </div>
        @endforeach
    </div>
</div>