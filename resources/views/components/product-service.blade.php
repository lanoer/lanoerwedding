    <div>
        <div class="sidebar-widget popular-posts mt-3">
            <div class="sidebar-title">
                <h4>Product & Service</h4>
            </div>
            @php
                $services = random_services();
            @endphp
            @if ($services->isNotEmpty())
                @foreach ($services as $service)
                    <article class="post">
                        <figure class="post-thumb"><img src="{{ asset('storage/back/images/service_images/thumbnails/small_' . $service->featured_image) }}"
                                alt="{{ $service->service_title }}"><a href="{{ route('product.detail',
                                                    ['servicecategory' => $service->subServiceCategory->parentservice->slug,
                                                    'subservicecategory' => $service->subServiceCategory->slug]) }}" class="overlay-box"><span
                                    class="icon fa fa-link"></span></a></figure>
                        <div class="text"><a href="{{ route('product.detail',
                                                    ['servicecategory' => $service->subServiceCategory->parentservice->slug,
                                                    'subservicecategory' => $service->subServiceCategory->slug]) }}">{{ $service->service_title }}</a></div>
                        <div class="post-info">{{ date_formatter($service->created_at) }}</div>
                    </article>
                @endforeach
            @else
                <p>No services available at the moment.</p>
            @endif

        </div>
    </div>
