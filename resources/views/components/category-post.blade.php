<div>
    <div class="sidebar-widget sidebar-blog-category mt-3">
        <div class="sidebar-title">
            <h4>Categories</h4>
        </div>
        <ul class="blog-cat">
            @foreach (categories() as $item)
                <li><a href="{{ route('blog.category', $item->slug) }}">{{ $item->subcategory_name }} <span>{{$item->posts->count()}}</span></a></li>
            @endforeach
        </ul>
    </div>
</div>
